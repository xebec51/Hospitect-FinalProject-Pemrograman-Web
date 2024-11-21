<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Medicine;
use Illuminate\Support\Facades\Auth;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $medicalRecords = MedicalRecord::where('doctor_id', Auth::user()->doctor->id)
            ->with(['patient.user', 'medicines'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dokter.medical_records.index', compact('medicalRecords'));
    }

    public function create()
    {
        $patients = Patient::with('user')->get();
        $medicines = Medicine::all();
        return view('dokter.medical_records.create', compact('patients', 'medicines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'diagnosis' => 'required|string|max:255',
            'record_date' => 'required|date',
            'treatment' => 'nullable|string|max:255',
            'medicines.*.id' => 'required|exists:medicines,id',
            'medicines.*.dosage' => 'required|string|max:255',
            'medicines.*.instructions' => 'nullable|string|max:255',
        ]);

        $doctorId = Auth::user()->doctor->id;

        $medicalRecord = MedicalRecord::create([
            'doctor_id' => $doctorId,
            'patient_id' => $request->patient_id,
            'diagnosis' => $request->diagnosis,
            'record_date' => $request->record_date,
            'treatment' => $request->treatment,
        ]);

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
        if ($medicalRecord->doctor_id !== Auth::user()->doctor->id) {
            abort(403, 'Anda tidak diizinkan mengedit rekam medis ini.');
        }

        $patients = Patient::with('user')->get();
        $medicines = Medicine::all();

        return view('dokter.medical_records.edit', compact('medicalRecord', 'patients', 'medicines'));
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        if ($medicalRecord->doctor_id !== Auth::user()->doctor->id) {
            abort(403, 'Anda tidak diizinkan mengedit rekam medis ini.');
        }

        $request->validate([
            'diagnosis' => 'required|string|max:255',
            'record_date' => 'required|date',
            'treatment' => 'nullable|string|max:255',
            'medicines.*.id' => 'required|exists:medicines,id',
            'medicines.*.dosage' => 'required|string|max:255',
            'medicines.*.instructions' => 'nullable|string|max:255',
        ]);

        $medicalRecord->update([
            'diagnosis' => $request->diagnosis,
            'record_date' => $request->record_date,
            'treatment' => $request->treatment,
        ]);

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
        if ($medicalRecord->doctor_id !== Auth::user()->doctor->id) {
            abort(403, 'Anda tidak diizinkan menghapus rekam medis ini.');
        }

        $medicalRecord->medicines()->detach();
        $medicalRecord->delete();

        return redirect()->route('dokter.medical-records.index')
                         ->with('success', 'Rekam medis berhasil dihapus.');
    }
}
?>
