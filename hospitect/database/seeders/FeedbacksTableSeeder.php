<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feedback;
use App\Models\Appointment;

class FeedbacksTableSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk tabel feedbacks.
     *
     * @return void
     */
    public function run()
    {
        // Ambil janji konsultasi yang statusnya completed
        $appointments = Appointment::where('status', 'completed')->get();

        // Jika tidak ada janji konsultasi yang completed
        if ($appointments->isEmpty()) {
            $this->command->warn('Tidak ada janji konsultasi yang selesai untuk membuat feedback.');
            return;
        }

        foreach ($appointments as $appointment) {
            Feedback::create([
                'appointment_id' => $appointment->id,
                'patient_id' => $appointment->patient_id,
                'rating' => rand(1, 5), // Penilaian antara 1 hingga 5
                'comment' => 'Ulasan otomatis untuk janji konsultasi ID ' . $appointment->id,
            ]);
        }

        $this->command->info('Feedbacks berhasil dibuat.');
    }
}
