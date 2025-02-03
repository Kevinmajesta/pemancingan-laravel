<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Schedule;
use App\Models\Game;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();

        // Jadwal yang sudah lewat
        $schedules = Schedule::where('date', '<', now())->get();

        // Total jumlah schedule
        $totalSchedules = Schedule::count();

        // Pemenang dari jadwal yang sudah lewat
        $winnerLastMonth = null;
        $latestSchedule = Schedule::where('date', '<', now()) // Jadwal yang sudah lewat
                                 ->orderBy('date', 'desc') // Jadwal terbaru
                                 ->first();

        if ($latestSchedule) {
            $winnerLastMonth = Game::where('id_schedule', $latestSchedule->id_schedule)
                ->where('pemenang', '1') 
                ->first();
        }

        // Kirim data ke view
        return view('dashboard.index', [
            'totalUsers' => $totalUsers,
            'schedules' => $schedules,
            'totalSchedules' => $totalSchedules,
            'winnerLastMonth' => $winnerLastMonth,
        ]);
    }

   
}

