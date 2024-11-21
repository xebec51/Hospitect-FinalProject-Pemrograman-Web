<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FeedbackController extends Controller
{
    /**
     * Tampilkan formulir untuk membuat feedback.
     */
    public function create()
    {
        $appointments = Appointment::where('patient_id', Auth::user()->patient->id)
            ->where('status', 'completed') // Hanya janji temu yang sudah selesai
            ->where('date', '>=', Carbon::now()->subDays(3)) // Hanya janji temu dalam 3 hari terakhir
            ->with('doctor.user') // Ambil data dokter dan user terkait
            ->get();

        return view('pasien.feedback.create', compact('appointments'));
    }

    /**
     * Simpan feedback yang dibuat oleh pasien.
     */
    public function store(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Periksa apakah janji temu valid dan milik pasien
        $appointment = Appointment::where('id', $request->appointment_id)
            ->where('patient_id', Auth::user()->patient->id)
            ->where('status', 'completed')
            ->where('date', '>=', Carbon::now()->subDays(3)) // Hanya janji temu dalam 3 hari terakhir
            ->first();

        if (!$appointment) {
            return redirect()->back()->withErrors(['error' => 'Akses tidak diizinkan atau janji temu tidak valid.']);
        }

        // Simpan data feedback ke database
        Feedback::create([
            'appointment_id' => $appointment->id,
            'patient_id' => Auth::user()->patient->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('pasien.schedule')->with('success', 'Feedback berhasil dikirim.');
    }

    /**
     * Dokter melihat semua feedback.
     */
    public function indexForDoctor()
    {
        $doctorId = Auth::user()->doctor->id; // Ambil ID dokter saat ini

        // Cari feedback yang relevan dengan dokter ini
        $feedbacks = Feedback::whereHas('appointment', function ($query) use ($doctorId) {
            $query->where('doctor_id', $doctorId);
        })->with('appointment.patient.user') // Ambil data pasien dan user terkait
          ->get();

        return view('dokter.feedbacks.index', compact('feedbacks'));
    }
}
