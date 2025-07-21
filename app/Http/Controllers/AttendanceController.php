<?php
// app/Http/Controllers/AttendanceController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AttendanceController extends Controller
{
    public function checkin(Request $request)
    {
        $user = Auth::user();
        $today = now()->toDateString();

        $flexy = Schedule::where('user_id', $user->id)
            ->where('type', 'flexy')
            ->whereDate('meeting_date', $today)
            ->first();

        $default = Schedule::whereNull('user_id')
            ->where('type', 'default')
            ->whereDate('meeting_date', $today)
            ->first();

        $activeSchedule = $flexy ?: $default;

        if (!$activeSchedule) {
            return back()->with('error', 'Hari ini tidak ada jadwal!');
        }

        // Cek sudah check-in hari ini
        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('checkin_time', $today)
            ->first();

        if ($attendance) {
            return back()->with('error', 'Kamu sudah check-in hari ini!');
        }

        // Boleh check-in mulai 30 menit sebelum jam masuk
        $startTime = \Carbon\Carbon::parse($activeSchedule->meeting_date . ' ' . $activeSchedule->start_time)->subMinutes(30);
        $jadwalMasuk = \Carbon\Carbon::parse($activeSchedule->meeting_date . ' ' . $activeSchedule->start_time);
        $now = \Carbon\Carbon::now();

        if ($now->lt($startTime)) {
            return back()->with('error', 'Check-in hanya boleh mulai 30 menit sebelum jam masuk!');
        }

        // Kalkulasi status TEPAT/LATE
        $diff = $now->diffInMinutes($jadwalMasuk, false); // false = negative jika telat
        $status = 'tepat';
        if ($diff < -5) { // lebih dari 5 menit setelah jam masuk (telat)
            $status = 'late';
        }

        Attendance::create([
            'id' => \Str::uuid(),
            'user_id' => $user->id,
            'schedule_id' => $activeSchedule->id,
            'checkin_time' => $now,
            'location_coordinates' => $request->input('location_coordinates', '-'),
            'status' => $status,
        ]);

        return back()->with('success', 'Check-in berhasil!');
    }

    public function checkout(Request $request)
    {
        $user = Auth::user();
        $today = now()->toDateString();

        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('checkin_time', $today)
            ->whereNull('checkout_time')
            ->first();

        if (!$attendance) {
            return back()->with('error', 'Belum check-in atau sudah check-out hari ini!');
        }

        $activeSchedule = Schedule::find($attendance->schedule_id);
        $jadwalPulang = \Carbon\Carbon::parse($activeSchedule->meeting_date . ' ' . $activeSchedule->end_time);
        $now = \Carbon\Carbon::now();

        // Kalkulasi status checkout: cek apakah checkout lebih awal
        $status = $attendance->status;
        if ($now->lt($jadwalPulang)) {
            $status = 'early_leave';
        }

        $attendance->checkout_time = $now;
        $attendance->status = $status;
        $attendance->save();

        return back()->with('success', 'Check-out berhasil!');
    }

    public function history() {
        $history = Attendance::where('user_id', auth()->id())->latest()->get();
        return view('attendance.history', compact('history'));
    }
}
