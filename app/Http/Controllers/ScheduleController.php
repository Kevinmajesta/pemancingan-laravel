<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User;
use App\Models\ScheduleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    // Display schedules for admin
    public function indexAdmin(Request $request)
    {
        $sortField = $request->input('sort', 'activity_name');
        $sortDirection = $request->input('direction', 'desc');

        $schedules = Schedule::orderBy($sortField, $sortDirection)->paginate(10);
        return view('pages.schedule.indexAdmin', compact('schedules', 'sortField', 'sortDirection'));
    }


    public function indexUser(Request $request)
    {
        $sortField = $request->input('sort', 'activity_name');
        $sortDirection = $request->input('direction', 'asc');

        $schedules = Schedule::withCount('scheduleDetails')
            ->orderBy($sortField, $sortDirection)
            ->paginate(10);

        foreach ($schedules as $schedule) {
            $startTime = Carbon::parse("{$schedule->date} {$schedule->time}");
            $remainingMinutes = now()->diffInMinutes($startTime, false);

            // Tentukan format waktu dengan satuan atau "Sudah Selesai" jika negatif
            if ($remainingMinutes < 0) {
                $schedule->hours_remaining = "Sudah Selesai";
            } elseif ($remainingMinutes >= 60) {
                $remainingHours = floor($remainingMinutes / 60);
                $schedule->hours_remaining = $remainingHours . ' jam lagi';
            } else {
                $schedule->hours_remaining = $remainingMinutes . ' menit lagi';
            }
        }

        return view('pages.schedule.indexUser', [
            'schedules' => $schedules,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
        ]);
    }



    // Show the form for creating a new schedule
    public function create()
    {
        return view('pages.schedules.create');
    }

    // Store a newly created schedule
    public function store(Request $request)
    {
        $request->validate([
            'activity_name' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'maxqty' => 'required|integer',
            'private_event' => 'nullable|boolean',  // Make sure it's nullable in validation
        ]);

        // If it's a private event, force maxqty to 1
        $maxqty = $request->private_event ? 1 : $request->maxqty;

        // Cukup membuat data tanpa menyertakan id_schedule
        Schedule::create([
            'activity_name' => $request->activity_name,
            'date' => $request->date,
            'time' => $request->time,
            'maxqty' => $maxqty,
        ]);

        return redirect()->route('pages.schedule.indexAdmin')->with('success', 'Jadwal berhasil ditambahkan');
    }

    // Display the specified schedule
    public function show(Schedule $schedule)
    {
        return view('pages.schedules.show', compact('schedule'));
    }

    // Show the form for editing the specified schedule
    public function edit(Schedule $schedule)
    {
        return view('pages.schedule.editschedule.indexAdmin', compact('schedule'));
    }

    // Update the specified schedule
    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'activity_name' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
            'maxqty' => 'required|integer',
        ]);

        $schedule->update($request->all());
        return redirect()->route('pages.schedule.indexAdmin')->with('success', 'Schedule updated successfully.');
    }

    // Remove the specified schedule
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('pages.schedule.indexAdmin')->with('success', 'Schedule deleted successfully.');
    }
}
