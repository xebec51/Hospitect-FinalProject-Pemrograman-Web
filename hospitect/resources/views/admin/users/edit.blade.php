{{-- D:\GitHub\Hospitect-FinalProject-Pemrograman-Web\hospitect\resources\views\admin\users\edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Pengguna - Hospitect')

@section('content')
<div class="container mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-bold mb-4"><i class="fas fa-user-edit"></i> Edit Pengguna</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Nama -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700"><i class="fas fa-user"></i> Nama</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" class="mt-1 block w-full border-gray-300 rounded shadow-sm" required>
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full border-gray-300 rounded shadow-sm" required>
        </div>

        <!-- Role -->
        <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-gray-700">Peran</label>
            <select id="role" name="role" class="mt-1 block w-full border-gray-300 rounded shadow-sm" required>
                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="dokter" {{ old('role', $user->role) === 'dokter' ? 'selected' : '' }}>Dokter</option>
                <option value="pasien" {{ old('role', $user->role) === 'pasien' ? 'selected' : '' }}>Pasien</option>
            </select>
        </div>

        <div id="dokterFields" class="mb-4 hidden">
            <label for="license_number" class="block text-sm font-medium text-gray-700"><i class="fas fa-id-card"></i> Nomor Lisensi</label>
            <input id="license_number" name="license_number" type="text" value="{{ old('license_number', $user->doctor->license_number ?? '') }}" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
            <label for="specialization" class="block text-sm font-medium text-gray-700"><i class="fas fa-stethoscope"></i> Spesialisasi</label>
            <input id="specialization" name="specialization" type="text" value="{{ old('specialization', $user->doctor->specialization ?? '') }}" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
        </div>
        <div id="pasienFields" class="mb-4 hidden">
            <label for="insurance_number" class="block text-sm font-medium text-gray-700"><i class="fas fa-file-medical"></i> Nomor Asuransi</label>
            <input id="insurance_number" name="insurance_number" type="text" value="{{ old('insurance_number', $user->patient->insurance_number ?? '') }}" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password (Opsional)</label>
            <input id="password" name="password" type="password" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
            <small class="text-gray-500">Kosongkan jika tidak ingin mengubah password.</small>
        </div>

        <!-- Konfirmasi Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.users.index') }}" class="mr-4 text-gray-600 hover:text-gray-900"><i class="fas fa-times"></i> Batal</a>
            <button type="submit" class="bg-teal-600 text-white px-4 py-2 rounded shadow hover:bg-teal-700"><i class="fas fa-save"></i> Simpan</button>
        </div>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        toggleRoleFields(document.getElementById('role').value);
    });

    document.getElementById('role').addEventListener('change', function () {
        toggleRoleFields(this.value);
    });

    function toggleRoleFields(role) {
        document.getElementById('dokterFields').classList.add('hidden');
        document.getElementById('pasienFields').classList.add('hidden');
        if (role === 'dokter') {
            document.getElementById('dokterFields').classList.remove('hidden');
        } else if (role === 'pasien') {
            document.getElementById('pasienFields').classList.remove('hidden');
        }
    }
</script>
@endsection
