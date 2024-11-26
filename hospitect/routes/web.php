<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\ConsultationScheduleController;
use App\Http\Controllers\PatientDetailController;
use App\Http\Controllers\DoctorProfileController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\RegisterController;

// Halaman utama
Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect('/login');
});

// Dashboard berdasarkan peran pengguna
Route::get('/dashboard', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        return redirect()->route($role . '.dashboard');
    }
    return redirect('/login');
})->name('dashboard');

// Autentikasi
require __DIR__ . '/auth.php';

// Grup rute untuk Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('/users', UserController::class)->names('users');
    Route::resource('/medicines', MedicineController::class)->names('medicines');
    Route::get('/profile', [UserController::class, 'edit'])->name('profile');
    Route::post('/profile/update', [UserController::class, 'update'])->name('profile.update');
});

// Grup rute untuk Dokter
Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard', [DokterController::class, 'index'])->name('dashboard');
    Route::resource('/appointments', ConsultationScheduleController::class)->names('appointments');
    Route::resource('/medical-records', MedicalRecordController::class)->names('medical-records');
    Route::get('/profile', [DoctorProfileController::class, 'edit'])->name('profile');
    Route::post('/profile/update', [DoctorProfileController::class, 'update'])->name('profile.update');
    Route::get('/feedback', [FeedbackController::class, 'indexForDoctor'])->name('feedback');

    // Rute untuk dokter memperbarui status janji temu
    Route::post('/appointments/{id}/update-status', [ConsultationScheduleController::class, 'updateStatus'])->name('appointments.update-status');
});

// Grup rute untuk Pasien
Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->name('pasien.')->group(function () {
    Route::get('/dashboard', [PasienController::class, 'index'])->name('dashboard');
    Route::resource('/appointments', ConsultationScheduleController::class)->names('appointments');
    Route::get('/medical-records', [PasienController::class, 'showRecords'])->name('records');
    Route::get('/profile', [PatientDetailController::class, 'edit'])->name('profile');
    Route::post('/profile/update', [PatientDetailController::class, 'update'])->name('profile.update');
    Route::post('/profile/delete', [PatientDetailController::class, 'destroy'])->name('profile.delete');

    // Rute untuk fitur feedback
    Route::post('/feedback/store', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::post('/feedback/update/{feedback}', [FeedbackController::class, 'update'])->name('feedback.update');
});

// Logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Fallback untuk rute tidak ditemukan
Route::fallback(function () {
    if (request()->expectsJson()) {
        return response()->json(['message' => 'Halaman tidak ditemukan.'], 404);
    }
    return response()->view('errors.404', [], 404);
});

// Rute untuk registrasi pasien
Route::get('/register', [RegisterController::class, 'showPatientRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'registerPatient'])->name('register.store');
