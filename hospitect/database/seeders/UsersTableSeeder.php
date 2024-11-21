<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@hospitect.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ],
            [
                'name' => 'Dr. Budi Santoso',
                'email' => 'dr.budi@hospitect.com',
                'password' => Hash::make('password123'),
                'role' => 'dokter',
            ],
            [
                'name' => 'Dr. Siti Hartini',
                'email' => 'dr.siti@hospitect.com',
                'password' => Hash::make('password123'),
                'role' => 'dokter',
            ],
            [
                'name' => 'Andi Prasetyo',
                'email' => 'andi@hospitect.com',
                'password' => Hash::make('password123'),
                'role' => 'pasien',
            ],
            [
                'name' => 'Rini Susanti',
                'email' => 'rini@hospitect.com',
                'password' => Hash::make('password123'),
                'role' => 'pasien',
            ],
            [
                'name' => 'Dr. John Doe',
                'email' => 'dr.john@hospitect.com',
                'password' => Hash::make('password123'),
                'role' => 'dokter',
            ],
            [
                'name' => 'Dr. Jane Smith',
                'email' => 'dr.jane@hospitect.com',
                'password' => Hash::make('password123'),
                'role' => 'dokter',
            ],
            [
                'name' => 'Michael Johnson',
                'email' => 'michael@hospitect.com',
                'password' => Hash::make('password123'),
                'role' => 'pasien',
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily@hospitect.com',
                'password' => Hash::make('password123'),
                'role' => 'pasien',
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
