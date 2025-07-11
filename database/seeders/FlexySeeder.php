<?php

namespace Database\Seeders;

// database/seeders/FlexySeeder.php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Attendance;
use App\Models\FlexyRequest;

class FlexySeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'id' => 'S001',
            'name' => 'Zaki Flexy',
            'email' => 'zaki@example.com',
            'password' => Hash::make('password'),
            'nik' => '1234567890123456',
            'status' => 'Active',
            'position' => 'Staff',
            'role' => 'Level 1',
        ]);

        $schedule = Schedule::create([
            'id' => Str::uuid(),
            'description' => 'Shift pagi',
            'start_time' => '09:00',
            'end_time' => '18:00',
            'meeting_date' => now()->toDateString(),
            'type' => 'default',
        ]);

        Attendance::create([
            'id' => Str::uuid(),
            'user_id' => 'S001',
            'schedule_id' => $schedule->id,
            'location_coordinates' => '6.917,107.619',
        ]);

        FlexyRequest::create([
            'id' => Str::uuid(),
            'user_id' => 'S001',
            'requested_date' => now()->addDay()->toDateString(),
            'schedule_option' => '10:00-19:00',
            'status' => 'pending',
        ]);
    }
}
