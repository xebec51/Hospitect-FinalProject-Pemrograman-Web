<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MedicalRecord;
use App\Models\Doctor;
use App\Models\Patient;
use Carbon\Carbon;

class MedicalRecordsTableSeeder extends Seeder
{
    public function run()
    {
        $doctorIds = Doctor::pluck('id')->toArray();
        $patientIds = Patient::pluck('id')->toArray();

        if (count($doctorIds) < 4 || count($patientIds) < 8) {
            $this->command->error('Tidak cukup data dokter atau pasien di tabel terkait.');
            return;
        }

        $records = [
            [
                'patient_id' => $patientIds[0],
                'doctor_id' => $doctorIds[0],
                'diagnosis' => 'Diabetes melitus tipe 2',
                'treatment' => 'Metformin 500mg, diet rendah gula',
                'record_date' => Carbon::now()->subDays(10)->setTime(10, 0, 0),
            ],
            [
                'patient_id' => $patientIds[1],
                'doctor_id' => $doctorIds[1],
                'diagnosis' => 'Asma bronkial',
                'treatment' => 'Salbutamol inhaler, hindari alergen',
                'record_date' => Carbon::now()->subDays(20)->setTime(11, 0, 0),
            ],
            [
                'patient_id' => $patientIds[2],
                'doctor_id' => $doctorIds[2],
                'diagnosis' => 'Hipertensi esensial',
                'treatment' => 'Amlodipin 5mg, diet rendah garam',
                'record_date' => Carbon::now()->subDays(15)->setTime(9, 0, 0),
            ],
            [
                'patient_id' => $patientIds[3],
                'doctor_id' => $doctorIds[3],
                'diagnosis' => 'Migrain kronis',
                'treatment' => 'Sumatriptan 50mg, hindari pemicu',
                'record_date' => Carbon::now()->subDays(5)->setTime(14, 0, 0),
            ],
            [
                'patient_id' => $patientIds[4],
                'doctor_id' => $doctorIds[0],
                'diagnosis' => 'Gastritis kronis',
                'treatment' => 'Omeprazole 20mg, hindari makanan pedas',
                'record_date' => Carbon::now()->subDays(12)->setTime(10, 30, 0),
            ],
            [
                'patient_id' => $patientIds[5],
                'doctor_id' => $doctorIds[1],
                'diagnosis' => 'Anemia defisiensi besi',
                'treatment' => 'Suplemen zat besi, diet tinggi zat besi',
                'record_date' => Carbon::now()->subDays(18)->setTime(11, 30, 0),
            ],
            [
                'patient_id' => $patientIds[6],
                'doctor_id' => $doctorIds[2],
                'diagnosis' => 'Osteoartritis',
                'treatment' => 'Paracetamol 500mg, fisioterapi',
                'record_date' => Carbon::now()->subDays(22)->setTime(9, 30, 0),
            ],
            [
                'patient_id' => $patientIds[7],
                'doctor_id' => $doctorIds[3],
                'diagnosis' => 'Depresi mayor',
                'treatment' => 'Sertraline 50mg, konseling psikologis',
                'record_date' => Carbon::now()->subDays(7)->setTime(14, 30, 0),
            ],
        ];

        foreach ($records as $record) {
            MedicalRecord::create($record);
        }

        $this->command->info('Seeder untuk catatan medis berhasil dijalankan.');
    }
}
