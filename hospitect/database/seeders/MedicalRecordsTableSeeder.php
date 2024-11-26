<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MedicalRecord;
use App\Models\Appointment;
use App\Models\Medicine;

class MedicalRecordsTableSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk tabel medical_records.
     *
     * @return void
     */
    public function run()
    {
        $appointments = Appointment::where('status', 'completed')->get();
        $medicines = Medicine::all();

        if ($appointments->isEmpty()) {
            $this->command->warn('Tidak ada janji konsultasi dengan status "completed" untuk membuat catatan medis.');
            return;
        }

        if ($medicines->isEmpty()) {
            $this->command->warn('Tidak ada data obat untuk ditambahkan ke catatan medis.');
            return;
        }

        foreach ($appointments as $appointment) {
            // Buat catatan medis berdasarkan janji konsultasi
            $record = MedicalRecord::create([
                'patient_id' => $appointment->patient_id,
                'doctor_id' => $appointment->doctor_id,
                'diagnosis' => 'Diagnosa untuk pasien ' . $appointment->patient_id,
                'treatment' => 'Pengobatan untuk pasien ' . $appointment->patient_id,
                'record_date' => now()->subDays(rand(1, 30)), // Tanggal catatan
            ]);

            // Tambahkan obat ke catatan medis (maks 3 obat per catatan)
            $assignedMedicines = $medicines->random(rand(1, min(3, $medicines->count())));
            foreach ($assignedMedicines as $medicine) {
                $record->medicines()->attach($medicine->id, [
                    'dosage' => rand(1, 3) . ' kali sehari',
                    'instructions' => 'Minum setelah makan.',
                ]);
            }
        }

        $this->command->info('Seeder untuk catatan medis berhasil dijalankan.');
    }
}
