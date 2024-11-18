<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\ScheduleDetail;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Carbon\Carbon;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $schedules = Schedule::all()->map(function ($schedule) {
            $schedule->formatted_title = "{$schedule->activity_name} - {$schedule->date}";
            return $schedule;
        });

        $scheduleDetails = [];
        $selectedSchedule = null;

        if ($request->has('id_schedule') && $request->id_schedule) {
            $selectedSchedule = $request->id_schedule;
            $scheduleDetails = ScheduleDetail::with(['user', 'game'])
                ->where('id_schedule', $selectedSchedule)
                ->get();
        }

        return view('pages.game.indexAdmin', compact('schedules', 'scheduleDetails', 'selectedSchedule'));
    }

    public function indexUser(Request $request)
    {
        $selectedSchedule = $request->input('id_schedule');

        $schedules = Schedule::all();
        $scheduleDetails = ScheduleDetail::with(['user', 'game'])
            ->when($selectedSchedule, function ($query) use ($selectedSchedule) {
                return $query->where('id_schedule', $selectedSchedule);
            })
            ->get();

        return view('pages.game.indexUser', compact('schedules', 'selectedSchedule', 'scheduleDetails'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_schedule_detail' => 'required|array',
            'ikanterberat_sesi1' => 'required|array',
            'ikanterberat_sesi2' => 'required|array',
            'ikanterbanyak' => 'required|array',
            'pemenang' => 'required|array',
            'id_schedule' => 'required|integer',
        ]);

        // Mengambil tanggal dari jadwal yang dipilih
        $selectedScheduleDate = Schedule::where('id_schedule', $request->id_schedule)->value('date');

        foreach ($request->id_schedule_detail as $key => $id_schedule_detail) {
            $scheduleDetail = ScheduleDetail::find($id_schedule_detail);
            if ($scheduleDetail) {
                Game::updateOrCreate(
                    ['id_schedule_detail' => $id_schedule_detail],
                    [
                        'id_user' => $scheduleDetail->id_user,
                        'id_schedule' => $request->id_schedule,
                        'date' => $selectedScheduleDate, // Simpan tanggal dari jadwal
                        'ikanterberat_sesi1' => $request->ikanterberat_sesi1[$key] ?? 0,
                        'ikanterberat_sesi2' => $request->ikanterberat_sesi2[$key] ?? 0,
                        'ikanterbanyak' => $request->ikanterbanyak[$key] ?? 0,
                        'pemenang' => $request->pemenang[$key] ?? 0,
                    ]
                );
            }
        }

        return redirect()->route('games.index', ['id_schedule' => $request->id_schedule])
            ->with('success', 'Hasil lomba berhasil disimpan.');
    }

    public function bestCustomerAHP(Request $request)
    {
        // Get the month from the request, default to the current month if not provided
        $month = $request->input('month', date('n'));

        // Retrieve games for the specified month
        $games = Game::whereMonth('date', $month)->get();

        if ($games->isEmpty()) {
            return view('pages.game.bestCustomer', [
                'message' => 'No game data found for the specified month.',
                'bestCustomer' => null,
                'userScores' => []
            ]);
        }

        // Step 1: Prepare criteria data
        $criteriaData = [];
        foreach ($games as $game) {
            $userId = $game->id_user;
            if (!isset($criteriaData[$userId])) {
                $criteriaData[$userId] = [
                    'jumlah_berat' => 0,
                    'jumlah_ikan' => 0,
                    'jumlah_lomba' => 0,
                ];
            }
            $totalWeight = $game->ikanterberat_sesi1 + $game->ikanterberat_sesi2;
            $criteriaData[$userId]['jumlah_berat'] += $totalWeight;
            $criteriaData[$userId]['jumlah_ikan'] += $game->ikanterbanyak ?? 0;
            $criteriaData[$userId]['jumlah_lomba'] += 1;
        }

        // Debug: Log criteria data
        Log::debug('Criteria Data:', $criteriaData);

        // Step 2: Define the AHP matrices for the criteria
        $criteriaMatrix = [
            [1, 0.333, 0.2],
            [3, 1, 0.333],
            [5, 3, 1]
        ];

        // Step 3: Normalize the criteria matrix
        $normalizedCriteriaMatrix = $this->normalizeMatrix($criteriaMatrix);
        $normalizedCriteriaMatrix = array_map(function ($row) {
            return array_map(function ($value) {
                return number_format($value, 3, '.', '');
            }, $row);
        }, $normalizedCriteriaMatrix);

        // Debug: Log normalized criteria matrix
        Log::debug('Normalized Criteria Matrix:', $normalizedCriteriaMatrix);

        // Step 4: Calculate priority vector for criteria
        $criteriaWeights = $this->calculatePriorityVector($normalizedCriteriaMatrix);
        $criteriaWeights = array_map(function ($value) {
            return number_format($value, 3, '.', '');
        }, $criteriaWeights);

        // Debug: Log criteria weights
        Log::debug('Criteria Weights:', $criteriaWeights);

        // Define sub-criteria matrices for each main criterion
        $subCriteriaMatrices = [
            'jumlah_berat' => [
                [1, 0.5, 0.333],
                [2, 1, 0.5],
                [3, 2, 1]
            ],
            'jumlah_ikan' => [
                [1, 0.667, 0.5],
                [1.5, 1, 0.5],
                [2, 2, 1]
            ],
            'jumlah_lomba' => [
                [1, 0.333, 0.2],
                [3, 1, 0.333],
                [5, 3, 1]
            ]
        ];

        // Step 5: Calculate scores for each user based on sub-criteria
        $userScores = [];
        foreach ($criteriaData as $userId => $data) {
            $subCriteriaScores = [];

            // Jumlah Berat Score
            $jumlahBerat = $data['jumlah_berat'];
            $weightIndex = $this->getWeightIndex($jumlahBerat);
            $subCriteriaScores['jumlah_berat'] = $this->calculateSubCriteriaScore($subCriteriaMatrices['jumlah_berat'], $weightIndex);

            // Log jumlah berat score
            Log::debug("User ID: $userId - Jumlah Berat: $jumlahBerat, Weight Index: $weightIndex, Score: {$subCriteriaScores['jumlah_berat']}");

            // Log the weight per sub-criteria
            Log::debug("User ID: $userId - Sub-Criteria Weight for Jumlah Berat: {$subCriteriaMatrices['jumlah_berat'][$weightIndex][0]}");

            // Jumlah Ikan Score
            $jumlahIkan = $data['jumlah_ikan'];
            $ikanIndex = $this->getFishCountIndex($jumlahIkan);
            $subCriteriaScores['jumlah_ikan'] = $this->calculateSubCriteriaScore($subCriteriaMatrices['jumlah_ikan'], $ikanIndex);

            // Log jumlah ikan score
            Log::debug("User ID: $userId - Jumlah Ikan: $jumlahIkan, Fish Count Index: $ikanIndex, Score: {$subCriteriaScores['jumlah_ikan']}");

            // Log the weight per sub-criteria
            Log::debug("User ID: $userId - Sub-Criteria Weight for Jumlah Ikan: {$subCriteriaMatrices['jumlah_ikan'][$ikanIndex][0]}");

            // Jumlah Lomba Score
            $jumlahLomba = $data['jumlah_lomba'];
            $lombaIndex = $this->getGamesPlayedIndex($jumlahLomba);
            $subCriteriaScores['jumlah_lomba'] = $this->calculateSubCriteriaScore($subCriteriaMatrices['jumlah_lomba'], $lombaIndex);

            // Log jumlah lomba score
            Log::debug("User ID: $userId - Jumlah Lomba: $jumlahLomba, Games Played Index: $lombaIndex, Score: {$subCriteriaScores['jumlah_lomba']}");

            // Log the weight per sub-criteria
            Log::debug("User ID: $userId - Sub-Criteria Weight for Jumlah Lomba: {$subCriteriaMatrices['jumlah_lomba'][$lombaIndex][0]}");

            // Aggregate scores
            $userScores[$userId] =
                ($criteriaWeights[0] * $subCriteriaScores['jumlah_berat']) +
                ($criteriaWeights[1] * $subCriteriaScores['jumlah_ikan']) +
                ($criteriaWeights[2] * $subCriteriaScores['jumlah_lomba']);

            $userScores[$userId] = number_format($userScores[$userId], 3, '.', ''); // Format the final score
        }

        // Debug: Log user scores
        Log::debug('User Scores:', $userScores);

        // Step 6: Rank users based on scores
        arsort($userScores);
        $bestCustomerId = key($userScores);
        $bestCustomer = User::find($bestCustomerId);

        return view('pages.game.bestCustomer', [
            'bestCustomer' => $bestCustomer,
            'userScores' => $userScores,
            'message' => $bestCustomer ? null : 'No best customer found for this period.'
        ]);
    }

    private function normalizeMatrix($matrix)
    {
        $columnSums = array_fill(0, count($matrix[0]), 0);
        foreach ($matrix as $row) {
            foreach ($row as $j => $value) {
                $columnSums[$j] += $value;
            }
        }

        $normalizedMatrix = [];
        foreach ($matrix as $row) {
            $normalizedRow = [];
            foreach ($row as $j => $value) {
                $normalizedRow[$j] = $value / $columnSums[$j];
            }
            $normalizedMatrix[] = $normalizedRow;
        }

        return $normalizedMatrix;
    }

    private function calculatePriorityVector($normalizedMatrix)
    {
        $priorityVector = [];
        foreach ($normalizedMatrix as $row) {
            $priorityVector[] = array_sum($row) / count($row);
        }

        return $priorityVector;
    }

    private function calculateSubCriteriaScore($subCriteriaMatrix, $index)
    {
        $normalizedSubMatrix = $this->normalizeMatrix($subCriteriaMatrix);
        return $normalizedSubMatrix[$index][0] ?? 0;
    }

    private function getWeightIndex($weight)
    {
        if ($weight <= 1500) return 0;
        if ($weight < 2300) return 1;
        return 2;
    }

    private function getFishCountIndex($count)
    {
        if ($count <= 60) return 0;
        if ($count < 100) return 1;
        return 2;
    }

    private function getGamesPlayedIndex($games)
    {
        if ($games < 5) return 0;
        if ($games < 10) return 1;
        return 2;
    }
}
