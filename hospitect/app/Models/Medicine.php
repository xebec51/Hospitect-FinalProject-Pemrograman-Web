<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    // Menentukan kolom yang dapat diisi secara massal
    protected $fillable = ['nama_obat', 'deskripsi', 'jenis_obat', 'stok', 'gambar_obat'];

    // Menentukan kunci utama jika berbeda dari 'id'
    protected $primaryKey = 'id_obat';

    // Menentukan apakah kunci utama merupakan integer (default true)
    public $incrementing = true;
    protected $keyType = 'int';
}
