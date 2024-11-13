<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    protected $table = 'dokter';

    // Kolom yang dapat diisi secara massal
    protected $fillable = ['user_id', 'specialization', 'license_number'];

    /**
     * Relasi dengan model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi dengan model MedicalRecord untuk melihat rekam medis yang ditangani dokter.
     */
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'id_dokter');
    }
}
