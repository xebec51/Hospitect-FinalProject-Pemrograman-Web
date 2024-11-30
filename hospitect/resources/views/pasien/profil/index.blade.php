@extends('layouts.app')

@section('title', 'Profil Pasien')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Profil Saya</h1>

    @if (session('success'))
        <div class="bg-green-500 text-white p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div id="profile-view" class="bg-white shadow-md rounded p-4">
        <h2 class="text-xl font-semibold mb-4">Informasi Pribadi</h2>
        <p><strong>Nama Lengkap:</strong> {{ Auth::user()->name }}</p>
        <p><strong>Nomor Telepon:</strong> {{ $patientDetails->phone ?? 'Tidak tersedia' }}</p>
        <p><strong>Tanggal Lahir:</strong> {{ $patientDetails->date_of_birth ?? 'Tidak tersedia' }}</p>
        <p><strong>Alamat:</strong> {{ $patientDetails->address ?? 'Tidak tersedia' }}</p>

        <h2 class="text-xl font-semibold mt-6 mb-4">Informasi Medis</h2>
        <p><strong>Riwayat Medis:</strong> {{ $patient->medical_history ?? 'Tidak tersedia' }}</p>
        <p><strong>Nomor Asuransi:</strong> {{ $patient->insurance_number ?? 'Tidak tersedia' }}</p>
        <p><strong>Penyakit Kronis:</strong> {{ $patientDetails->chronic_diseases ?? 'Tidak tersedia' }}</p>
        <p><strong>Alergi:</strong> {{ $patientDetails->allergies ?? 'Tidak tersedia' }}</p>
        <p><strong>Golongan Darah:</strong> {{ $patientDetails->blood_type ?? 'Tidak tersedia' }}</p>

        <button id="edit-profile-btn" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Edit Profil</button>
    </div>

    <div id="profile-edit" class="bg-white shadow-md rounded p-4" style="display: none;">
        <form action="{{ route('pasien.profile.update') }}" method="POST">
            @csrf
            <h2 class="text-xl font-semibold mb-4">Informasi Pribadi</h2>
            <div class="mb-4">
                <label for="phone" class="block font-bold mb-2">Nomor Telepon</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $patientDetails->phone ?? '') }}" class="w-full border border-gray-300 p-2 rounded" pattern="^\+?[0-9]{10,15}$" title="Nomor telepon harus terdiri dari angka, dan dapat dimulai dengan tanda '+' (misalnya +628123456789)">
                @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="date_of_birth" class="block font-bold mb-2">Tanggal Lahir</label>
                <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $patientDetails->date_of_birth ?? '') }}" class="w-full border border-gray-300 p-2 rounded" max="{{ now()->subYears(12)->toDateString() }}">
                @error('date_of_birth')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="address" class="block font-bold mb-2">Alamat</label>
                <textarea id="address" name="address" class="w-full border border-gray-300 p-2 rounded">{{ old('address', $patientDetails->address ?? '') }}</textarea>
                @error('address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <h2 class="text-xl font-semibold mt-6 mb-4">Informasi Medis</h2>
            <div class="mb-4">
                <label for="medical_history" class="block font-bold mb-2">Riwayat Medis</label>
                <textarea id="medical_history" name="medical_history" class="w-full border border-gray-300 p-2 rounded">{{ old('medical_history', $patient->medical_history ?? '') }}</textarea>
                @error('medical_history')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="insurance_number" class="block font-bold mb-2">Nomor Asuransi</label>
                <input type="text" id="insurance_number" name="insurance_number" value="{{ old('insurance_number', $patient->insurance_number ?? '') }}" class="w-full border border-gray-300 p-2 rounded">
                @error('insurance_number')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan Perubahan</button>
            <button type="button" id="cancel-edit-btn" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">Batal</button>
        </form>
    </div>
</div>

<script>
    // Script untuk memanipulasi tampilan profil
    document.getElementById('edit-profile-btn').addEventListener('click', function () {
        document.getElementById('profile-view').style.display = 'none';
        document.getElementById('profile-edit').style.display = 'block';
    });

    document.getElementById('cancel-edit-btn').addEventListener('click', function () {
        document.getElementById('profile-edit').style.display = 'none';
        document.getElementById('profile-view').style.display = 'block';
    });
</script>
@endsection
