<?php
// D:\GitHub\Hospitect-FinalProject-Pemrograman-Web\hospitect\database\seeders\PatientDetailSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pasien;
use App\Models\PatientDetail;

class PatientDetailSeeder extends Seeder
{
    public function run()
    {
        $patients = Pasien::all();

        foreach ($patients as $patient) {
            PatientDetail::create([
                'patient_id' => $patient->id,
                'phone' => '081234567890',
                'date_of_birth' => '1980-01-01',
                'address' => 'Jalan Contoh No. 123, Jakarta',
                'chronic_diseases' => 'Diabetes',
                'allergies' => 'Penisilin',
                'blood_type' => 'O',
            ]);
        }
    }
}
