<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medicine;

class MedicinesTableSeeder extends Seeder
{
    public function run()
    {
        $medicines = [
            ['name' => 'Paracetamol', 'description' => 'Antipiretik dan analgesik', 'type' => 'Tablet', 'stock' => 150],
            ['name' => 'Ibuprofen', 'description' => 'Anti-inflamasi nonsteroid', 'type' => 'Tablet', 'stock' => 100],
            ['name' => 'Amoxicillin', 'description' => 'Antibiotik untuk infeksi bakteri', 'type' => 'Kapsul', 'stock' => 120],
            ['name' => 'Captopril', 'description' => 'Pengobatan tekanan darah tinggi', 'type' => 'Tablet', 'stock' => 80],
            ['name' => 'Loratadine', 'description' => 'Antihistamin untuk alergi', 'type' => 'Tablet', 'stock' => 90],
            ['name' => 'Metformin', 'description' => 'Pengontrol diabetes', 'type' => 'Tablet', 'stock' => 200],
            ['name' => 'Omeprazole', 'description' => 'Penurunan asam lambung', 'type' => 'Kapsul', 'stock' => 110],
            ['name' => 'Salbutamol', 'description' => 'Bronkodilator untuk asma', 'type' => 'Sirup', 'stock' => 75],
            ['name' => 'Ranitidine', 'description' => 'Mengatasi masalah asam lambung', 'type' => 'Tablet', 'stock' => 50],
            ['name' => 'Diclofenac', 'description' => 'Anti-inflamasi untuk nyeri', 'type' => 'Tablet', 'stock' => 60],
            ['name' => 'Vitamin C', 'description' => 'Suplemen vitamin C', 'type' => 'Tablet', 'stock' => 300],
            ['name' => 'Acetaminophen', 'description' => 'Pereda nyeri ringan hingga sedang', 'type' => 'Tablet', 'stock' => 200],
            ['name' => 'Azithromycin', 'description' => 'Antibiotik untuk infeksi bakteri', 'type' => 'Tablet', 'stock' => 70],
            ['name' => 'Cetirizine', 'description' => 'Antihistamin untuk alergi', 'type' => 'Tablet', 'stock' => 90],
            ['name' => 'Dexamethasone', 'description' => 'Kortikosteroid untuk inflamasi', 'type' => 'Tablet', 'stock' => 40],
            ['name' => 'Amoxiclav', 'description' => 'Antibiotik kombinasi', 'type' => 'Tablet', 'stock' => 65],
            ['name' => 'Folic Acid', 'description' => 'Suplemen asam folat', 'type' => 'Tablet', 'stock' => 130],
            ['name' => 'Bromhexine', 'description' => 'Ekspektoran untuk batuk berdahak', 'type' => 'Sirup', 'stock' => 85],
            ['name' => 'Aspirin', 'description' => 'Anti-inflamasi dan analgesik', 'type' => 'Tablet', 'stock' => 150],
            ['name' => 'Chlorpheniramine', 'description' => 'Antihistamin untuk alergi', 'type' => 'Tablet', 'stock' => 120],
            ['name' => 'Antasida', 'description' => 'Obat untuk mengurangi asam lambung', 'type' => 'Tablet', 'stock' => 75],
            ['name' => 'Losartan', 'description' => 'Pengobatan hipertensi', 'type' => 'Tablet', 'stock' => 50],
            ['name' => 'Clopidogrel', 'description' => 'Antiagregasi trombosit', 'type' => 'Tablet', 'stock' => 60],
            ['name' => 'Glimepiride', 'description' => 'Pengobatan diabetes tipe 2', 'type' => 'Tablet', 'stock' => 45],
            ['name' => 'Insulin', 'description' => 'Pengobatan diabetes', 'type' => 'Injeksi', 'stock' => 30],
            ['name' => 'Diazepam', 'description' => 'Obat penenang', 'type' => 'Tablet', 'stock' => 40],
            ['name' => 'Amlodipine', 'description' => 'Pengobatan hipertensi', 'type' => 'Tablet', 'stock' => 70],
            ['name' => 'Bisoprolol', 'description' => 'Beta blocker untuk hipertensi', 'type' => 'Tablet', 'stock' => 55],
            ['name' => 'Furosemide', 'description' => 'Diuretik', 'type' => 'Tablet', 'stock' => 65],
            ['name' => 'Spironolactone', 'description' => 'Diuretik hemat kalium', 'type' => 'Tablet', 'stock' => 45],
            ['name' => 'Hydrochlorothiazide', 'description' => 'Diuretik untuk hipertensi', 'type' => 'Tablet', 'stock' => 100],
            ['name' => 'Simvastatin', 'description' => 'Pengobatan kolesterol tinggi', 'type' => 'Tablet', 'stock' => 80],
            ['name' => 'Prednisone', 'description' => 'Kortikosteroid untuk inflamasi', 'type' => 'Tablet', 'stock' => 60],
            ['name' => 'Warfarin', 'description' => 'Antikoagulan untuk mencegah pembekuan darah', 'type' => 'Tablet', 'stock' => 50],
            ['name' => 'Levothyroxine', 'description' => 'Pengobatan hipotiroidisme', 'type' => 'Tablet', 'stock' => 90],
        ];

        foreach ($medicines as $medicine) {
            Medicine::create($medicine);
        }
    }
}
