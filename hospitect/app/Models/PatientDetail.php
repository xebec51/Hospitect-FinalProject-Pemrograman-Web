<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'phone',
        'date_of_birth',
        'address',
        'chronic_diseases',
        'allergies',
        'blood_type',
    ];

    /**
     * Relasi dengan model Patient.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }
}
