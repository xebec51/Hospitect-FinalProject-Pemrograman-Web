<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Pastikan model User diimpor

class Patient extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'insurance_number', 'medical_history'];

    /**
     * Relasi dengan model User.
     * Menghubungkan patient ke user terkait.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relasi dengan detail pasien.
     */
    public function details()
    {
        return $this->hasOne(PatientDetail::class, 'patient_id', 'id');
    }

    /**
     * Relasi dengan janji temu.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id', 'id');
    }

    /**
     * Relasi dengan rekam medis pasien.
     */
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'patient_id', 'id');
    }

    /**
     * Relasi dengan feedback.
     */
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'patient_id', 'id');
    }
}
?>
