<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MedicalRecord;
use App\Models\Appointment;
use App\Models\Feedback;

class PasienController extends Controller
{
    /**
     * Dashboard pasien.
     */
    public function index()
    {
        $patient = Auth::user()->patient;

        if (!$patient) {
            return abort(404, 'Pasien tidak ditemukan.');
        }

        $medicalRecords = MedicalRecord::where('patient_id', $patient->id)
            ->latest()
            ->take(5)
            ->with('doctor.user') // Eager load dokter
            ->get();

        $upcomingAppointments = Appointment::where('patient_id', $patient->id)
            ->where('date', '>=', now())
            ->with('doctor.user') // Eager load dokter
            ->orderBy('date')
            ->orderBy('time')
            ->get();

        return view('pasien.dashboard', compact('medicalRecords', 'upcomingAppointments'));
    }

    /**
     * Tampilkan rekam medis pasien.
     */
    public function showRecords()
    {
        $patient = Auth::user()->patient;

        if (!$patient) {
            return abort(404, 'Pasien tidak ditemukan.');
        }

        $appointments = Appointment::where('patient_id', $patient->id)
            ->with('doctor.user') // Eager load dokter
            ->orderBy('date', 'desc')
            ->get();

        return view('pasien.records.index', compact('appointments'));
    }

    /**
     * Tampilkan jadwal konsultasi pasien.
     */
    public function schedule()
    {
        $patient = Auth::user()->patient;

        if (!$patient) {
            return abort(404, 'Pasien tidak ditemukan.');
        }

        $appointments = Appointment::where('patient_id', $patient->id)
            ->with('doctor.user') // Eager load dokter
            ->orderBy('date')
            ->orderBy('time')
            ->get();

        return view('pasien.schedule', compact('appointments'));
    }

    /**
     * Simpan umpan balik pasien.
     */
    public function storeFeedback(Request $request)
    {
        $patient = Auth::user()->patient;

        if (!$patient) {
            return abort(404, 'Pasien tidak ditemukan.');
        }

        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        Feedback::updateOrCreate(
            ['appointment_id' => $request->appointment_id, 'patient_id' => $patient->id],
            ['rating' => $request->rating, 'comment' => $request->comment]
        );

        return redirect()->route('pasien.schedule')->with('success', 'Umpan balik berhasil disimpan.');
    }

    /**
     * Tampilkan profil pasien.
     */
    public function showProfile()
    {
        $patient = Auth::user()->patient;

        if (!$patient) {
            return abort(404, 'Pasien tidak ditemukan.');
        }

        return view('pasien.profile', compact('patient'));
    }

    /**
     * Perbarui profil pasien.
     */
    public function updateProfile(Request $request)
    {
        $patient = Auth::user()->patient;

        if (!$patient) {
            return abort(404, 'Pasien tidak ditemukan.');
        }

        $request->validate([
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
        ]);

        $patient->update([
            'address' => $request->address,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
        ]);

        return redirect()->route('pasien.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Perbarui informasi medis pasien.
     */
    public function updateMedicalProfile(Request $request)
    {
        $patient = Auth::user()->patient;

        if (!$patient) {
            return abort(404, 'Pasien tidak ditemukan.');
        }

        $request->validate([
            'medical_history' => 'nullable|string',
            'insurance_number' => 'nullable|string|max:50',
            'chronic_diseases' => 'nullable|string',
            'allergies' => 'nullable|string',
            'blood_type' => 'nullable|string|max:5',
        ]);

        $patient->medicalDetails()->updateOrCreate([], [
            'medical_history' => $request->medical_history,
            'insurance_number' => $request->insurance_number,
            'chronic_diseases' => $request->chronic_diseases,
            'allergies' => $request->allergies,
            'blood_type' => $request->blood_type,
        ]);

        return redirect()->route('pasien.profile')->with('success', 'Informasi medis berhasil diperbarui.');
    }
}
