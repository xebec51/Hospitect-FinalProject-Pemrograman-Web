<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil semua seeder yang dibutuhkan
        $this->call([
            UserSeeder::class,
            MedicineSeeder::class,
            MedicalRecordSeeder::class,
            JadwalKonsultasiSeeder::class,
            // Tambahkan seeder lainnya di sini jika diperlukan
        ]);
    }
}
