<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpiredMedicine extends Model
{
    use HasFactory;

    protected $fillable = ['medicine_id', 'expiration_date', 'quantity'];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class, 'medicine_id', 'id');
    }
}
