<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;

class PatientsTableSeeder extends Seeder
{
    public function run()
    {
        $patients = [
            [
                'user_id' => 4, // ID pengguna Andi Prasetyo di tabel users
                'insurance_number' => 'BPJS12345AP',
                'medical_history' => 'Riwayat diabetes melitus, hipertensi ringan',
            ],
            [
                'user_id' => 5, // ID pengguna Rini Susanti di tabel users
                'insurance_number' => 'BPJS12345RS',
                'medical_history' => 'Riwayat asma, alergi kacang',
            ],
            [
                'user_id' => 6, // ID pengguna Michael Johnson di tabel users
                'insurance_number' => 'BPJS12345MJ',
                'medical_history' => 'Riwayat hipertensi, kolesterol tinggi',
            ],
            [
                'user_id' => 7, // ID pengguna Emily Davis di tabel users
                'insurance_number' => 'BPJS12345ED',
                'medical_history' => 'Riwayat migrain, alergi debu',
            ],
            [
                'user_id' => 8, // ID pengguna John Doe di tabel users
                'insurance_number' => 'BPJS12345JD',
                'medical_history' => 'Riwayat penyakit jantung, asma',
            ],
            [
                'user_id' => 9, // ID pengguna Jane Smith di tabel users
                'insurance_number' => 'BPJS12345JS',
                'medical_history' => 'Riwayat kanker, alergi gluten',
            ]
        ];

        foreach ($patients as $patient) {
            Patient::create($patient);
        }
    }
}
