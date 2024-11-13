<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKonsultasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_dokter',
        'id_pasien',
        'tanggal',
        'status',
        'catatan'
    ];

    /**
     * Relasi dengan model User sebagai Dokter.
     */
    public function dokter()
    {
        return $this->belongsTo(User::class, 'id_dokter');
    }

    /**
     * Relasi dengan model User sebagai Pasien.
     */
    public function pasien()
    {
        return $this->belongsTo(User::class, 'id_pasien');
    }
}
