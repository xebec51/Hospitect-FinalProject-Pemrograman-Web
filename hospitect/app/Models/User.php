<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi melalui mass assignment.
     */
    protected $fillable = ['name', 'email', 'password', 'role', 'email_verified_at'];

    /**
     * Atribut yang disembunyikan saat serialisasi.
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Tipe atribut yang harus dikonversi.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relasi ke model Patient.
     */
    public function patient()
    {
        return $this->hasOne(Patient::class, 'user_id', 'id');
    }

    /**
     * Relasi ke model Doctor.
     */
    public function doctor()
    {
        return $this->hasOne(Doctor::class, 'user_id', 'id');
    }

    /**
     * Periksa apakah pengguna adalah admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Periksa apakah pengguna adalah dokter.
     */
    public function isDoctor()
    {
        return $this->role === 'dokter';
    }

    /**
     * Periksa apakah pengguna adalah pasien.
     */
    public function isPatient()
    {
        return $this->role === 'pasien';
    }
}
