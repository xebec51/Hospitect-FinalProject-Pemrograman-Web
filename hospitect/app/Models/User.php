<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\MedicalRecord;
use App\Models\Appointment;
use App\Models\Pasien;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relasi dengan model Pasien.
     *
     * Setiap User yang berperan sebagai pasien memiliki satu entri di tabel pasien.
     */
    public function pasien()
    {
        return $this->hasOne(Pasien::class, 'user_id', 'id');
    }

    /**
     * Relasi dengan rekam medis sebagai dokter.
     *
     * Digunakan untuk mengambil rekam medis di mana user bertindak sebagai dokter.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function medicalRecordsAsDoctor()
    {
        return $this->hasMany(MedicalRecord::class, 'id_dokter', 'id');
    }

    /**
     * Relasi dengan janji konsultasi sebagai pasien.
     *
     * Digunakan untuk mengambil semua janji konsultasi di mana user bertindak sebagai pasien.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'id_pasien', 'id');
    }

    /**
     * Relasi dengan janji konsultasi sebagai dokter.
     *
     * Digunakan untuk mengambil semua janji konsultasi di mana user bertindak sebagai dokter.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointmentsAsDoctor()
    {
        return $this->hasMany(Appointment::class, 'id_dokter', 'id');
    }
}
