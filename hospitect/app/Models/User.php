<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\MedicalRecord;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;

/**
 * Class User
 *
 * @property \App\Models\Doctor $doctor
 * @property \App\Models\Patient $patient
 */

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relasi dengan model Patient.
     * Setiap User yang berperan sebagai pasien memiliki satu entri di tabel patients.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function patient()
    {
        return $this->hasOne(Patient::class, 'user_id', 'id');
    }

    /**
     * Relasi dengan model Doctor.
     * Setiap User yang berperan sebagai dokter memiliki satu entri di tabel doctors.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function doctor()
    {
        return $this->hasOne(Doctor::class, 'user_id', 'id');
    }

    /**
     * Relasi dengan rekam medis sebagai dokter.
     * Digunakan untuk mengambil rekam medis di mana user bertindak sebagai dokter.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function medicalRecordsAsDoctor()
    {
        return $this->hasMany(MedicalRecord::class, 'doctor_id', 'id');
    }

    /**
     * Relasi dengan janji konsultasi sebagai pasien.
     * Digunakan untuk mengambil semua janji konsultasi di mana user bertindak sebagai pasien.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id', 'id');
    }

    /**
     * Relasi dengan janji konsultasi sebagai dokter.
     * Digunakan untuk mengambil semua janji konsultasi di mana user bertindak sebagai dokter.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointmentsAsDoctor()
    {
        return $this->hasMany(Appointment::class, 'doctor_id', 'id');
    }
}
