<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\DoctorAvailability;

class DoctorAvailabilitiesTableSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk tabel doctor_availabilities.
     *
     * @return void
     */
    public function run()
    {
        $doctors = Doctor::all();

        // Hari tersedia
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        foreach ($doctors as $doctor) {
            // Setiap dokter memiliki jadwal untuk 3-5 hari acak
            $availableDays = collect($days)->random(rand(3, 5));

            foreach ($availableDays as $day) {
                DoctorAvailability::create([
                    'doctor_id' => $doctor->id,
                    'available_day' => $day,
                    'start_time' => now()->startOfDay()->addHours(rand(8, 10))->format('H:i:s'), // Waktu mulai antara jam 8-10 pagi
                    'end_time' => now()->startOfDay()->addHours(rand(15, 17))->format('H:i:s'),  // Waktu selesai antara jam 3-5 sore
                ]);
            }
        }
    }
}
