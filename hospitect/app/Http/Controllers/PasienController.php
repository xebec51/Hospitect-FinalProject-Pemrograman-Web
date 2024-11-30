<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MedicalRecord;
use App\Models\Appointment;
use App\Models\Feedback;
use Carbon\Carbon;

class PasienController extends Controller
{
    /**
     * Dashboard pasien.
     */
    public function index()
    {
        $patient = Auth::user()->patient;

        // Validasi apakah pasien ada
        abort_if(!$patient, 404, 'Pasien tidak ditemukan di dashboard.');

        // Mengambil rekam medis pasien terbaru dengan eager loading relasi 'doctor.user'
        $medicalRecords = MedicalRecord::where('patient_id', $patient->id)
            ->latest()
            ->take(5)
            ->with('doctor.user') // Eager load doctor.user relasi
            ->get();

        // Mengambil jadwal konsultasi mendatang
        $upcomingAppointments = Appointment::where('patient_id', $patient->id)
            ->where('date', '>=', now())
            ->with('doctor.user') // Eager load dokter
            ->orderBy('date')
            ->orderBy('time')
            ->get();

        return view('pasien.dashboard', compact('medicalRecords', 'upcomingAppointments'));
    }

    /**
     * Tampilkan rekam medis pasien dengan pencarian dan penyortiran.
     */
    public function showRecords(Request $request)
    {
        $patient = Auth::user()->patient;

        $query = MedicalRecord::where('patient_id', $patient->id);

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('diagnosis', 'like', '%' . $request->search . '%')
                  ->orWhere('treatment', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('sort') && $request->has('direction')) {
            $query->orderBy($request->sort, $request->direction);
        } else {
            $query->orderBy('record_date', 'desc');
        }

        $medicalRecords = $query->paginate(10);

        return view('pasien.records.index', compact('medicalRecords'));
    }

    /**
     * Tampilkan jadwal konsultasi pasien.
     */
    public function schedule()
    {
        $patient = Auth::user()->patient;

        // Validasi apakah pasien ada
        abort_if(!$patient, 404, 'Pasien tidak ditemukan pada jadwal konsultasi.');

        $appointments = Appointment::where('patient_id', $patient->id)
            ->with('doctor.user')
            ->orderBy('date')
            ->get();

        return view('pasien.schedule', compact('appointments'));
    }

    /**
     * Simpan umpan balik pasien.
     */
    public function storeFeedback(Request $request)
    {
        $patient = Auth::user()->patient;

        // Validasi keberadaan pasien
        abort_if(!$patient, 404, 'Pasien tidak ditemukan saat menyimpan umpan balik.');

        // Validasi input feedback
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Cek apakah janji temu tersedia
        $appointment = Appointment::find($request->appointment_id);
        abort_if(!$appointment, 404, 'Janji temu tidak ditemukan.');

        // Mengecek apakah feedback sudah lebih dari 3 hari dari konsultasi
        if (Carbon::parse($appointment->date)->addDays(3)->isPast()) {
            return redirect()->route('pasien.schedule')->with('error', 'Umpan balik hanya bisa diberikan dalam 3 hari setelah konsultasi.');
        }

        // Menyimpan feedback atau memperbarui jika sudah ada
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

        // Validasi apakah pasien ada
        abort_if(!$patient, 404, 'Pasien tidak ditemukan saat menampilkan profil.');

        return view('pasien.profile', compact('patient'));
    }

    /**
     * Perbarui profil pasien.
     */
    public function updateProfile(Request $request)
    {
        $patient = Auth::user()->patient;

        // Validasi apakah pasien ada
        abort_if(!$patient, 404, 'Pasien tidak ditemukan saat memperbarui profil.');

        $request->validate([
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
        ]);

        // Update informasi profil pasien
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

        // Validasi apakah pasien ada
        abort_if(!$patient, 404, 'Pasien tidak ditemukan saat memperbarui informasi medis.');

        $request->validate([
            'medical_history' => 'nullable|string',
            'insurance_number' => 'nullable|string|max:50',
            'chronic_diseases' => 'nullable|string',
            'allergies' => 'nullable|string',
            'blood_type' => 'nullable|string|max:5',
        ]);

        // Update atau buat informasi medis pasien
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
