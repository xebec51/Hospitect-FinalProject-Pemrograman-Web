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
        $doctorId = Auth::id();
        $recentMedicalRecords = MedicalRecord::where('doctor_id', $doctorId)
            ->with(['patient.user', 'medicines']) // Tambahkan relasi medicines
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dokter.dashboard', compact('recentMedicalRecords'));
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
