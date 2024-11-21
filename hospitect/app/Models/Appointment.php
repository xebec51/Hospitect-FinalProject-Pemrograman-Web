<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi.
     */
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'date',
        'time',
        'status',
        'notes',
    ];

    /**
     * Casting atribut ke tipe data yang sesuai.
     */
    protected $casts = [
        'date' => 'date:Y-m-d', // Format tanggal
        'time' => 'string',    // Tetap sebagai string
    ];

    /**
     * Relasi ke model Patient.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id')
            ->with('user'); // Memastikan data user pasien tersedia
    }

    /**
     * Relasi ke model Doctor.
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id')
            ->with('user'); // Memastikan data user dokter tersedia
    }

    /**
     * Relasi ke model Feedback.
     */
    public function feedback()
    {
        return $this->hasOne(Feedback::class, 'appointment_id', 'id');
    }

    /**
     * Relasi untuk mendukung pengelompokan jadwal berdasarkan status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Relasi untuk mendukung pengelompokan jadwal berdasarkan tanggal.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', now())
            ->orderBy('date')
            ->orderBy('time');
    }
}
