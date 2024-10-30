<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\ScheduleDetail;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\Log;

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
}
