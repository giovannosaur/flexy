<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        // Cek input: default minggu ini
        $minggu = $request->get('minggu', 'ini');

        if ($minggu == 'depan') {
            // Start: Senin minggu depan
            $start = \Carbon\Carbon::now()->addWeek()->startOfWeek();
            $end   = \Carbon\Carbon::now()->addWeek()->endOfWeek()->subDays(2); // Jumat minggu depan
        } else {
            // Default: minggu ini
            $start = \Carbon\Carbon::now()->startOfWeek();
            $end   = \Carbon\Carbon::now()->endOfWeek()->subDays(2); // Jumat minggu ini
        }

        // Jadwal default
        $defaultSchedules = Schedule::whereNull('user_id')
            ->where('type', 'default')
            ->whereBetween('meeting_date', [$start, $end])
            ->get()
            ->keyBy('meeting_date');

        // Jadwal flexy user
        $flexySchedules = Schedule::where('user_id', $userId)
            ->where('type', 'flexy')
            ->whereBetween('meeting_date', [$start, $end])
            ->get()
            ->keyBy('meeting_date');

        // Merge, flexy prioritas
        $finalSchedules = [];
        foreach ($defaultSchedules as $date => $jadwal) {
            $finalSchedules[$date] = $flexySchedules[$date] ?? $jadwal;
        }

        return view('schedule.index', [
            'finalSchedules' => $finalSchedules,
            'minggu' => $minggu,
        ]);
    }
}
