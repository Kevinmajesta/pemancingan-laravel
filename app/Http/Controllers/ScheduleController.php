<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function indexAdmin(Request $request)
    {
        $sortField = $request->input('sort', 'activity_name');
        $sortDirection = $request->input('direction', 'asc');

        $schedules = Schedule::orderBy($sortField, $sortDirection)->paginate(10);
        return view('pages.schedule.indexAdmin', compact('schedules', 'sortField', 'sortDirection'));
    }

    public function indexUser(Request $request)
    {
        $sortField = $request->input('sort', 'activity_name');
        $sortDirection = $request->input('direction', 'asc');

        $schedules = Schedule::orderBy($sortField, $sortDirection)->paginate(10);
        return view('pages.schedule.indexUser', compact('schedules', 'sortField', 'sortDirection'));
    }

    public function create()
    {
        return view('pages.schedules.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'activity_name' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required',
        ]);

        Schedule::create([
            'activity_name' => $request->activity_name,
            'date' => $request->date,
            'time' => $request->time,
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
        return view('pages.schedules.edit', compact('schedule'));
    }

    // Update the specified schedule in storage
    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        $schedule->update($request->all());
        return redirect()->route('pages.schedules.indexAdmin')->with('success', 'Schedule updated successfully.');
    }

    // Remove the specified schedule from storage
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('pages.schedules.indexAdmin')->with('success', 'Schedule deleted successfully.');
    }
}
