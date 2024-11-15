<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';
    protected $fillable = ['user_id', 'medical_history', 'insurance_number'];

    /**
     * Relasi dengan model User.
     *
     * Menghubungkan setiap entri pasien dengan satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relasi dengan model MedicalRecord.
     *
     * Menghubungkan pasien dengan banyak rekam medis berdasarkan id_pasien.
     */
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'id_pasien', 'id');
    }

    /**
     * Relasi dengan model PatientDetail.
     *
     * Menghubungkan pasien dengan satu detail tambahan pada tabel patient_details.
     */
    public function details()
    {
        return $this->hasOne(PatientDetail::class, 'patient_id', 'id');
    }
}
