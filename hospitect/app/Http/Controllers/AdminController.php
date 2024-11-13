<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Medicine;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Tampilkan halaman dashboard admin.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Menghitung total pengguna, dokter, pasien, dan obat yang aktif
        $totalUsers = User::count();
        $totalDoctors = User::where('role', 'dokter')->count();
        $totalPatients = User::where('role', 'pasien')->count();
        $activeMedicines = Medicine::where('stok', '>', 0)->count();

        // Menambahkan total laporan operasional, misalnya dari tabel medical_records
        $totalReports = DB::table('medical_records')->count();

        // Mengirimkan variabel ke view
        return view('admin.dashboard', compact('totalUsers', 'totalDoctors', 'totalPatients', 'activeMedicines', 'totalReports'));
    }

    /**
     * Tampilkan laporan operasional rumah sakit.
     *
     * @return \Illuminate\View\View
     */
    public function reports()
    {
        // Perbaiki join untuk menggunakan tabel users dan id yang sesuai
        $reports = DB::table('medical_records')
            ->join('users as patients', 'medical_records.id_pasien', '=', 'patients.id')
            ->join('users as doctors', 'medical_records.id_dokter', '=', 'doctors.id')
            ->select('medical_records.*', 'patients.name as patient_name', 'doctors.name as doctor_name')
            ->get();

        return view('admin.reports', compact('reports'));
    }
}
