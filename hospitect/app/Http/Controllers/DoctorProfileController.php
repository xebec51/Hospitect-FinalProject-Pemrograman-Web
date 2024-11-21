<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Doctor;
use App\Models\DoctorDetail;

class DoctorProfileController extends Controller
{
    /**
     * Tampilkan halaman profil dokter.
     */
    public function edit()
    {
        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            abort(404, 'Dokter tidak ditemukan.');
        }

        $doctorDetails = $doctor->details;

        return view('dokter.profil.index', compact('doctor', 'doctorDetails'));
    }

    /**
     * Perbarui profil dokter.
     */
    public function update(Request $request)
    {
        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            abort(404, 'Dokter tidak ditemukan.');
        }

        $request->validate([
            'phone' => 'nullable|string|max:20',
            'clinic_address' => 'nullable|string|max:255',
            'experience_years' => 'nullable|integer|min:0',
            'specialization' => 'nullable|string|max:255',
        ]);

        // Perbarui atau buat detail dokter
        $doctor->details()->updateOrCreate([], [
            'phone' => $request->phone,
            'clinic_address' => $request->clinic_address,
            'experience_years' => $request->experience_years,
        ]);

        // Perbarui data inti dokter
        $doctor->update([
            'specialization' => $request->specialization,
        ]);

        return Redirect::route('dokter.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
