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
        'obat' => 'array', // Meng-cast kolom 'obat' sebagai array untuk menyimpan JSON
    ];

    // Relasi ke pasien
    public function pasien()
    {
        return $this->belongsTo(User::class, 'id_pasien', 'id');
    }

    // Relasi ke dokter
    public function dokter()
    {
        return $this->belongsTo(User::class, 'id_dokter', 'id');
    }
}
