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
            ],
            [
                'name' => 'John Doe',
                'email' => 'john@hospitect.com',
                'password' => Hash::make('password123'),
                'role' => 'pasien',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@hospitect.com',
                'password' => Hash::make('password123'),
                'role' => 'pasien',
            ],
            [
                'name' => 'Dr. Michael Johnson',
                'email' => 'dr.michael@hospitect.com',
                'password' => Hash::make('password123'),
                'role' => 'dokter',
            ],
            [
                'name' => 'Dr. Emily Davis',
                'email' => 'dr.emily@hospitect.com',
                'password' => Hash::make('password123'),
                'role' => 'dokter',
            ],
            [
                'name' => 'Dr. Sarah Connor',
                'email' => 'dr.sarah@hospitect.com',
                'password' => Hash::make('password123'),
                'role' => 'dokter',
            ],
            [
                'name' => 'Dr. Alan Grant',
                'email' => 'dr.alan@hospitect.com',
                'password' => Hash::make('password123'),
                'role' => 'dokter',
            ],
            [
                'name' => 'Paul Atreides',
                'email' => 'paul@hospitect.com',
                'password' => Hash::make('password123'),
                'role' => 'pasien',
            ],
            [
                'name' => 'Jessica Atreides',
                'email' => 'jessica@hospitect.com',
                'password' => Hash::make('password123'),
                'role' => 'pasien',
            ],
            [
                'name' => 'Duncan Idaho',
                'email' => 'duncan@hospitect.com',
                'password' => Hash::make('password123'),
                'role' => 'pasien',
            ],
            [
                'name' => 'Gurney Halleck',
                'email' => 'gurney@hospitect.com',
                'password' => Hash::make('password123'),
                'role' => 'pasien',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
