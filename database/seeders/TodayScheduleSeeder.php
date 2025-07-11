<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Schedule;

class TodayScheduleSeeder extends Seeder
{
    public function run(): void
    {
        Schedule::create([
            'id' => Str::uuid(),
            'description' => 'Default',
            'start_time' => '08:00',
            'end_time' => '17:00',
            'meeting_date' => now()->toDateString(),
            'type' => 'default',
        ]);
    }
}
