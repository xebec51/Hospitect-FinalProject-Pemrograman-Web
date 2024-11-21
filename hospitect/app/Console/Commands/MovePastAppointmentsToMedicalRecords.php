<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use Carbon\Carbon;

class MovePastAppointmentsToMedicalRecords extends Command
{
    protected $signature = 'appointments:move-to-medical-records';
    protected $description = 'Move past appointments to medical records';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $pastAppointments = Appointment::where('date', '<', Carbon::now())->get();

        foreach ($pastAppointments as $appointment) {
            MedicalRecord::create([
                'patient_id' => $appointment->patient_id,
                'doctor_id' => $appointment->doctor_id,
                'record_date' => $appointment->date,
                'diagnosis' => $appointment->notes,
            ]);

            $appointment->delete();
        }

        $this->info('Past appointments have been moved to medical records.');
    }
}
