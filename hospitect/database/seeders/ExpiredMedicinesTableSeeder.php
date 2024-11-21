<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExpiredMedicine;
use App\Models\Medicine;
use Carbon\Carbon;

class ExpiredMedicinesTableSeeder extends Seeder
{
    public function run()
    {
        // Ambil semua obat dari tabel medicines
        $medicines = Medicine::all();

        foreach ($medicines as $medicine) {
            // Menambahkan entri kedaluwarsa untuk setiap obat
            ExpiredMedicine::create([
                'medicine_id' => $medicine->id,
                'expiration_date' => Carbon::now()->subMonths(rand(1, 12)), // Expired 1 hingga 12 bulan yang lalu
                'quantity' => rand(1, 50), // Jumlah stok kadaluarsa secara acak
            ]);
        }
    }
}
