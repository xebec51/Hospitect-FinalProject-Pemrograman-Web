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

// Halaman utama
Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect('/login');
});

// Dashboard peran pengguna
Route::get('/dashboard', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'dokter' => redirect()->route('dokter.dashboard'),
            'pasien' => redirect()->route('pasien.records'),
            default => abort(403, 'Unauthorized'),
        };
    }
    return redirect('/login');
})->name('dashboard');

// Autentikasi
require __DIR__ . '/auth.php';

// Grup rute untuk Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('/admin/users', UserController::class)->names('admin.users');
    Route::resource('/admin/medicines', MedicineController::class)->names('admin.medicines');
    // Tambahkan rute profil admin jika diperlukan
});

// Grup rute untuk Dokter
Route::middleware(['auth', 'role:dokter'])->group(function () {
    Route::get('/dokter/dashboard', [DokterController::class, 'index'])->name('dokter.dashboard');
    Route::resource('/dokter/medical-records', MedicalRecordController::class)->names('dokter.medical-records');
    Route::get('/dokter/schedule', [ConsultationScheduleController::class, 'index'])->name('dokter.schedule');
    Route::get('/dokter/profile', [DoctorProfileController::class, 'edit'])->name('dokter.profile');
    Route::post('/dokter/profile/update', [DoctorProfileController::class, 'update'])->name('dokter.profile.update');
    Route::resource('/dokter/jadwal-konsultasi', ConsultationScheduleController::class)->names('dokter.jadwal-konsultasi');
    Route::get('/dokter/feedback', [FeedbackController::class, 'indexForDoctor'])->name('dokter.feedback');
});

// Grup rute untuk Pasien
Route::middleware(['auth', 'role:pasien'])->group(function () {
    Route::get('/pasien/dashboard', [PasienController::class, 'index'])->name('pasien.dashboard');
    Route::get('/pasien/medical-records', [PasienController::class, 'showRecords'])->name('pasien.records');
    Route::get('/pasien/schedule', [PasienController::class, 'schedule'])->name('pasien.schedule');
    Route::post('/pasien/feedback/store', [FeedbackController::class, 'store'])->name('pasien.feedback.store');
    Route::get('/pasien/appointment/create', [ConsultationScheduleController::class, 'createForPatient'])->name('pasien.appointment.create');
    Route::post('/pasien/appointment/store', [ConsultationScheduleController::class, 'storeForPatient'])->name('pasien.appointment.store');
    Route::get('/pasien/profile', [PatientDetailController::class, 'edit'])->name('pasien.profile');
    Route::post('/pasien/profile/update', [PatientDetailController::class, 'update'])->name('pasien.profile.update');
    Route::post('/pasien/profile/delete', [PatientDetailController::class, 'destroy'])->name('pasien.profile.delete');
    Route::post('/pasien/feedback/update/{feedback}', [FeedbackController::class, 'update'])->name('pasien.feedback.update');
});

// Route update status untuk dokter dan pasien
Route::middleware(['auth'])->post('/appointments/{id}/update-status', [ConsultationScheduleController::class, 'updateStatus'])->name('appointments.update-status');

// Logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
