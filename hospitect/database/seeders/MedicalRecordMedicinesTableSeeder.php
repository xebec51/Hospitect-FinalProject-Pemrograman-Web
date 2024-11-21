<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MedicalRecord;
use App\Models\Medicine;

class MedicalRecordMedicinesTableSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk tabel medical_record_medicines.
     *
     * @return void
     */
    public function run()
    {
        $medicalRecords = MedicalRecord::all();
        $medicines = Medicine::all();

        foreach ($medicalRecords as $record) {
            // Tambahkan 1-3 obat secara acak ke setiap catatan medis
            $assignedMedicines = $medicines->random(rand(1, 3));

            foreach ($assignedMedicines as $medicine) {
                $record->medicines()->attach($medicine->id, [
                    'dosage' => rand(1, 3) . ' kali sehari',
                    'instructions' => 'Minum setelah makan.',
                ]);
            }
        }
    }
}
