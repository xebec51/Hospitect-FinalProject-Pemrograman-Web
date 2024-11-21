<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Patient;
use App\Models\PatientDetail;

class PatientDetailController extends Controller
{
    /**
     * Tampilkan halaman profil pasien.
     */
    public function edit()
    {
        $patient = Auth::user()->patient;

        if (!$patient) {
            abort(404, 'Pasien tidak ditemukan.');
        }

        $patientDetails = $patient->details;

        return view('pasien.profil.index', compact('patient', 'patientDetails'));
    }

    /**
     * Perbarui informasi pasien.
     */
    public function update(Request $request)
    {
        $patient = Auth::user()->patient;

        if (!$patient) {
            abort(404, 'Pasien tidak ditemukan.');
        }

        $request->validate([
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'chronic_diseases' => 'nullable|string|max:255',
            'allergies' => 'nullable|string|max:255',
            'blood_type' => 'nullable|string|max:5',
            'medical_history' => 'nullable|string|max:1000',
            'insurance_number' => 'nullable|string|max:255',
        ]);

        // Perbarui atau buat detail pasien
        $patient->details()->updateOrCreate([], [
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
            'chronic_diseases' => $request->chronic_diseases,
            'allergies' => $request->allergies,
            'blood_type' => $request->blood_type,
        ]);

        // Perbarui data inti pasien
        $patient->update([
            'medical_history' => $request->medical_history,
            'insurance_number' => $request->insurance_number,
        ]);

        return Redirect::route('pasien.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
