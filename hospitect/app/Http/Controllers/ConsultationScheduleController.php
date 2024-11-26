<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;

class ConsultationScheduleController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['doctor.user', 'patient.user'])
            ->when(Auth::user()->role === 'pasien', function ($query) {
                $query->where('patient_id', Auth::user()->patient->id ?? null);
            })
            ->when(Auth::user()->role === 'dokter', function ($query) {
                $query->where('doctor_id', Doctor::where('user_id', Auth::id())->value('id'));
            })
            ->get();

        $view = Auth::user()->role === 'pasien' ? 'pasien.appointments.index' : 'dokter.appointments.index';

        return view($view, compact('appointments'));
    }

    public function create()
    {
        $dokters = Doctor::with('user')->get();
        $pasiens = Patient::with('user')->get();
        $timeSlots = $this->generateTimeSlots();

        $view = Auth::user()->role === 'pasien' ? 'pasien.appointments.create' : 'dokter.appointments.create';

        return view($view, compact('dokters', 'pasiens', 'timeSlots'));
    }

    public function store(Request $request)
    {
        $rules = [
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
        ];

        if (Auth::user()->role === 'dokter') {
            $rules['patient_id'] = 'required|exists:patients,id';
        }

        $request->validate($rules);

        $patientId = Auth::user()->role === 'pasien' ? optional(Auth::user()->patient)->id : $request->patient_id;

        if (!$patientId) {
            return redirect()->back()->withErrors(['patient_id' => 'Data pasien tidak ditemukan.']);
        }

        Appointment::create([
            'doctor_id' => $request->doctor_id,
            'patient_id' => $patientId,
            'date' => $request->date,
            'time' => $request->time,
            'status' => 'scheduled',
        ]);

        $route = Auth::user()->role === 'pasien' ? 'pasien.appointments.index' : 'dokter.appointments.index';

        return redirect()->route($route)->with('success', 'Janji temu berhasil dibuat.');
    }

    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);

        $this->authorizeAccess($appointment);

        $dokters = Doctor::with('user')->get();
        $pasiens = Patient::with('user')->get();
        $timeSlots = $this->generateTimeSlots();

        $view = Auth::user()->role === 'pasien' ? 'pasien.appointments.edit' : 'dokter.appointments.edit';

        return view($view, compact('appointment', 'dokters', 'pasiens', 'timeSlots'));
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $this->authorizeAccess($appointment);

        $rules = [
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
        ];

        if (Auth::user()->role === 'dokter') {
            $rules['patient_id'] = 'required|exists:patients,id';
        }

        $request->validate($rules);

        $appointment->update([
            'doctor_id' => $request->doctor_id,
            'patient_id' => $request->patient_id ?? $appointment->patient_id,
            'date' => $request->date,
            'time' => $request->time,
        ]);

        $route = Auth::user()->role === 'pasien' ? 'pasien.appointments.index' : 'dokter.appointments.index';

        return redirect()->route($route)->with('success', 'Janji temu berhasil diperbarui.');
    }

    public function updateStatus(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        // Pastikan hanya dokter terkait yang memiliki akses
        if (Auth::user()->role !== 'dokter' || $appointment->doctor_id !== Doctor::where('user_id', Auth::id())->value('id')) {
            abort(403, 'Akses tidak diizinkan.');
        }

        // Validasi input status
        $request->validate([
            'status' => 'required|in:scheduled,completed,cancelled',
        ]);

        // Perbarui status
        $appointment->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status janji temu berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);

        $this->authorizeAccess($appointment);

        $appointment->delete();

        $route = Auth::user()->role === 'pasien' ? 'pasien.appointments.index' : 'dokter.appointments.index';

        return redirect()->route($route)->with('success', 'Janji temu berhasil dihapus.');
    }

    private function generateTimeSlots($start = '07:00', $end = '17:00', $interval = 15)
    {
        $slots = [];
        $startTime = now()->setTimeFromTimeString($start);
        $endTime = now()->setTimeFromTimeString($end);

        while ($startTime->lt($endTime)) {
            $slots[] = $startTime->format('H:i');
            $startTime->addMinutes($interval);
        }

        return $slots;
    }

    private function authorizeAccess(Appointment $appointment)
    {
        if (Auth::user()->role === 'pasien' && $appointment->patient_id !== Auth::user()->patient->id) {
            abort(403, 'Akses tidak diizinkan.');
        }

        if (Auth::user()->role === 'dokter' && $appointment->doctor_id !== Doctor::where('user_id', Auth::id())->value('id')) {
            abort(403, 'Akses tidak diizinkan.');
        }
    }
}
