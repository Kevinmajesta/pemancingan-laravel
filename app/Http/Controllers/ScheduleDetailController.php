<?php

namespace App\Http\Controllers;

use App\Models\ScheduleDetail;
use App\Models\Schedule; // Make sure to import the Schedule model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleDetailController extends Controller
{
    public function index($id_schedule)
    {
        // Get the schedule details and users who registered for it
        $schedule = Schedule::findOrFail($id_schedule); // Get schedule information
        $scheduleDetails = ScheduleDetail::with('user')->where('id_schedule', $id_schedule)->get();

        return view('pages.schedule.daftarschedule.indexUser', compact('schedule', 'scheduleDetails'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_schedule' => 'required|exists:schedules,id_schedule',
        ]);

        // Check if the user has already registered for the schedule
        $existingRegistration = ScheduleDetail::where('id_schedule', $request->id_schedule)
            ->where('id_user', Auth::id())
            ->first();

        if ($existingRegistration) {
            return redirect()->route('pages.schedule.daftarschedule.indexUser', $request->id_schedule)
                ->with('error', 'Anda sudah mendaftar untuk jadwal ini.');
        }

        // If no existing registration, create a new one
        ScheduleDetail::create([
            'id_schedule' => $request->id_schedule,
            'id_user' => Auth::id(), // Get the logged-in user's ID
        ]);

        return redirect()->route('pages.schedule.daftarschedule.indexUser', $request->id_schedule)
            ->with('success', 'Anda berhasil mendaftar untuk jadwal.');
    }

    
}

