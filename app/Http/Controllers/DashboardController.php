<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = now()->toDateString();

        $flexy = \App\Models\Schedule::where('user_id', $user->id)
            ->where('type', 'flexy')
            ->whereDate('meeting_date', $today)
            ->first();

        $default = \App\Models\Schedule::whereNull('user_id')
            ->where('type', 'default')
            ->whereDate('meeting_date', $today)
            ->first();

        $activeSchedule = $flexy ?: $default;

        if (!$activeSchedule) {
            $scheduleInfo = [
                'date' => now()->translatedFormat('D, d M Y'),
                'time' => null,
                'id'   => null
            ];
        } else {
            $scheduleInfo = [
                'date' => now()->translatedFormat('D, d M Y'),
                'time' => $activeSchedule->start_time . ' - ' . $activeSchedule->end_time,
                'id'   => $activeSchedule->id,
            ];
        }

        // Tambahin ini:
        $attendanceToday = \App\Models\Attendance::where('user_id', $user->id)
            ->whereDate('checkin_time', $today)
            ->first();

        return view('dashboard', [
            'todaySchedule'    => $scheduleInfo,
            'attendanceToday'  => $attendanceToday, // <--- WAJIB
        ]);
    }
}
