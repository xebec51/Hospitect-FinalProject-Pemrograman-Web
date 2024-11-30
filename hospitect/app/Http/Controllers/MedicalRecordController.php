<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Medicine;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;

class MedicalRecordController extends Controller
{
    protected $doctor;
    protected $user;

    public function __construct()
    {
        $this->middleware('auth');  // Pastikan pengguna sudah login
        $this->user = Auth::user(); // Ambil data pengguna yang sedang login

        // Pastikan user adalah dokter dan memiliki relasi dokter
        if ($this->user && $this->user->doctor) {
            $this->doctor = $this->user->doctor;  // Ambil data dokter jika pengguna adalah dokter
        }
    }

    public function index()
    {
        // Jika pengguna adalah pasien, tampilkan hanya rekam medis mereka sendiri
        if ($this->user->patient) {
            $medicalRecords = MedicalRecord::where('patient_id', $this->user->patient->id)
                ->with(['doctor', 'medicines'])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Jika pengguna adalah dokter, tampilkan rekam medis berdasarkan dokter
            $medicalRecords = MedicalRecord::where('doctor_id', $this->doctor->id)
                ->with(['patient.user', 'medicines'])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('dokter.medical_records.index', compact('medicalRecords'));
    }

    public function create()
    {
        // Pastikan hanya dokter yang bisa membuat rekam medis
        if (!$this->doctor) {
            abort(403, 'Anda tidak diizinkan membuat rekam medis.');
        }

        $patients = Patient::with('user')->get();
        $medicines = Medicine::all();

        return view('dokter.medical_records.create', compact('patients', 'medicines'));
    }

    public function store(Request $request)
    {
        // Pastikan hanya dokter yang bisa menyimpan rekam medis
        if (!$this->doctor) {
            abort(403, 'Anda tidak diizinkan menyimpan rekam medis.');
        }

        // Validasi input
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'diagnosis' => 'required|string|max:255',
            'record_date' => 'required|date',
            'treatment' => 'nullable|string|max:255',
            'medicines.*.id' => 'required|exists:medicines,id',
            'medicines.*.dosage' => 'required|string|max:255',
            'medicines.*.instructions' => 'nullable|string|max:255',
        ]);

        // Menyimpan rekam medis baru
        $medicalRecord = MedicalRecord::create([
            'doctor_id' => $this->doctor->id,
            'patient_id' => $request->patient_id,
            'diagnosis' => $request->diagnosis,
            'record_date' => $request->record_date,
            'treatment' => $request->treatment,
        ]);

        // Menambahkan obat yang dikaitkan dengan rekam medis
        foreach ($request->medicines as $medicine) {
            $medicalRecord->medicines()->attach($medicine['id'], [
                'dosage' => $medicine['dosage'],
                'instructions' => $medicine['instructions'],
            ]);
        }

        return redirect()->route('dokter.medical-records.index')
                         ->with('success', 'Rekam medis berhasil ditambahkan.');
    }

    public function edit(MedicalRecord $medicalRecord)
    {
        // Memastikan hanya dokter yang bisa mengedit rekam medis mereka sendiri
        if ($this->user->patient || $medicalRecord->doctor_id !== $this->doctor->id) {
            abort(403, 'Anda tidak diizinkan mengedit rekam medis ini.');
        }

        $patients = Patient::with('user')->get();
        $medicines = Medicine::all();

        return view('dokter.medical_records.edit', compact('medicalRecord', 'patients', 'medicines'));
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        // Memastikan hanya dokter yang bisa memperbarui rekam medis mereka sendiri
        if ($this->user->patient || $medicalRecord->doctor_id !== $this->doctor->id) {
            abort(403, 'Anda tidak diizinkan memperbarui rekam medis ini.');
        }

        // Validasi input
        $request->validate([
            'diagnosis' => 'required|string|max:255',
            'record_date' => 'required|date',
            'treatment' => 'nullable|string|max:255',
            'medicines.*.id' => 'required|exists:medicines,id',
            'medicines.*.dosage' => 'required|string|max:255',
            'medicines.*.instructions' => 'nullable|string|max:255',
        ]);

        // Memperbarui data rekam medis
        $medicalRecord->update([
            'diagnosis' => $request->diagnosis,
            'record_date' => $request->record_date,
            'treatment' => $request->treatment,
        ]);

        // Menghapus obat yang sebelumnya dikaitkan dan menambahkan yang baru
        $medicalRecord->medicines()->detach();
        foreach ($request->medicines as $medicine) {
            $medicalRecord->medicines()->attach($medicine['id'], [
                'dosage' => $medicine['dosage'],
                'instructions' => $medicine['instructions'],
            ]);
        }

        return redirect()->route('dokter.medical-records.index')
                         ->with('success', 'Rekam medis berhasil diperbarui.');
    }

    public function destroy(MedicalRecord $medicalRecord)
    {
        // Memastikan hanya dokter yang dapat menghapus rekam medis mereka sendiri
        if ($this->user->patient || $medicalRecord->doctor_id !== $this->doctor->id) {
            abort(403, 'Anda tidak diizinkan menghapus rekam medis ini.');
        }

        // Menghapus hubungan obat dan rekam medis
        $medicalRecord->medicines()->detach();
        // Menghapus rekam medis dari database
        $medicalRecord->delete();

        return redirect()->route('dokter.medical-records.index')
                         ->with('success', 'Rekam medis berhasil dihapus.');
    }
}
