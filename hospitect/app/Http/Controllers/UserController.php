<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        // Ambil query pencarian nama dan parameter sorting
        $search = $request->get('search', ''); // Default pencarian kosong
        $sortBy = $request->get('sortBy', 'name'); // Default sorting berdasarkan nama
        $sortDirection = $request->get('sortDirection', 'asc'); // Default urutkan secara ascending

        // Filter dan sorting berdasarkan input
        $users = User::query()
            ->where('name', 'like', '%' . $search . '%') // Filter berdasarkan nama
            ->orderBy($sortBy, $sortDirection)
            ->get();

        return view('admin.users.index', compact('users', 'search', 'sortBy', 'sortDirection'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,dokter,pasien',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.users.create')
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Tambahkan entri di tabel doctor atau patient jika role sesuai
        if ($request->role === 'dokter') {
            Doctor::create([
                'user_id' => $user->id,
                'license_number' => $request->input('license_number', 'DEFAULT_LICENSE'),
                'specialization' => $request->input('specialization', 'DEFAULT_SPECIALIZATION'),
            ]);
        } elseif ($request->role === 'pasien') {
            Patient::create([
                'user_id' => $user->id,
                'insurance_number' => $request->input('insurance_number', 'DEFAULT_INSURANCE'),
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,dokter,pasien',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.users.edit', $user->id)
                ->withErrors($validator)
                ->withInput();
        }

        // Periksa apakah pengguna sedang mengubah perannya sendiri
        $isSelfRoleChange = (Auth::id() === $user->id && $request->role !== $user->role);

        // Perbarui data pengguna
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        // Perbarui kata sandi jika diisi
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        // Tangani perubahan role dokter/pasien
        if ($request->role === 'dokter' && !$user->doctor) {
            Doctor::create([
                'user_id' => $user->id,
                'license_number' => $request->input('license_number', 'UPDATED_LICENSE'),
                'specialization' => $request->input('specialization', 'UPDATED_SPECIALIZATION'),
            ]);
        } elseif ($request->role === 'pasien' && !$user->patient) {
            Patient::create([
                'user_id' => $user->id,
                'insurance_number' => $request->input('insurance_number', 'UPDATED_INSURANCE'),
            ]);
        }

        // Jika peran pengguna diubah sendiri, logout dan minta login kembali
        if ($isSelfRoleChange) {
            Auth::logout();
            return redirect()->route('login')->with('info', 'Your role has been updated. Please log in again.');
        }

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
