<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use App\Models\Pasien;
use Illuminate\Support\Facades\Auth;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $medicalRecords = MedicalRecord::where('id_dokter', Auth::id())
            ->with('pasien.user') // Relasi dengan user untuk menampilkan nama pasien
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dokter.medical_records.index', compact('medicalRecords'));
    }

    public function create()
    {
        $patients = Pasien::with('user')->get();
        return view('dokter.medical_records.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pasien' => 'required|exists:pasien,id',
            'tindakan' => 'required|string',
            'tanggal_periksa' => 'required|date',
            'obat' => 'nullable|string',
        ]);

        MedicalRecord::create([
            'id_dokter' => Auth::id(),
            'id_pasien' => $request->id_pasien,
            'tindakan' => $request->tindakan,
            'tanggal_periksa' => $request->tanggal_periksa,
            'obat' => $request->obat,
        ]);

        return redirect()->route('dokter.medical-records.index')
                         ->with('success', 'Rekam medis berhasil ditambahkan');
    }

    public function edit(MedicalRecord $medicalRecord)
    {
        if ($medicalRecord->id_dokter !== Auth::id()) {
            abort(403, 'Anda tidak diizinkan mengedit rekam medis ini.');
        }

        $patients = Pasien::with('user')->get();
        return view('dokter.medical_records.edit', compact('medicalRecord', 'patients'));
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        if ($medicalRecord->id_dokter !== Auth::id()) {
            abort(403, 'Anda tidak diizinkan mengedit rekam medis ini.');
        }

        $request->validate([
            'tindakan' => 'required|string',
            'tanggal_periksa' => 'required|date',
            'obat' => 'nullable|string',
        ]);

        $medicalRecord->update([
            'tindakan' => $request->tindakan,
            'tanggal_periksa' => $request->tanggal_periksa,
            'obat' => $request->obat,
        ]);

        return redirect()->route('dokter.medical-records.index')
                         ->with('success', 'Rekam medis berhasil diperbarui');
    }

    public function destroy(MedicalRecord $medicalRecord)
    {
        if ($medicalRecord->id_dokter !== Auth::id()) {
            abort(403, 'Anda tidak diizinkan menghapus rekam medis ini.');
        }

        $medicalRecord->delete();

        return redirect()->route('dokter.medical-records.index')
                         ->with('success', 'Rekam medis berhasil dihapus');
    }
}
