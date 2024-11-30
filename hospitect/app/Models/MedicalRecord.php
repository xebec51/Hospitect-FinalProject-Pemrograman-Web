<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = ['doctor_id', 'patient_id', 'diagnosis', 'treatment', 'record_date'];

    protected $casts = [
        'record_date' => 'datetime',
    ];

    /**
     * Relasi ke model Patient.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    /**
     * Relasi ke model Doctor.
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id');
    }

    /**
     * Relasi ke model Medicine.
     */
    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'medical_record_medicines')
                    ->withPivot('dosage', 'instructions');
    }
}
