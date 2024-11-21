<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\DoctorDetail;

class DoctorDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $doctors = Doctor::all();

        foreach ($doctors as $doctor) {
            DoctorDetail::create([
                'doctor_id' => $doctor->id,
                'phone' => '081987654321',
                'experience_years' => 10,
                'clinic_address' => 'Jl. Dr. Sutomo No. 45, Surabaya',
            ]);
        }
    }
}
