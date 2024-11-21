<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\DoctorAvailability;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class ConsultationScheduleController extends Controller
{
    /**
     * List semua jadwal konsultasi.
     */
    public function index()
    {
        $schedules = Appointment::with(['doctor.user', 'patient.user'])->get();
        return view('dokter.schedule.index', compact('schedules'));
    }

    /**
     * Tampilkan form untuk dokter membuat jadwal.
     */
    public function create()
    {
        $dokters = Doctor::with('user')->get();
        $pasiens = Patient::with('user')->get();
        return view('dokter.schedule.create', compact('dokters', 'pasiens'));
    }

    /**
     * Simpan jadwal yang dibuat oleh dokter.
     */
    public function store(Request $request)
    {
        $this->validateSchedule($request);

        Appointment::create($request->all());

        return redirect()->route('dokter.jadwal-konsultasi.index')->with('success', 'Jadwal konsultasi berhasil ditambahkan.');
    }

    /**
     * Edit jadwal konsultasi.
     */
    public function edit($id)
    {
        $schedule = Appointment::with(['doctor.user', 'patient.user'])->findOrFail($id);
        $dokters = Doctor::with('user')->get();
        $pasiens = Patient::with('user')->get();

        return view('dokter.schedule.edit', compact('schedule', 'dokters', 'pasiens'));
    }

    /**
     * Update jadwal konsultasi.
     */
    public function update(Request $request, $id)
    {
        $this->validateSchedule($request, $id);

        $schedule = Appointment::findOrFail($id);
        $schedule->update($request->all());

        return redirect()->route('dokter.jadwal-konsultasi.index')->with('success', 'Jadwal konsultasi berhasil diperbarui.');
    }

    /**
     * Hapus jadwal konsultasi.
     */
    public function destroy($id)
    {
        $schedule = Appointment::findOrFail($id);
        $schedule->delete();

        return redirect()->route('dokter.jadwal-konsultasi.index')->with('success', 'Jadwal konsultasi berhasil dihapus.');
    }

    /**
     * Tampilkan form untuk pasien membuat janji temu.
     */
    public function createForPatient()
    {
        $dokters = Doctor::with(['user', 'availabilities'])->get();
        return view('pasien.appointments.create', compact('dokters'));
    }

    /**
     * Simpan janji temu pasien.
     */
    public function storeForPatient(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
        ]);

        if (!$this->isDoctorAvailable($request->doctor_id, $request->date, $request->time)) {
            return redirect()->back()->withErrors(['time' => 'Dokter tidak tersedia pada waktu yang dipilih.']);
        }

        Appointment::create([
            'patient_id' => Auth::user()->patient->id,
            'doctor_id' => $request->doctor_id,
            'date' => $request->date,
            'time' => $request->time,
            'status' => 'scheduled',
        ]);

        return redirect()->route('pasien.schedule')->with('success', 'Janji temu berhasil dibuat.');
    }

    /**
     * Validasi jadwal untuk dokter/pasien.
     */
    protected function validateSchedule(Request $request, $excludeId = null)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:patients,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
            'notes' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:scheduled,completed,cancelled',
        ]);

        $conflictQuery = Appointment::where('doctor_id', $request->doctor_id)
            ->where('date', $request->date)
            ->where('time', $request->time);

        if ($excludeId) {
            $conflictQuery->where('id', '!=', $excludeId);
        }

        if ($conflictQuery->exists()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'time' => 'Jadwal bentrok dengan janji temu lain.',
            ]);
        }

        if (!$this->isDoctorAvailable($request->doctor_id, $request->date, $request->time)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'time' => 'Dokter tidak tersedia pada waktu yang dipilih.',
            ]);
        }
    }

    /**
     * Periksa ketersediaan dokter berdasarkan hari dan waktu.
     */
    protected function isDoctorAvailable($doctorId, $date, $time)
    {
        $dayName = now()->parse($date)->dayName;
        return DoctorAvailability::where('doctor_id', $doctorId)
            ->where('available_day', $dayName)
            ->where('start_time', '<=', $time)
            ->where('end_time', '>=', $time)
            ->exists();
    }

    /**
     * Simpan feedback dari pasien.
     */
    public function storeFeedback(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        $appointment = Appointment::findOrFail($request->appointment_id);

        if ($appointment->patient_id !== Auth::user()->patient->id) {
            return redirect()->back()->withErrors(['error' => 'Anda tidak berhak memberikan feedback untuk janji temu ini.']);
        }

        if ($appointment->feedback) {
            $appointment->feedback->update([
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);
            return redirect()->route('pasien.records')->with('success', 'Feedback berhasil diperbarui.');
        }

        Feedback::create([
            'appointment_id' => $appointment->id,
            'patient_id' => $appointment->patient_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('pasien.records')->with('success', 'Feedback berhasil disimpan.');
    }

    /**
     * Update status janji temu.
     */
    public function updateStatus(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        if (
            (auth()->user()->role === 'dokter' && $appointment->doctor_id !== auth()->user()->doctor->id) ||
            (auth()->user()->role === 'pasien' && $appointment->patient_id !== auth()->user()->patient->id)
        ) {
            return redirect()->back()->withErrors(['error' => 'Anda tidak memiliki izin untuk mengubah status ini.']);
        }

        $request->validate([
            'status' => 'required|in:scheduled,completed,cancelled',
        ]);

        $appointment->status = $request->status;
        $appointment->save();

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }
}
