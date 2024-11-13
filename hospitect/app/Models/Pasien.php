<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';

    // Kolom yang dapat diisi secara massal
    protected $fillable = ['user_id', 'medical_history', 'insurance_number'];

    /**
     * Relasi dengan model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi dengan model MedicalRecord untuk melihat rekam medis pasien.
     */
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'id_pasien');
    }
}
