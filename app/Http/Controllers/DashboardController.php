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

        // Cari schedule flexy user
        $flexy = Schedule::where('user_id', $user->id)
            ->where('type', 'flexy')
            ->whereDate('meeting_date', $today)
            ->first();

        // Kalau ga ada, fallback ke default (user_id null)
        $default = Schedule::whereNull('user_id')
            ->where('type', 'default')
            ->whereDate('meeting_date', $today)
            ->first();

        $activeSchedule = $flexy ?: $default;

        $scheduleInfo = [
            'date' => now()->translatedFormat('D, d M Y'),
            'time' => $activeSchedule ? ($activeSchedule->start_time . ' - ' . $activeSchedule->end_time) : '08.00 - 17.00',
            'id'   => $activeSchedule?->id,
        ];


        // Cek udah absen belum hari ini
        $alreadyCheckedIn = Attendance::where('user_id', $user->id)
            ->whereDate('created_at', now()->toDateString())
            ->exists();

        return view('dashboard', [
            'todaySchedule'    => $scheduleInfo,
            'alreadyCheckedIn' => $alreadyCheckedIn,
        ]);
    }
}
