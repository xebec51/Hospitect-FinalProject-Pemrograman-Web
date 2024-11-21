<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;

class DoctorsTableSeeder extends Seeder
{
    public function run()
    {
        $doctors = [
            [
                'user_id' => 2, // ID pengguna Dr. Budi Santoso di tabel users
                'specialization' => 'Dokter Umum',
                'license_number' => 'DOK12345BS',
            ],
            [
                'user_id' => 3, // ID pengguna Dr. Siti Hartini di tabel users
                'specialization' => 'Spesialis Anak',
                'license_number' => 'DOK12345SH',
            ],
            [
                'user_id' => 8, // ID pengguna Dr. John Doe di tabel users
                'specialization' => 'Spesialis Jantung',
                'license_number' => 'DOK12345JD',
            ],
            [
                'user_id' => 9, // ID pengguna Dr. Jane Smith di tabel users
                'specialization' => 'Spesialis Bedah',
                'license_number' => 'DOK12345JS',
            ]
        ];

        foreach ($doctors as $doctor) {
            Doctor::create($doctor);
        }
    }
}