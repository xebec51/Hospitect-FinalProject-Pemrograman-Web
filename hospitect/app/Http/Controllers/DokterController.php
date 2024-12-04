<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use Illuminate\Support\Facades\Auth;

class DokterController extends Controller
{
    /**
     * Tampilkan halaman dashboard dokter.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $doctorId = Auth::user()->doctor->id;
        $recentMedicalRecords = MedicalRecord::where('doctor_id', $doctorId)
            ->with(['patient.user', 'medicines']) // Tambahkan relasi medicines
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Generate data for charts
        $months = collect(range(1, 12))->map(function ($month) {
            return \Carbon\Carbon::create()->month($month)->translatedFormat('F');
        });

        $medicalRecordsData = MedicalRecord::selectRaw('MONTH(record_date) as month, COUNT(*) as count')
            ->where('doctor_id', $doctorId)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $medicalRecordsData = array_replace(array_fill_keys(range(1, 12), 0), $medicalRecordsData);
        $medicalRecordsData = array_values($medicalRecordsData);

        $appointmentsData = \App\Models\Appointment::selectRaw('MONTH(date) as month, COUNT(*) as count')
            ->where('doctor_id', $doctorId)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $appointmentsData = array_replace(array_fill_keys(range(1, 12), 0), $appointmentsData);
        $appointmentsData = array_values($appointmentsData);

        return view('dokter.dashboard', compact('recentMedicalRecords', 'months', 'medicalRecordsData', 'appointmentsData'));
    }

    /**
     * Tampilkan jadwal konsultasi dokter.
     *
     * @return \Illuminate\View\View
     */
    public function schedule()
    {
        $appointments = Auth::user()->appointmentsAsDoctor;

        return view('dokter.schedule', compact('appointments'));
    }
}
