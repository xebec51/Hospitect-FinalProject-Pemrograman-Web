<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Carbon\Carbon;

class AppointmentsTableSeeder extends Seeder
{
    public function run()
    {
        $doctorIds = Doctor::pluck('id')->toArray();
        $patientIds = Patient::pluck('id')->toArray();

        if (count($doctorIds) < 6 || count($patientIds) < 10) {
            $this->command->error('Tidak cukup data dokter atau pasien di tabel terkait.');
            return;
        }

        $appointments = [
            [
                'patient_id' => $patientIds[0],
                'doctor_id' => $doctorIds[0],
                'date' => Carbon::now()->subDays(10)->format('Y-m-d'),
                'time' => '10:00:00',
                'status' => 'completed',
            ],
            [
                'patient_id' => $patientIds[1],
                'doctor_id' => $doctorIds[1],
                'date' => Carbon::now()->subDays(20)->format('Y-m-d'),
                'time' => '11:00:00',
                'status' => 'completed',
            ],
            [
                'patient_id' => $patientIds[2],
                'doctor_id' => $doctorIds[2],
                'date' => Carbon::now()->subDays(15)->format('Y-m-d'),
                'time' => '09:00:00',
                'status' => 'completed',
            ],
            [
                'patient_id' => $patientIds[3],
                'doctor_id' => $doctorIds[3],
                'date' => Carbon::now()->subDays(5)->format('Y-m-d'),
                'time' => '14:00:00',
                'status' => 'completed',
            ],
            [
                'patient_id' => $patientIds[0],
                'doctor_id' => $doctorIds[0],
                'date' => Carbon::now()->addDays(5)->format('Y-m-d'),
                'time' => '10:00:00',
                'status' => 'scheduled',
            ],
            [
                'patient_id' => $patientIds[1],
                'doctor_id' => $doctorIds[1],
                'date' => Carbon::now()->addDays(10)->format('Y-m-d'),
                'time' => '11:00:00',
                'status' => 'scheduled',
            ],
            [
                'patient_id' => $patientIds[4],
                'doctor_id' => $doctorIds[0],
                'date' => Carbon::now()->subDays(12)->format('Y-m-d'),
                'time' => '10:30:00',
                'status' => 'completed',
            ],
            [
                'patient_id' => $patientIds[5],
                'doctor_id' => $doctorIds[1],
                'date' => Carbon::now()->subDays(18)->format('Y-m-d'),
                'time' => '11:30:00',
                'status' => 'completed',
            ],
            [
                'patient_id' => $patientIds[6],
                'doctor_id' => $doctorIds[2],
                'date' => Carbon::now()->subDays(22)->format('Y-m-d'),
                'time' => '09:30:00',
                'status' => 'completed',
            ],
            [
                'patient_id' => $patientIds[7],
                'doctor_id' => $doctorIds[3],
                'date' => Carbon::now()->subDays(7)->format('Y-m-d'),
                'time' => '14:30:00',
                'status' => 'completed',
            ],
            [
                'patient_id' => $patientIds[4],
                'doctor_id' => $doctorIds[0],
                'date' => Carbon::now()->addDays(7)->format('Y-m-d'),
                'time' => '10:30:00',
                'status' => 'scheduled',
            ],
            [
                'patient_id' => $patientIds[5],
                'doctor_id' => $doctorIds[1],
                'date' => Carbon::now()->addDays(14)->format('Y-m-d'),
                'time' => '11:30:00',
                'status' => 'scheduled',
            ],
            [
                'patient_id' => $patientIds[8],
                'doctor_id' => $doctorIds[4],
                'date' => Carbon::now()->subDays(12)->format('Y-m-d'),
                'time' => '10:30:00',
                'status' => 'completed',
            ],
            [
                'patient_id' => $patientIds[9],
                'doctor_id' => $doctorIds[5],
                'date' => Carbon::now()->subDays(18)->format('Y-m-d'),
                'time' => '11:30:00',
                'status' => 'completed',
            ],
        ];

        foreach ($appointments as $appointment) {
            Appointment::create($appointment);
        }

        $this->command->info('Seeder untuk janji konsultasi berhasil dijalankan.');
    }
}
