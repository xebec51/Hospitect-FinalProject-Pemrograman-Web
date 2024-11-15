<?php
// app/Models/PatientDetail.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientDetail extends Model
{
    use HasFactory;

    protected $table = 'patient_details';
    protected $fillable = [
        'patient_id',
        'phone',
        'date_of_birth',
        'address',
        'chronic_diseases',
        'allergies',
        'blood_type'
    ];

    // Relasi ke Pasien
    public function patient()
    {
        return $this->belongsTo(Pasien::class, 'patient_id');
    }
}

?>
