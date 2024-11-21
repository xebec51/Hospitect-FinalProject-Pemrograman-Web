<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\PatientDetail;

class PatientDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $patients = Patient::all();

        foreach ($patients as $patient) {
            PatientDetail::create([
                'patient_id' => $patient->id,
                'phone' => '081234567890',
                'date_of_birth' => '1990-05-15',
                'address' => 'Jl. Kebon Jeruk No. 32, Jakarta Barat',
                'chronic_diseases' => 'Diabetes',
                'allergies' => 'Kacang',
                'blood_type' => 'O',
            ]);
        }
    }
}
