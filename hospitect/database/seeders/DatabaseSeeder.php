<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            DoctorsTableSeeder::class,
            PatientsTableSeeder::class,
            DoctorDetailsTableSeeder::class, // Pastikan nama ini benar
            PatientDetailsTableSeeder::class,
            MedicinesTableSeeder::class,
            ExpiredMedicinesTableSeeder::class,
            AppointmentsTableSeeder::class,
            MedicalRecordsTableSeeder::class,
            FeedbacksTableSeeder::class,
            MedicalRecordMedicinesTableSeeder::class,
            DoctorAvailabilitiesTableSeeder::class,
        ]);
    }
}
