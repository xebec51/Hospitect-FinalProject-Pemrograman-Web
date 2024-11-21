<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\MovePastAppointmentsToMedicalRecords;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('schedule:run', function (Schedule $schedule) {
    $schedule->command(MovePastAppointmentsToMedicalRecords::class)->daily();
});
