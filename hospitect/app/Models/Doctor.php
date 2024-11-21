<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'specialization', 'license_number'];

    /**
     * Relasi dengan model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relasi dengan rekam medis.
     */
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'doctor_id', 'id');
    }

    /**
     * Relasi dengan janji temu.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id', 'id');
    }

    /**
     * Relasi dengan detail dokter.
     */
    public function details()
    {
        return $this->hasOne(DoctorDetail::class, 'doctor_id', 'id');
    }

    /**
     * Relasi dengan availabilities.
     */
    public function availabilities()
    {
        return $this->hasMany(DoctorAvailability::class, 'doctor_id', 'id');
    }
}
