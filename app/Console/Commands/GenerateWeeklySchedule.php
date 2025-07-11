<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Schedule;
use Carbon\Carbon;

class GenerateWeeklySchedule extends Command
{
    protected $signature = 'jadwal:mingguan';
    protected $description = 'Generate default schedule Senin–Jumat untuk minggu depan';

    public function handle()
    {
        $hariKerja = [1,2,3,4,5]; // Senin-Jumat
        $now = Carbon::now();

        // Cari Senin minggu depan
        $seninDepan = $now->copy()->addWeek()->startOfWeek(); // Monday next week

        foreach ($hariKerja as $i => $hari) {
            $tanggal = $seninDepan->copy()->addDays($i)->toDateString();

            // Cek apakah sudah ada schedule default di tanggal itu
            $sudah = Schedule::whereDate('meeting_date', $tanggal)
                ->whereNull('user_id')
                ->where('type', 'default')
                ->exists();

            if (!$sudah) {
                Schedule::create([
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

        $this->info("Jadwal default Senin–Jumat minggu depan sudah digenerate!");
    }
}
