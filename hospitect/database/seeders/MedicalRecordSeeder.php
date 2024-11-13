<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MedicalRecord;
use App\Models\Dokter;
use App\Models\Pasien;

class MedicalRecordSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk mengisi data awal rekam medis.
     */
    public function run(): void
    {
        $medicalRecords = [
            [
                'id_dokter' => Dokter::first()->id ?? null, // Ambil ID dokter pertama jika ada
                'id_pasien' => Pasien::first()->id ?? null, // Ambil ID pasien pertama jika ada
                'tindakan' => 'Pemeriksaan fisik umum',
                'tanggal_periksa' => now(),
                'obat' => json_encode(['Paracetamol', 'Ibuprofen']), // Simpan array sebagai JSON
            ],
            [
                'id_dokter' => Dokter::find(1)->id ?? Dokter::first()->id,
                'id_pasien' => Pasien::find(2)->id ?? Pasien::first()->id,
                'tindakan' => 'Pemeriksaan tekanan darah',
                'tanggal_periksa' => now()->subDays(2),
                'obat' => json_encode(['Captopril']),
            ],
            [
                'id_dokter' => Dokter::find(2)->id ?? Dokter::first()->id,
                'id_pasien' => Pasien::find(3)->id ?? Pasien::first()->id,
                'tindakan' => 'Pemeriksaan gula darah',
                'tanggal_periksa' => now()->subDays(5),
                'obat' => json_encode(['Metformin']),
            ],
        ];

        // Filter out any records with null IDs to avoid errors
        foreach ($medicalRecords as $record) {
            if ($record['id_dokter'] && $record['id_pasien']) {
                MedicalRecord::create($record);
            }
        }
    }
}
