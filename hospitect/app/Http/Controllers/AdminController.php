<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Medicine;
use App\Models\MedicalRecord;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Patient;

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

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string|in:admin,dokter,pasien',
            'password' => 'nullable|string|min:8|confirmed',
            'license_number' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'insurance_number' => 'nullable|string|max:255',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        if ($request->role === 'dokter') {
            if (!$user->doctor) {
                $doctor = Doctor::create([
                    'user_id' => $user->id,
                    'license_number' => $request->license_number,
                    'specialization' => $request->specialization,
                ]);
            } else {
                $user->doctor->update([
                    'license_number' => $request->license_number,
                    'specialization' => $request->specialization,
                    'user_id' => $user->id, // Restore the relationship
                ]);
                $doctor = $user->doctor;
            }
            // Reassign medical records to the doctor
            MedicalRecord::where('doctor_id', $user->id)->update(['doctor_id' => $doctor->id]);
        } elseif ($request->role === 'pasien') {
            if (!$user->patient) {
                $patient = Patient::create([
                    'user_id' => $user->id,
                    'insurance_number' => $request->insurance_number,
                ]);
            } else {
                $user->patient->update([
                    'insurance_number' => $request->insurance_number,
                    'user_id' => $user->id, // Restore the relationship
                ]);
                $patient = $user->patient;
            }
            // Reassign medical records to the patient
            MedicalRecord::where('patient_id', $user->id)->update(['patient_id' => $patient->id]);
        }

        // Ensure the doctor and patient records are properly linked
        if ($request->role !== 'dokter' && $user->doctor) {
            $user->doctor->update(['user_id' => null]);
        }
        if ($request->role !== 'pasien' && $user->patient) {
            $user->patient->update(['user_id' => null]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }
}
