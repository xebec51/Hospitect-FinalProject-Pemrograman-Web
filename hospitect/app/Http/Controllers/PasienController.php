<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MedicalRecord;
use App\Models\Appointment;
use App\Models\Feedback;
use App\Models\Pasien;
use App\Models\PatientDetail;

class PasienController extends Controller
{
    public function index()
    {
        $patient = Auth::user()->pasien;

        if (!$patient) {
            abort(404, 'Pasien tidak ditemukan.');
        }

        $medicalRecords = MedicalRecord::where('id_pasien', $patient->id)
                                        ->latest()
                                        ->take(5)
                                        ->get();

        $upcomingAppointments = Appointment::where('id_pasien', $patient->id)
                                           ->where('tanggal', '>=', now())
                                           ->orderBy('tanggal')
                                           ->get();

        return view('pasien.dashboard', compact('medicalRecords', 'upcomingAppointments'));
    }

    public function showRecords()
    {
        $patient = Auth::user()->pasien;

        if (!$patient) {
            abort(404, 'Pasien tidak ditemukan.');
        }

        $medicalRecords = MedicalRecord::where('id_pasien', $patient->id)
                            ->with(['dokter'])
                            ->get();

        return view('pasien.records.index', compact('medicalRecords'));
    }

    public function schedule()
    {
        $patient = Auth::user()->pasien;

        if (!$patient) {
            abort(404, 'Pasien tidak ditemukan.');
        }

        $appointments = Appointment::where('id_pasien', $patient->id)->get();

        return view('pasien.schedule', compact('appointments'));
    }

    public function storeFeedback(Request $request)
    {
        $patient = Auth::user()->pasien;

        if (!$patient) {
            abort(404, 'Pasien tidak ditemukan.');
        }

        $request->validate([
            'id_jadwal' => 'required|exists:appointments,id_jadwal',
            'penilaian' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string',
        ]);

        Feedback::create([
            'id_jadwal' => $request->id_jadwal,
            'id_pasien' => $patient->id,
            'penilaian' => $request->penilaian,
            'komentar' => $request->komentar,
        ]);

        return redirect()->route('pasien.schedule')->with('success', 'Umpan balik berhasil disimpan.');
    }

    public function showProfile()
    {
        $patient = Auth::user()->pasien;

        if (!$patient) {
            abort(404, 'Pasien tidak ditemukan.');
        }

        $patientDetails = $patient->details;

        return view('pasien.profile', compact('patient', 'patientDetails'));
    }

    public function updateProfile(Request $request)
    {
        $patient = Auth::user()->pasien;

        if (!$patient) {
            abort(404, 'Pasien tidak ditemukan.');
        }

        $request->validate([
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
        ]);

        $patient->details()->updateOrCreate([], [
            'address' => $request->address,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
        ]);

        return redirect()->route('pasien.profile')->with('success', 'Informasi pribadi berhasil diperbarui.');
    }

    public function updateMedicalProfile(Request $request)
    {
        $patient = Auth::user()->pasien;

        if (!$patient) {
            abort(404, 'Pasien tidak ditemukan.');
        }

        $request->validate([
            'medical_history' => 'nullable|string',
            'insurance_number' => 'nullable|string',
            'chronic_diseases' => 'nullable|string',
            'allergies' => 'nullable|string',
            'blood_type' => 'nullable|string',
        ]);

        $patient->details()->updateOrCreate([], [
            'medical_history' => $request->medical_history,
            'insurance_number' => $request->insurance_number,
            'chronic_diseases' => $request->chronic_diseases,
            'allergies' => $request->allergies,
            'blood_type' => $request->blood_type,
        ]);

        return redirect()->route('pasien.profile')->with('success', 'Informasi medis berhasil diperbarui.');
    }
}
