<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Appointment; // Add this line
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FeedbackController extends Controller
{
    /**
     * Tampilkan formulir untuk mengedit feedback.
     */
    public function edit($id)
    {
        // Mengambil feedback berdasarkan ID dan ID pasien yang sedang login
        $feedback = Feedback::where('id', $id)
            ->where('patient_id', Auth::user()->patient->id)
            ->first();

        // Jika feedback tidak ditemukan, arahkan kembali dengan pesan error
        if (!$feedback) {
            return redirect()->route('pasien.records.index')->with('error', 'Feedback tidak ditemukan.');
        }

        if ($feedback->appointment->status != 'completed') {
            return redirect()->route('pasien.records.index')->with('error', 'Feedback hanya dapat diedit jika janji temu sudah selesai.');
        }

        return view('pasien.feedback.edit', compact('feedback'));
    }

    /**
     * Simpan feedback yang diperbarui oleh pasien.
     */
    public function update(Request $request, $id)
    {
        // Validasi input dari formulir
        $request->validate([
            'rating' => 'required|integer|min:1|max:5', // Rating harus integer antara 1 hingga 5
            'comment' => 'nullable|string|max:500', // Komentar optional, dengan batasan panjang
        ]);

        // Menemukan feedback berdasarkan ID dan ID pasien yang sedang login
        $feedback = Feedback::where('id', $id)
            ->where('patient_id', Auth::user()->patient->id)
            ->first();

        // Jika feedback tidak ditemukan, arahkan kembali dengan pesan error
        if (!$feedback) {
            return redirect()->route('pasien.records.index')->with('error', 'Feedback tidak ditemukan.');
        }

        // Memperbarui feedback
        $feedback->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Redirect kembali ke halaman jadwal konsultasi dengan pesan sukses
        return redirect()->route('pasien.appointments.index')->with('success', 'Feedback berhasil diperbarui.');
    }

    /**
     * Tampilkan feedback untuk dokter.
     */
    public function indexForDoctor()
    {
        // Pastikan pengguna yang sedang login adalah dokter
        $doctorId = Auth::user()->doctor->id;

        // Ambil feedback yang terkait dengan jadwal konsultasi untuk dokter tertentu
        $feedbacks = Feedback::whereHas('appointment', function ($query) use ($doctorId) {
            $query->where('doctor_id', $doctorId);
        })
        ->with('appointment.patient.user') // Memuat data pasien yang berhubungan
        ->get();

        // Jika tidak ada feedback ditemukan, beri tahu dokter
        if ($feedbacks->isEmpty()) {
            return redirect()->route('dokter.dashboard')->with('info', 'Belum ada feedback untuk Anda.');
        }

        // Format tanggal pada setiap feedback menggunakan Carbon
        $feedbacks = $feedbacks->map(function ($feedback) {
            $feedback->appointment->formatted_date = Carbon::parse($feedback->appointment->date)->format('d/m/Y H:i');
            return $feedback;
        });

        return view('dokter.feedbacks.index', compact('feedbacks'));
    }

    public function create($appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);

        if ($appointment->status != 'completed') {
            return redirect()->route('pasien.records.index')->with('error', 'Feedback hanya dapat diberikan jika janji temu sudah selesai.');
        }

        return view('pasien.feedback.create', compact('appointment'));
    }

    public function store(Request $request)
    {
        // Validasi input dari formulir
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Pastikan janji temu sudah selesai
        $appointment = Appointment::findOrFail($request->appointment_id);
        if ($appointment->status != 'completed') {
            return redirect()->route('pasien.records.index')->with('error', 'Feedback hanya dapat diberikan jika janji temu sudah selesai.');
        }

        // Buat feedback baru
        Feedback::create([
            'appointment_id' => $request->appointment_id,
            'patient_id' => Auth::user()->patient->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Redirect kembali ke halaman jadwal konsultasi dengan pesan sukses
        return redirect()->route('pasien.appointments.index')->with('success', 'Feedback berhasil diberikan.');
    }
}
