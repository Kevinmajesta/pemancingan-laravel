<?php

namespace App\Http\Controllers;

use App\Models\ScheduleDetail;
use App\Models\Schedule; // Pastikan model Schedule diimport
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleDetailController extends Controller
{
    // Menampilkan detail jadwal dan daftar pengguna yang telah mendaftar
    public function index($id_schedule)
    {
        // Dapatkan informasi jadwal
        $schedule = Schedule::findOrFail($id_schedule);

        // Dapatkan pengguna yang sudah mendaftar
        $scheduleDetails = ScheduleDetail::with('user')
            ->where('id_schedule', $id_schedule)
            ->get();

        return view('pages.schedule.daftarschedule.indexUser', compact('schedule', 'scheduleDetails'));
    }

    // Proses pendaftaran untuk jadwal tertentu
    public function store(Request $request)
    {
        $request->validate([
            'id_schedule' => 'required|exists:schedules,id_schedule',
        ]);

        // Ambil jadwal berdasarkan ID
        $schedule = Schedule::withCount('scheduleDetails')->findOrFail($request->id_schedule);

        // Validasi apakah kuota masih tersedia
        if ($schedule->maxqty <= $schedule->schedule_details_count) {
            return redirect()->route('pages.schedule.daftarschedule.indexUser', $schedule->id_schedule)
                ->with('error', 'Kuota untuk jadwal ini sudah penuh.');
        }

        // Validasi apakah pengguna sudah terdaftar
        $existingRegistration = ScheduleDetail::where('id_schedule', $request->id_schedule)
            ->where('id_user', Auth::id())
            ->first();

        if ($existingRegistration) {
            return redirect()->route('pages.schedule.daftarschedule.indexUser', $schedule->id_schedule)
                ->with('error', 'Anda sudah mendaftar untuk jadwal ini.');
        }

        // Jika belum terdaftar dan kuota tersedia, tambahkan pendaftaran baru
        ScheduleDetail::create([
            'id_schedule' => $request->id_schedule,
            'id_user' => Auth::id(),
        ]);

        return redirect()->route('pages.schedule.daftarschedule.indexUser', $schedule->id_schedule)
            ->with('success', 'Anda berhasil mendaftar untuk jadwal.');
    }
}
