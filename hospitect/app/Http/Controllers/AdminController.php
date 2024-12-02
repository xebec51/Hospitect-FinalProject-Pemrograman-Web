<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Medicine;
use App\Models\MedicalRecord;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        $adminCount = User::where('role', 'admin')->count();
        $dokterCount = User::where('role', 'dokter')->count();
        $pasienCount = User::where('role', 'pasien')->count();
        $activeMedicines = Medicine::where('stock', '>', 0)->count(); // Ganti 'stok' dengan 'stock'

        // Menambahkan total laporan operasional, misalnya dari tabel medical_records
        $totalReports = MedicalRecord::count();
        $totalAppointments = Appointment::count();

        // Count medicines by type
        $tabletCount = Medicine::where('type', 'Tablet')->count();
        $kapsulCount = Medicine::where('type', 'Kapsul')->count();
        $sirupCount = Medicine::where('type', 'Sirup')->count();
        $injeksiCount = Medicine::where('type', 'Injeksi')->count();

        // Data for medical records and appointments in the last year
        $months = collect(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']);

        $medicalRecordsData = MedicalRecord::select(DB::raw('MONTH(record_date) as month'), DB::raw('count(*) as count'))
            ->whereYear('record_date', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $appointmentsData = Appointment::select(DB::raw('MONTH(date) as month'), DB::raw('count(*) as count'))
            ->whereYear('date', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Convert numeric months to words
        $medicalRecordsData = $months->mapWithKeys(function ($month, $index) use ($medicalRecordsData) {
            return [$month => $medicalRecordsData[$index + 1] ?? 0];
        });

        $appointmentsData = $months->mapWithKeys(function ($month, $index) use ($appointmentsData) {
            return [$month => $appointmentsData[$index + 1] ?? 0];
        });

        // Mengirimkan variabel ke view
        return view('admin.dashboard', compact(
            'totalUsers', 'adminCount', 'dokterCount', 'pasienCount', 'activeMedicines', 'totalReports', 'totalAppointments',
            'tabletCount', 'kapsulCount', 'sirupCount', 'injeksiCount', 'months', 'medicalRecordsData', 'appointmentsData'
        ));
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
