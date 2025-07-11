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
        $scheduleId = $activeSchedule?->id;


        Attendance::create([
            'id' => Str::uuid(),
            'user_id' => $user->id,
            'schedule_id' => $scheduleId,
            'location_coordinates' => $request->input('location_coordinates', '-'),
        ]);        

        return back()->with('success', 'Absensi berhasil!');
    }

    // (bonus) buat history kalau mau
    public function history() {
        $history = Attendance::where('user_id', auth()->id())->latest()->get();
        return view('attendance.history', compact('history'));
    }
}
