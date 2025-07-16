<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DummyAttendanceSeeder extends Seeder
{
    public function run()
    {
        $users = User::inRandomOrder()->limit(10)->get(); // ambil 10 user random
        $dates = collect();
        for ($i = 0; $i < 7; $i++) {
            $dates->push(Carbon::now()->subDays($i)->toDateString());
        }

        $count = 0;
        while ($count < 30) {
            $user = $users->random();
            $tanggal = $dates->random();

            // Cari schedule (fleksy prioritas, else default)
            $schedule = Schedule::where(function($q) use ($user, $tanggal) {
                    $q->where('user_id', $user->id)->where('type', 'flexy');
                })
                ->orWhere(function($q) use ($tanggal) {
                    $q->whereNull('user_id')->where('type', 'default')->where('meeting_date', $tanggal);
                })
                ->where('meeting_date', $tanggal)
                ->orderByRaw("CASE WHEN user_id IS NOT NULL THEN 1 ELSE 2 END")
                ->first();

            if (!$schedule) continue; // skip jika gak ada jadwal

            // Cek sudah ada? Biar ga double
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
        }
    }
}
