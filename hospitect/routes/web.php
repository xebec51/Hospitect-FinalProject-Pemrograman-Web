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

// Halaman utama yang mengarahkan berdasarkan status login
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect('/login');
});

// Rute dashboard yang mengarahkan berdasarkan peran pengguna
Route::get('/dashboard', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'dokter' => redirect()->route('dokter.dashboard'),
            'pasien' => redirect()->route('pasien.dashboard'),
            default => abort(403, 'Unauthorized')
        };
    }
    return redirect('/login');
})->name('dashboard');

// Rute otentikasi
require __DIR__.'/auth.php';

// Rute untuk admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('/admin/users', UserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'show' => 'admin.users.show',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);
    Route::resource('/admin/medicines', MedicineController::class)->names([
        'index' => 'admin.medicines.index',
        'create' => 'admin.medicines.create',
        'store' => 'admin.medicines.store',
        'show' => 'admin.medicines.show',
        'edit' => 'admin.medicines.edit',
        'update' => 'admin.medicines.update',
        'destroy' => 'admin.medicines.destroy',
    ]);
});

// Rute untuk dokter
Route::middleware(['auth', 'role:dokter'])->group(function () {
    Route::get('/dokter/dashboard', [DokterController::class, 'index'])->name('dokter.dashboard');
    Route::resource('/dokter/medical-records', MedicalRecordController::class)->names([
        'index' => 'dokter.medical-records.index',
        'create' => 'dokter.medical-records.create',
        'store' => 'dokter.medical-records.store',
        'show' => 'dokter.medical-records.show',
        'edit' => 'dokter.medical-records.edit',
        'update' => 'dokter.medical-records.update',
        'destroy' => 'dokter.medical-records.destroy',
    ]);
    Route::get('/dokter/schedule', [ConsultationScheduleController::class, 'index'])->name('dokter.schedule');

    // Rute profil untuk dokter
    Route::get('/dokter/profile', [DokterController::class, 'showProfile'])->name('dokter.profile');
    Route::post('/dokter/profile/update', [DokterController::class, 'updateProfile'])->name('dokter.profile.update');
});

// Rute khusus jadwal konsultasi dokter
Route::middleware(['auth', 'role:dokter'])->group(function () {
    Route::get('/dokter/jadwal-konsultasi', [ConsultationScheduleController::class, 'index'])->name('dokter.jadwal-konsultasi.index');
    Route::post('/dokter/jadwal-konsultasi', [ConsultationScheduleController::class, 'store'])->name('dokter.jadwal-konsultasi.store');
    Route::get('/dokter/jadwal-konsultasi/{id}/edit', [ConsultationScheduleController::class, 'edit'])->name('dokter.jadwal-konsultasi.edit');
    Route::put('/dokter/jadwal-konsultasi/{id}', [ConsultationScheduleController::class, 'update'])->name('dokter.jadwal-konsultasi.update');
    Route::delete('/dokter/jadwal-konsultasi/{id}', [ConsultationScheduleController::class, 'destroy'])->name('dokter.jadwal-konsultasi.destroy');
    Route::get('/dokter/jadwal-konsultasi/create', [ConsultationScheduleController::class, 'create'])->name('dokter.jadwal-konsultasi.create');
});

// Rute untuk pasien
Route::middleware(['auth', 'role:pasien'])->group(function () {
    Route::get('/pasien/dashboard', [PasienController::class, 'index'])->name('pasien.dashboard');
    Route::get('/pasien/medical-records', [PasienController::class, 'showRecords'])->name('pasien.records');
    Route::get('/pasien/schedule', [PasienController::class, 'schedule'])->name('pasien.schedule');
    Route::post('/pasien/feedback', [PasienController::class, 'storeFeedback'])->name('pasien.feedback');

    // Rute profil untuk pasien
    Route::get('/pasien/profile', [PasienController::class, 'showProfile'])->name('pasien.profile');
    Route::post('/pasien/profile/update', [PasienController::class, 'updateProfile'])->name('pasien.profile.update');
    Route::post('/pasien/profile/update-medical', [PasienController::class, 'updateMedicalProfile'])->name('pasien.profile.updateMedical'); // Tambahan
});

// Rute logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
