<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = ['nama_obat', 'deskripsi', 'jenis_obat', 'stok', 'gambar_obat'];
    protected $primaryKey = 'id_obat';
    public $incrementing = true;
    protected $keyType = 'int';
}
