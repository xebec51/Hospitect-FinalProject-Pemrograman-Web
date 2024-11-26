<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use Carbon\Carbon;

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

        if ($doctors->isEmpty()) {
            $this->command->error('Tidak ada dokter untuk membuat janji konsultasi.');
            return;
        }

        if ($patients->isEmpty()) {
            $this->command->error('Tidak ada pasien untuk membuat janji konsultasi.');
            return;
        }

        $workHoursStart = 7; // Jam mulai kerja
        $workHoursEnd = 17;  // Jam selesai kerja
        $timeSlots = $this->generateTimeSlots($workHoursStart, $workHoursEnd, 15); // Slot waktu 15 menit

        foreach ($patients as $patient) {
            // Tentukan jumlah dokter yang akan digunakan (maksimal 3 atau semua jika kurang)
            $assignedDoctors = $doctors->count() > 3 ? $doctors->random(3) : $doctors;

            foreach ($assignedDoctors as $doctor) {
                $randomDate = Carbon::now()->addDays(rand(1, 30))->format('Y-m-d'); // Random tanggal konsultasi
                $randomTimeSlot = $timeSlots[array_rand($timeSlots)]; // Random slot waktu

                Appointment::create([
                    'patient_id' => $patient->id,
                    'doctor_id' => $doctor->id,
                    'date' => $randomDate,
                    'time' => $randomTimeSlot,
                    'status' => ['scheduled', 'completed', 'cancelled'][rand(0, 2)], // Pilihan status secara acak
                ]);
            }
        }

        $this->command->info('Seeder untuk janji konsultasi berhasil dijalankan.');
    }

    /**
     * Generate time slots.
     *
     * @param int $startHour
     * @param int $endHour
     * @param int $interval
     * @return array
     */
    private function generateTimeSlots(int $startHour, int $endHour, int $interval): array
    {
        $slots = [];
        $currentTime = Carbon::createFromTime($startHour, 0);
        $endTime = Carbon::createFromTime($endHour, 0);

        while ($currentTime < $endTime) {
            $slots[] = $currentTime->format('H:i:s');
            $currentTime->addMinutes($interval);
        }

        return $slots;
    }
}
