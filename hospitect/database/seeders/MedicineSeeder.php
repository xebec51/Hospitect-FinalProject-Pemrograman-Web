<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medicine;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medicines = [
            [
                'nama_obat' => 'Paracetamol',
                'deskripsi' => 'Pain reliever and a fever reducer.',
                'jenis_obat' => 'biasa',
                'stok' => 100,
                'gambar_obat' => 'paracetamol.jpg',
            ],
            [
                'nama_obat' => 'Ibuprofen',
                'deskripsi' => 'Nonsteroidal anti-inflammatory drug (NSAID).',
                'jenis_obat' => 'keras',
                'stok' => 50,
                'gambar_obat' => 'ibuprofen.jpg',
            ],
            [
                'nama_obat' => 'Amoxicillin',
                'deskripsi' => 'Antibiotic used to treat bacterial infections.',
                'jenis_obat' => 'biasa',
                'stok' => 75,
                'gambar_obat' => 'amoxicillin.jpg',
            ],
        ];

        foreach ($medicines as $medicine) {
            Medicine::create($medicine);
        }
    }
}
