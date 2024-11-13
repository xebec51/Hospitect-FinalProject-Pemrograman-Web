<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MedicalRecord;
use App\Models\Appointment;
use App\Models\Feedback;

class PasienController extends Controller
{
    public function index()
    {
        $patientId = Auth::user()->id_pasien; // Mengakses ID pasien yang sesuai

        $medicalRecords = MedicalRecord::where('id_pasien', $patientId)
                                        ->latest()
                                        ->take(5)
                                        ->get();

        $upcomingAppointments = Appointment::where('id_pasien', $patientId)
                                           ->where('tanggal', '>=', now())
                                           ->orderBy('tanggal')
                                           ->get();

        return view('pasien.dashboard', compact('medicalRecords', 'upcomingAppointments'));
    }

    public function showRecords()
    {
        $patientId = Auth::user()->id_pasien;

        $medicalRecords = MedicalRecord::where('id_pasien', $patientId)->get();

        return view('pasien.records', compact('medicalRecords'));
    }

    public function schedule()
    {
        $patientId = Auth::user()->id_pasien;

        $appointments = Appointment::where('id_pasien', $patientId)->get();

        return view('pasien.schedule', compact('appointments'));
    }

    public function storeFeedback(Request $request)
    {
        $request->validate([
            'id_jadwal' => 'required|exists:appointments,id_jadwal',
            'penilaian' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string',
        ]);

        Feedback::create([
            'id_jadwal' => $request->id_jadwal,
            'id_pasien' => Auth::user()->id_pasien,
            'penilaian' => $request->penilaian,
            'komentar' => $request->komentar,
        ]);

        return redirect()->route('pasien.schedule')->with('success', 'Umpan balik berhasil disimpan.');
    }
}
