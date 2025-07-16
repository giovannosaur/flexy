<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class DummyUserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 'S001',
                'name' => 'Staff Test',
                'email' => 'zaki@example.com',
                'password' => bcrypt('password'), // password: password
                'nik' => '1',
                'status' => 'Active',
                'position' => 'Staff',
                'role' => 'Level 1'
            ],
            [
                'id' => 'S002',
                'name' => 'GM Test',
                'email' => 'gm@gmail.com',
                'password' => bcrypt('password'), // password: password
                'nik' => '2',
                'status' => 'Active',
                'position' => 'GM',
                'role' => 'Level 2'
            ],
            [
                'id' => 'S003',
                'name' => 'PDTI Test',
                'email' => 'pdti@gmail.com',
                'password' => bcrypt('password'), // password: password
                'nik' => '3',
                'status' => 'Active',
                'position' => 'PDTI',
                'role' => 'Level 3'
            ],
        ];

        foreach ($data as $user) {
            User::updateOrCreate(
                ['id' => $user['id']],
                $user
            );
        }
    }
}
