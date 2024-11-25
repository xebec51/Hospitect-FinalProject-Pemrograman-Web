<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Feedback;

/**
 * @property Patient $patient
 * @property Doctor $doctor
 * @property Feedback $feedback
 */
class Appointment extends Model
{
    use HasFactory;

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
            ->withDefault(); // Mencegah error saat data pasien tidak ditemukan
    }

    /**
     * Relasi ke model Doctor.
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id')
            ->withDefault(); // Mencegah error saat data dokter tidak ditemukan
    }

    /**
     * Relasi ke model Feedback.
     */
    public function feedback()
    {
        return $this->hasOne(Feedback::class, 'appointment_id', 'id');
    }

    /**
     * Scope untuk janji temu berdasarkan status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk janji temu yang akan datang.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', now())
            ->orderBy('date')
            ->orderBy('time');
    }
}
