<?php

// app/Console/Commands/SeedDummyAttendance.php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SeedDummyAttendance extends Command
{
    protected $signature = 'seed:dummyattendance';
    protected $description = 'Generate 30 attendance dummy Flexy';

    public function handle()
    {
        $users = User::all();
        $dates = collect();
        for ($i = 0; $i < 10; $i++) {
            $dates->push(Carbon::now()->subDays($i)->toDateString());
        }
        $combos = [];
        foreach ($users as $user) {
            foreach ($dates as $tanggal) {
                $combos[] = [$user, $tanggal];
            }
        }
        shuffle($combos);
        $combos = array_slice($combos, 0, 30);
        $count = 0;
        foreach ($combos as [$user, $tanggal]) {
            $schedule = Schedule::where(function($q) use ($user, $tanggal) {
                    $q->where('user_id', $user->id)->where('type', 'flexy');
                })
                ->orWhere(function($q) use ($tanggal) {
                    $q->whereNull('user_id')->where('type', 'default')->where('meeting_date', $tanggal);
                })
                ->where('meeting_date', $tanggal)
                ->orderByRaw("CASE WHEN user_id IS NOT NULL THEN 1 ELSE 2 END")
                ->first();
            if (!$schedule) continue;
            $already = Attendance::where('user_id', $user->id)
                ->where('schedule_id', $schedule->id)
                ->exists();
            if ($already) continue;
            Attendance::create([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'schedule_id' => $schedule->id,
                'location_coordinates' => '-6.9,107.6',
                'created_at' => Carbon::parse($tanggal.' '.$schedule->start_time)->addMinutes(rand(0,50)),
                'updated_at' => Carbon::parse($tanggal.' '.$schedule->start_time)->addMinutes(rand(0,50)),
            ]);
            $count++;
            if ($count >= 30) break;
        }
        $this->info('data dummy attendance sudah di-generate');
    }
}
