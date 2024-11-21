<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'type', 'stock'];

    public function expiredMedicines()
    {
        return $this->hasMany(ExpiredMedicine::class, 'medicine_id', 'id');
    }

    public function medicalRecords()
    {
        return $this->belongsToMany(MedicalRecord::class, 'medical_record_medicines')
                    ->withPivot('dosage', 'instructions');
    }

    public function getAvailableStock()
    {
        $expiredStock = $this->expiredMedicines()->sum('quantity');
        return $this->stock - $expiredStock;
    }
}
