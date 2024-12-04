<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\User;

class PatientsTableSeeder extends Seeder
{
    public function run()
    {
        $userIds = User::where('role', 'pasien')->pluck('id')->toArray();

        if (count($userIds) < 10) {
            $this->command->error('Tidak cukup user dengan role pasien di tabel users.');
            return;
        }

        $patients = [
            [
                'user_id' => $userIds[0], // ID pengguna Andi Prasetyo di tabel users
                'insurance_number' => 'BPJS12345AP',
                'medical_history' => 'Riwayat diabetes melitus, hipertensi ringan',
            ],
            [
                'user_id' => $userIds[1], // ID pengguna Rini Susanti di tabel users
                'insurance_number' => 'BPJS12345RS',
                'medical_history' => 'Riwayat asma, alergi kacang',
            ],
            [
                'user_id' => $userIds[2], // ID pengguna Michael Johnson di tabel users
                'insurance_number' => 'BPJS12345MJ',
                'medical_history' => 'Riwayat hipertensi, kolesterol tinggi',
            ],
            [
                'user_id' => $userIds[3], // ID pengguna Emily Davis di tabel users
                'insurance_number' => 'BPJS12345ED',
                'medical_history' => 'Riwayat migrain, alergi debu',
            ],
            [
                'user_id' => $userIds[4], // ID pengguna John Doe di tabel users
                'insurance_number' => 'BPJS12345JD',
                'medical_history' => 'Riwayat penyakit jantung, asma',
            ],
            [
                'user_id' => $userIds[5], // ID pengguna Jane Smith di tabel users
                'insurance_number' => 'BPJS12345JS',
                'medical_history' => 'Riwayat kanker, alergi gluten',
            ],
            [
                'user_id' => $userIds[6], // ID pengguna Paul Atreides di tabel users
                'insurance_number' => 'BPJS12345PA',
                'medical_history' => 'Riwayat alergi debu, asma',
            ],
            [
                'user_id' => $userIds[7], // ID pengguna Jessica Atreides di tabel users
                'insurance_number' => 'BPJS12345JA',
                'medical_history' => 'Riwayat hipertensi, diabetes',
            ],
            [
                'user_id' => $userIds[8], // ID pengguna Duncan Idaho di tabel users
                'insurance_number' => 'BPJS12345DI',
                'medical_history' => 'Riwayat penyakit jantung, kolesterol tinggi',
            ],
            [
                'user_id' => $userIds[9], // ID pengguna Gurney Halleck di tabel users
                'insurance_number' => 'BPJS12345GH',
                'medical_history' => 'Riwayat migrain, alergi kacang',
            ],
        ];

        foreach ($patients as $patient) {
            Patient::create($patient);
        }
    }
}
