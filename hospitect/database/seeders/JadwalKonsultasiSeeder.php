<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JadwalKonsultasi;
use App\Models\User;
use Carbon\Carbon;

class JadwalKonsultasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ambil daftar dokter dan pasien dari tabel Users
        $dokter = User::where('role', 'dokter')->get();
        $pasien = User::where('role', 'pasien')->get();

        // Buat beberapa data jadwal konsultasi sebagai contoh
        foreach ($dokter as $dok) {
            foreach ($pasien as $pas) {
                JadwalKonsultasi::create([
                    'id_dokter' => $dok->id,
                    'id_pasien' => $pas->id,
                    'tanggal' => Carbon::now()->addDays(rand(1, 30)), // Jadwal dalam 1-30 hari ke depan
                    'status' => 'scheduled', // Status awal
                    'catatan' => 'Konsultasi rutin', // Catatan contoh
                ]);
            }
        }
    }
}
