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
        $selectedSchedule = $request->input('id_schedule'); 

        $schedules = Schedule::orderBy('date', 'desc')->get();

        $scheduleDetails = [];

        if ($selectedSchedule) {
            $scheduleDetails = ScheduleDetail::with(['user', 'game'])
                ->where('id_schedule', $selectedSchedule) 
                ->get();
        }

        return view('pages.game.indexAdmin', compact('schedules', 'scheduleDetails', 'selectedSchedule'));
    }


    public function indexUser(Request $request)
    {
        $selectedSchedule = $request->input('id_schedule'); 

        $schedules = Schedule::orderBy('date', 'desc')->get();

        $scheduleDetails = [];

        if ($selectedSchedule) {
            $scheduleDetails = ScheduleDetail::with(['user', 'game'])
                ->where('id_schedule', $selectedSchedule)
                ->get();
        }

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
        // Get the month and year from the request, default to the current month and year if not provided
        $month = $request->input('month', date('n'));
        $year = $request->input('year', date('Y'));

        // Retrieve games for the specified month and year
        $games = Game::whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get();

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
        $criteriaWeights = $this->calculatePriorityVector($normalizedCriteriaMatrix);

        // Debug: Log criteria weights
        Log::debug('Criteria Weights:', $criteriaWeights);

        // Define sub-criteria matrices for each main criterion
        $subCriteriaMatrices = [
            'jumlah_berat' => [
                [1, 1 / 2, 1 / 3],
                [2, 1, 1 / 2],
                [3, 2, 1]
            ],
            'jumlah_ikan' => [
                [1, 1 / 1.5, 1 / 2],
                [1.5, 1, 1 / 2],
                [2, 2, 1]
            ],
            'jumlah_lomba' => [
                [1, 1 / 3, 1 / 5],
                [3, 1, 1 / 3],
                [5, 3, 1]
            ]
        ];

        // Step 4: Calculate Sub-Criteria Weights
        $subCriteriaWeights = [];
        foreach ($subCriteriaMatrices as $key => $subMatrix) {
            $subCriteriaWeights[$key] = $this->calculateSubCriteriaWeights($subMatrix);

            // Debug: Log sub-criteria weights
            Log::debug("Sub-Criteria Weights for $key:", $subCriteriaWeights[$key]);
        }

        // Step 5: Calculate scores for each user
        $userScores = [];
        foreach ($criteriaData as $userId => $data) {
            $userScore = 0;

            // Calculate score for each criterion
            foreach (['jumlah_berat', 'jumlah_ikan', 'jumlah_lomba'] as $index => $criterion) {
                $value = $data[$criterion];
                $subWeights = $subCriteriaWeights[$criterion];

                // Determine which index in the sub-criteria to use
                switch ($criterion) {
                    case 'jumlah_berat':
                        $subIndex = $this->getWeightIndex($value);
                        break;
                    case 'jumlah_ikan':
                        $subIndex = $this->getFishCountIndex($value);
                        break;
                    case 'jumlah_lomba':
                        $subIndex = $this->getGamesPlayedIndex($value);
                        break;
                    default:
                        $subIndex = 0; // Default index if no match
                }

                // Aggregate the score for this criterion
                $userScore += $criteriaWeights[$index] * $subWeights[$subIndex];
            }

            // Store user score
            $userScores[$userId] = number_format($userScore, 3, '.', '');
        }

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
            $priorityVector[] = number_format(array_sum($row) / count($row), 3, '.', '');
        }

        return $priorityVector;
    }


    private function calculateSubCriteriaWeights($subCriteriaMatrix)
    {
        // Step 1: Normalize the matrix
        $normalizedMatrix = $this->normalizeMatrix($subCriteriaMatrix);

        // Step 2: Calculate priority vector
        $priorityVector = $this->calculatePriorityVector($normalizedMatrix);

        return $priorityVector;
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
