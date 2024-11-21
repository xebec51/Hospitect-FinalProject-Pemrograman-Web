<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;

class AppointmentsTableSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk tabel appointments.
     *
     * @return void
     */
    public function run()
    {
        $patients = Patient::all();
        $doctors = Doctor::all();

        // Pastikan ada dokter dan pasien
        if ($doctors->isEmpty()) {
            $this->command->error('Tidak ada dokter untuk membuat janji konsultasi.');
            return;
        }

        if ($patients->isEmpty()) {
            $this->command->error('Tidak ada pasien untuk membuat janji konsultasi.');
            return;
        }

        foreach ($patients as $patient) {
            // Tentukan jumlah dokter yang akan digunakan (maksimal 3 atau semua jika kurang)
            $assignedDoctors = $doctors->count() > 3 ? $doctors->random(3) : $doctors;

            foreach ($assignedDoctors as $doctor) {
                Appointment::create([
                    'patient_id' => $patient->id,
                    'doctor_id' => $doctor->id,
                    'date' => now()->addDays(rand(1, 30))->format('Y-m-d'), // Tanggal janji konsultasi
                    'time' => now()->setTime(rand(9, 17), rand(0, 59), 0)->format('H:i:s'), // Waktu konsultasi
                    'status' => ['scheduled', 'completed', 'cancelled'][rand(0, 2)], // Pilihan status secara acak
                ]);
            }
        }
    }
}
