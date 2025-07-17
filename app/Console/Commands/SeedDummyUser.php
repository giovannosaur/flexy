<?php

// app/Console/Commands/SeedDummyUser.php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class SeedDummyUser extends Command
{
    protected $signature = 'seed:dummyuser';
    protected $description = 'Generate 3+5 user dummy Flexy';

    public function handle()
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
            [
                'id' => 'S004',
                'name' => 'Bima Dummy',
                'email' => 'bima@flexy.com',
                'password' => bcrypt('password'),
                'nik' => '327600004',
                'status' => 'Active',
                'position' => 'Staff',
                'role' => 'Level 1'
            ],
            [
                'id' => 'S005',
                'name' => 'Citra Dummy',
                'email' => 'citra@flexy.com',
                'password' => bcrypt('password'),
                'nik' => '327600005',
                'status' => 'Active',
                'position' => 'Staff',
                'role' => 'Level 1'
            ],
            [
                'id' => 'S006',
                'name' => 'Deni Dummy',
                'email' => 'deni@flexy.com',
                'password' => bcrypt('password'),
                'nik' => '327600006',
                'status' => 'Active',
                'position' => 'Staff',
                'role' => 'Level 1'
            ],
            [
                'id' => 'S007',
                'name' => 'Eva Dummy',
                'email' => 'eva@flexy.com',
                'password' => bcrypt('password'),
                'nik' => '327600007',
                'status' => 'Active',
                'position' => 'Staff',
                'role' => 'Level 1'
            ],
            [
                'id' => 'S008',
                'name' => 'Fikri Dummy',
                'email' => 'fikri@flexy.com',
                'password' => bcrypt('password'),
                'nik' => '327600008',
                'status' => 'Active',
                'position' => 'Staff',
                'role' => 'Level 1'
            ],
        ];
        foreach ($data as $user) {
            User::updateOrCreate(['id' => $user['id']], $user);
        }
        $this->info('Dummy user sudah di-generate!');
    }
}
