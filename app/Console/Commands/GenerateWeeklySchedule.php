<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Schedule;
use Carbon\Carbon;

class GenerateWeeklySchedule extends Command
{
    protected $signature = 'jadwal:mingguan {mode=ini}';

public function handle()
{
    $mode = $this->argument('mode'); // "ini" atau "depan"
    $hariKerja = [1,2,3,4,5];
    $now = \Carbon\Carbon::now();

    $senin = $mode == 'depan'
        ? $now->copy()->addWeek()->startOfWeek()
        : $now->copy()->startOfWeek();

    foreach ($hariKerja as $i => $hari) {
        $tanggal = $senin->copy()->addDays($i)->toDateString();

        $sudah = \App\Models\Schedule::whereDate('meeting_date', $tanggal)
            ->whereNull('user_id')
            ->where('type', 'default')
            ->exists();

        if (!$sudah) {
            \App\Models\Schedule::create([
                'id' => \Str::uuid(),
                'user_id' => null,
                'description' => 'Default schedule',
                'start_time' => '08:00',
                'end_time' => '17:00',
                'meeting_date' => $tanggal,
                'type' => 'default',
            ]);
        }
    }
    $this->info("Jadwal default Senin–Jumat minggu $mode sudah digenerate!");
}

}
