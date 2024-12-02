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

    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'User not authenticated.');
        }

        // Jika pengguna adalah pasien, tampilkan hanya rekam medis mereka sendiri
        if ($user->patient) {
            $medicalRecords = MedicalRecord::where('patient_id', $user->patient->id)
                ->with(['doctor.user', 'medicines'])
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($user->role === 'admin') {
            // Jika pengguna adalah admin, tampilkan semua rekam medis
            $medicalRecords = MedicalRecord::with(['doctor.user', 'patient.user', 'medicines'])
                ->when($request->search, function ($query, $search) {
                    return $query->whereHas('patient.user', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    })->orWhereHas('doctor.user', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    })->orWhere('diagnosis', 'like', "%{$search}%");
                })
                ->when($request->sort, function ($query, $sort) use ($request) {
                    $direction = $request->direction === 'desc' ? 'desc' : 'asc';
                    return $query->orderBy($sort, $direction);
                }, function ($query) {
                    return $query->orderBy('created_at', 'desc');
                })
                ->paginate(10);  // Pagination untuk admin
        } elseif ($user->doctor) {
            // Jika pengguna adalah dokter, tampilkan rekam medis berdasarkan dokter
            $medicalRecords = MedicalRecord::where('doctor_id', $user->doctor->id)
                ->with(['patient.user', 'medicines'])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            abort(403, 'User role not recognized.');
        }

        $view = $user->role === 'admin' ? 'admin.medical-records.index' : 'dokter.medical_records.index';

        return view($view, compact('medicalRecords'));
    }

    public function create()
    {
        // Pastikan hanya dokter dan admin yang bisa membuat rekam medis
        if (!$this->doctor && $this->user->role !== 'admin') {
            abort(403, 'Anda tidak diizinkan membuat rekam medis.');
        }

        $patients = Patient::with('user')->get();
        $medicines = Medicine::all();

        $view = $this->user->role === 'admin' ? 'admin.medical_records.create' : 'dokter.medical_records.create';

        return view($view, compact('patients', 'medicines'));
    }

    public function store(Request $request)
    {
        // Pastikan hanya dokter dan admin yang bisa menyimpan rekam medis
        if (!$this->doctor && $this->user->role !== 'admin') {
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
            'doctor_id' => $this->doctor ? $this->doctor->id : null,
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

        $route = $this->user->role === 'admin' ? 'admin.medical-records.index' : 'dokter.medical-records.index';

        return redirect()->route($route)
                         ->with('success', 'Rekam medis berhasil ditambahkan.');
    }

    public function edit(MedicalRecord $medicalRecord)
    {
        // Memastikan hanya dokter dan admin yang bisa mengedit rekam medis
        if ($this->user->patient || ($this->user->role !== 'admin' && $medicalRecord->doctor_id !== $this->doctor->id)) {
            abort(403, 'Anda tidak diizinkan mengedit rekam medis ini.');
        }

        $patients = Patient::with('user')->get();
        $medicines = Medicine::all();

        $view = $this->user->role === 'admin' ? 'admin.medical_records.edit' : 'dokter.medical_records.edit';

        return view($view, compact('medicalRecord', 'patients', 'medicines'));
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        // Memastikan hanya dokter dan admin yang bisa memperbarui rekam medis
        if ($this->user->patient || ($this->user->role !== 'admin' && $medicalRecord->doctor_id !== $this->doctor->id)) {
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

        $route = $this->user->role === 'admin' ? 'admin.medical-records.index' : 'dokter.medical-records.index';

        return redirect()->route($route)
                         ->with('success', 'Rekam medis berhasil diperbarui.');
    }

    public function destroy(MedicalRecord $medicalRecord)
    {
        // Memastikan hanya dokter dan admin yang dapat menghapus rekam medis
        if ($this->user->patient || ($this->user->role !== 'admin' && $medicalRecord->doctor_id !== $this->doctor->id)) {
            abort(403, 'Anda tidak diizinkan menghapus rekam medis ini.');
        }

        // Menghapus hubungan obat dan rekam medis
        $medicalRecord->medicines()->detach();
        // Menghapus rekam medis dari database
        $medicalRecord->delete();

        $route = $this->user->role === 'admin' ? 'admin.medical-records.index' : 'dokter.medical-records.index';

        return redirect()->route($route)
                         ->with('success', 'Rekam medis berhasil dihapus.');
    }
}
