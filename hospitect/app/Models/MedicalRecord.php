<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = ['id_dokter', 'id_pasien', 'tindakan', 'tanggal_periksa', 'obat'];

    protected $primaryKey = 'id_rekam_medis';

    public $incrementing = true;

    protected $casts = [
        'tanggal_periksa' => 'datetime',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'id_dokter', 'id');
    }

    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'medical_record_medicine', 'id_rekam_medis', 'id_obat');
    }
}
