<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\ScheduleDetail;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\WinnerAhp;
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
            ->with('success', 'Hasil jadwal berhasil disimpan.');
    }

    public function winners(Request $request)
    {
        $month = $request->input('month', date('n'));
        $year = $request->input('year', date('Y'));

        // Ambil data pemenang berdasarkan bulan dan tahun
        $winners = WinnerAhp::where('month', $month)
            ->where('year', $year)
            ->with('user')
            ->get();

        return view('pages.game.listCustomer', compact('winners', 'month', 'year'));
    }

    public function list(Request $request)
    {
        // Get the selected year from the request
        $year = $request->input('year', date('Y'));

        // Fetch the winners for the selected year and order by month in ascending order
        $winners = WinnerAhp::where('year', $year)
            ->with('user') // Assuming 'user' is a relationship on the WinnerAhp model
            ->orderBy('month', 'asc') // Sort by month in ascending order
            ->get();

        return view('pages.game.listCustomer', compact('winners'));
    }


    public function bestCustomerAHP(Request $request)
    {
        $month = $request->input('month', date('n'));
        $year = $request->input('year', date('Y'));

        $jadwal = Game::whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get();

        if ($jadwal->isEmpty()) {
            return view('pages.game.bestCustomer', [
                'message' => 'Tidak ada data jadwal ditemukan untuk bulan yang ditentukan.',
                'bestCustomer' => null,
                'userScores' => []
            ]);
        }

        // Menyiapkan data kriteria
        $dataKriteria = [];
        foreach ($jadwal as $l) {
            $idPengguna = $l->id_user;
            if (!isset($dataKriteria[$idPengguna])) {
                $dataKriteria[$idPengguna] = [
                    'jumlah_berat' => 0,
                    'jumlah_ikan' => 0,
                    'jumlah_datang' => 0,
                ];
            }
            $totalBerat = $l->ikanterberat_sesi1 + $l->ikanterberat_sesi2;
            $dataKriteria[$idPengguna]['jumlah_berat'] += $totalBerat;
            $dataKriteria[$idPengguna]['jumlah_ikan'] += $l->ikanterbanyak ?? 0;
            $dataKriteria[$idPengguna]['jumlah_datang'] += 1;
        }

        Log::debug('Data Kriteria:', $dataKriteria);

        $matriksKriteria = [
            [1, 0.333, 0.2],
            [3, 1, 0.333],
            [5, 3, 1]
        ];

        // Normalisasi matriks dan menghitung prioritas
        $matriksNormalisasiKriteria = $this->normalisasiMatriks($matriksKriteria);
        $bobotKriteria = $this->hitungVektorPrioritas($matriksNormalisasiKriteria);

        Log::debug('Bobot Kriteria:', $bobotKriteria);

        $matriksSubKriteria = [
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
            'jumlah_datang' => [
                [1, 1 / 3, 1 / 5],
                [3, 1, 1 / 3],
                [5, 3, 1]
            ]
        ];

        // Normalisasi matriks dan menghitung prioritas untuk subkriteria
        $bobotSubKriteria = [];
        foreach ($matriksSubKriteria as $key => $subMatriks) {
            $bobotSubKriteria[$key] = $this->hitungBobotSubKriteria($subMatriks);
            Log::debug("Bobot Sub-Kriteria untuk $key:", $bobotSubKriteria[$key]);
        }

        // Hitung skor untuk setiap pengguna
        $skorPengguna = [];
        foreach ($dataKriteria as $idPengguna => $data) {
            $skorPenggunaIndividu = 0;
            // Hitung skor untuk setiap kriteria
            foreach (['jumlah_berat', 'jumlah_ikan', 'jumlah_datang'] as $index => $kriteria) {
                $nilai = $data[$kriteria];
                $bobotSub = $bobotSubKriteria[$kriteria];

                // Pilih sub indeks berdasarkan nilai kriteria
                switch ($kriteria) {
                    case 'jumlah_berat':
                        $subIndeks = $this->getIndeksBerat($nilai);
                        break;
                    case 'jumlah_ikan':
                        $subIndeks = $this->getIndeksJumlahIkan($nilai);
                        break;
                    case 'jumlah_datang':
                        $subIndeks = $this->getIndeksJumlahjadwal($nilai);
                        break;
                    default:
                        $subIndeks = 0;
                }

                // Ambil bobot kriteria dan sub kriteria
                $skorKriteria = $bobotKriteria[$index] * $bobotSub[$subIndeks];
                $skorPenggunaIndividu += $skorKriteria;
            }

            // Masukkan skor total ke dalam array
            $skorPengguna[$idPengguna] = number_format($skorPenggunaIndividu, 3, '.', '');
        }

        arsort($skorPengguna);
        // Mendapatkan ID pelanggan dengan skor terbaik (key pertama dari array skorPengguna)
        $idPelangganTerbaik = key($skorPengguna);

        // Mencari data lengkap pengguna (pelanggan) berdasarkan ID yang didapat
        $pelangganTerbaik = User::find($idPelangganTerbaik);

        if ($pelangganTerbaik) {
            WinnerAhp::updateOrCreate(
                [
                    'month' => $month,
                    'year' => $year,
                ],
                [
                    'id_user' => $idPelangganTerbaik,
                    'score' => $skorPengguna[$idPelangganTerbaik],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        return view('pages.game.bestCustomer', [
            'bestCustomer' => $pelangganTerbaik,
            'userScores' => $skorPengguna,
            'message' => $pelangganTerbaik ? null : 'Tidak ada pelanggan terbaik untuk periode ini.'
        ]);
    }

    // Matriks Nilai Kriteria
    private function normalisasiMatriks($matriks)
    {
        $jumlahKolom = array_fill(0, count($matriks[0]), 0);
        //digunakan untuk membuat sebuah array baru dengan jumlah elemen yang sesuai dengan jumlah kolom dalam matriks pertama
        foreach ($matriks as $baris) { //untuk mengakses setiap baris dalam matriks.
            foreach ($baris as $j => $nilai) { // untuk mengakses setiap elemen kolom dalam baris.
                $jumlahKolom[$j] += $nilai;
            }
        }

        $matriksNormalisasi = [];
        foreach ($matriks as $baris) {
            $barisNormalisasi = [];
            foreach ($baris as $j => $nilai) {
                $barisNormalisasi[$j] = $nilai / $jumlahKolom[$j];
            }
            $matriksNormalisasi[] = $barisNormalisasi;
        }

        return $matriksNormalisasi;
    }

    // Hitung bobot prioritas
    private function hitungVektorPrioritas($matriksNormalisasi)
    {
        $vektorPrioritas = [];
        foreach ($matriksNormalisasi as $baris) {
            $vektorPrioritas[] = number_format(array_sum($baris) / count($baris), 3, '.', '');
        }

        return $vektorPrioritas;
    }

    // Matriks Nilai Kriteria Subkriteria
    private function hitungBobotSubKriteria($matriksSubKriteria)
    {
        // Langkah 1: Normalisasi matriks
        $matriksNormalisasi = $this->normalisasiMatriks($matriksSubKriteria);

        // Langkah 2: Hitung vektor prioritas
        $vektorPrioritas = $this->hitungVektorPrioritas($matriksNormalisasi);

        return $vektorPrioritas;
    }

    private function getIndeksBerat($berat)
    {
        if ($berat <= 1500) return 0;
        if ($berat < 2300) return 1;
        return 2;
    }

    private function getIndeksJumlahIkan($jumlah)
    {
        if ($jumlah <= 60) return 0;
        if ($jumlah < 100) return 1;
        return 2;
    }

    private function getIndeksJumlahjadwal($jadwal)
    {
        if ($jadwal < 5) return 0;
        if ($jadwal < 10) return 1;
        return 2;
    }
}
