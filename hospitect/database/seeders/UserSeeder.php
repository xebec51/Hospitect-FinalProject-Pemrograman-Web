<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Dokter;
use App\Models\Pasien;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Dokter
        $dokter1 = User::create([
            'name' => 'Dokter 1',
            'email' => 'dokter1@example.com',
            'password' => Hash::make('password'),
            'role' => 'dokter',
        ]);
        Dokter::create([
            'user_id' => $dokter1->id,
            'specialization' => 'Spesialis Umum',
            'license_number' => 'DOK123456' // Pastikan nilai ini unik untuk setiap dokter
        ]);

        $dokter2 = User::create([
            'name' => 'Dokter 2',
            'email' => 'dokter2@example.com',
            'password' => Hash::make('password'),
            'role' => 'dokter',
        ]);
        Dokter::create([
            'user_id' => $dokter2->id,
            'specialization' => 'Spesialis Penyakit Dalam',
            'license_number' => 'DOK654321' // Pastikan nilai ini unik untuk setiap dokter
        ]);

        // Pasien
        $pasien1 = User::create([
            'name' => 'Pasien 1',
            'email' => 'pasien1@example.com',
            'password' => Hash::make('password'),
            'role' => 'pasien',
        ]);
        Pasien::create([
            'user_id' => $pasien1->id,
            'medical_history' => 'Hipertensi',
            'insurance_number' => 'INS123456'
        ]);

        $pasien2 = User::create([
            'name' => 'Pasien 2',
            'email' => 'pasien2@example.com',
            'password' => Hash::make('password'),
            'role' => 'pasien',
        ]);
        Pasien::create([
            'user_id' => $pasien2->id,
            'medical_history' => 'Diabetes',
            'insurance_number' => 'INS654321'
        ]);

        $pasien3 = User::create([
            'name' => 'Pasien 3',
            'email' => 'pasien3@example.com',
            'password' => Hash::make('password'),
            'role' => 'pasien',
        ]);
        Pasien::create([
            'user_id' => $pasien3->id,
            'medical_history' => 'Asma',
            'insurance_number' => 'INS987654'
        ]);
    }
}
