<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
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

        // Redirect kembali ke halaman medical records dengan pesan sukses
        return redirect()->route('pasien.records.index')->with('success', 'Feedback berhasil diperbarui.');
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
}
