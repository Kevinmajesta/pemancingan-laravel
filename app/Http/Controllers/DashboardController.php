<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Schedule;
use App\Models\Champs;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Total pengguna
        $totalUsers = User::count();

        // Schedules aktif (misalnya berdasarkan tanggal mendatang)
        $schedules = Schedule::where('date', '<=', now())->get();

        // Total jumlah schedule
        $totalSchedules = Schedule::count();  // Menambahkan query untuk total jadwal

        // Pemenang bulan kemarin
        $lastMonth = now()->subMonth();
        $winnerLastMonth = Champs::whereYear('date', $lastMonth->year)
            ->whereMonth('date', $lastMonth->month)
            ->orderBy('weight', 'desc') // Utamakan berat tertinggi
            ->first();

        // Kirim data ke view
        return view('dashboard.index', [
            'totalUsers' => $totalUsers,
            'schedules' => $schedules,
            'totalSchedules' => $totalSchedules,  // Kirim total jadwal ke view
            'winnerLastMonth' => $winnerLastMonth,
        ]);
    }
}
