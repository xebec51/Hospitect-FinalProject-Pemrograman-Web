<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalKonsultasi;
use App\Models\User;

class ConsultationScheduleController extends Controller
{
    public function index()
    {
        $schedules = JadwalKonsultasi::with(['dokter', 'pasien'])->get();
        return view('dokter.schedule.index', compact('schedules'));
    }

    public function create()
    {
        $dokters = User::where('role', 'dokter')->get();
        $pasiens = User::where('role', 'pasien')->get();
        return view('dokter.schedule.create', compact('dokters', 'pasiens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pasien' => 'required|exists:users,id',
            'id_dokter' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        JadwalKonsultasi::create([
            'id_pasien' => $request->id_pasien,
            'id_dokter' => $request->id_dokter,
            'tanggal' => $request->tanggal,
            'catatan' => $request->catatan,
            'status' => $request->status ?? 'Pending',
        ]);

        return redirect()->route('dokter.jadwal-konsultasi.index')
            ->with('success', 'Jadwal konsultasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $schedule = JadwalKonsultasi::findOrFail($id);
        $dokters = User::where('role', 'dokter')->get();
        $pasiens = User::where('role', 'pasien')->get();
        return view('dokter.schedule.edit', compact('schedule', 'dokters', 'pasiens'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_pasien' => 'required|exists:users,id',
            'id_dokter' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        $schedule = JadwalKonsultasi::findOrFail($id);
        $schedule->update([
            'id_pasien' => $request->id_pasien,
            'id_dokter' => $request->id_dokter,
            'tanggal' => $request->tanggal,
            'catatan' => $request->catatan,
            'status' => $request->status,
        ]);

        return redirect()->route('dokter.jadwal-konsultasi.index')
            ->with('success', 'Jadwal konsultasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $schedule = JadwalKonsultasi::findOrFail($id);
        $schedule->delete();

        return redirect()->route('dokter.jadwal-konsultasi.index')
            ->with('success', 'Jadwal konsultasi berhasil dihapus.');
    }
}
