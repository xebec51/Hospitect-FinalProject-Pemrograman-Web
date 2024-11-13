<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relasi dengan rekam medis di mana user bertindak sebagai pasien.
     */
    public function medicalRecordsAsPatient()
    {
        return $this->hasMany(MedicalRecord::class, 'id_pasien');
    }

    /**
     * Relasi dengan rekam medis di mana user bertindak sebagai dokter.
     */
    public function medicalRecordsAsDoctor()
    {
        return $this->hasMany(MedicalRecord::class, 'id_dokter');
    }

    /**
     * Relasi dengan janji konsultasi.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'id_pasien');
    }

    /**
     * Relasi dengan janji konsultasi sebagai dokter.
     */
    public function appointmentsAsDoctor()
    {
        return $this->hasMany(Appointment::class, 'id_dokter');
    }
}
