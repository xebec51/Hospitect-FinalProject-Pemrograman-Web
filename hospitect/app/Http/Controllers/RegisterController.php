<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showPatientRegisterForm()
    {
        return view('auth.register');
    }

    public function registerPatient(Request $request)
    {
        // Validasi data registrasi
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Buat akun user baru dengan role pasien
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'pasien',
        ]);

        // Buat entri di tabel patients dengan user_id yang sesuai
        Patient::create([
            'user_id' => $user->id,
            'insurance_number' => null, // Nilai default
            'medical_history' => null,  // Nilai default
        ]);

        // Redirect ke halaman login setelah berhasil registrasi
        return redirect()->route('login')->with('info', 'Pendaftaran berhasil. Silakan login.');
    }
}
