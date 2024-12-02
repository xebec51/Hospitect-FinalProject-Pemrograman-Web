@extends('layouts.app')

@section('title', 'Profil Pasien')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4"><i class="fas fa-user-circle mr-2"></i>Profil Saya</h1>

    @if (session('success'))
        <div class="bg-green-500 text-white p-2 rounded mb-4">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <div id="profile-view" class="bg-white shadow-md rounded p-4">
        <h2 class="text-xl font-semibold mb-4"><i class="fas fa-info-circle mr-2"></i>Informasi Pribadi</h2>
        <p><strong><i class="fas fa-user mr-2"></i>Nama Lengkap:</strong> {{ Auth::user()->name }}</p>
        <p><strong><i class="fas fa-phone mr-2"></i>Nomor Telepon:</strong> {{ $patientDetails->phone ?? 'Tidak tersedia' }}</p>
        <p><strong><i class="fas fa-birthday-cake mr-2"></i>Tanggal Lahir:</strong> {{ $patientDetails->date_of_birth ?? 'Tidak tersedia' }}</p>
        <p><strong><i class="fas fa-map-marker-alt mr-2"></i>Alamat:</strong> {{ $patientDetails->address ?? 'Tidak tersedia' }}</p>

        <h2 class="text-xl font-semibold mt-6 mb-4"><i class="fas fa-notes-medical mr-2"></i>Informasi Medis</h2>
        <p><strong><i class="fas fa-history mr-2"></i>Riwayat Medis:</strong> {{ $patient->medical_history ?? 'Tidak tersedia' }}</p>
        <p><strong><i class="fas fa-id-card mr-2"></i>Nomor Asuransi:</strong> {{ $patient->insurance_number ?? 'Tidak tersedia' }}</p>
        <p><strong><i class="fas fa-procedures mr-2"></i>Penyakit Kronis:</strong> {{ $patientDetails->chronic_diseases ?? 'Tidak tersedia' }}</p>
        <p><strong><i class="fas fa-allergies mr-2"></i>Alergi:</strong> {{ $patientDetails->allergies ?? 'Tidak tersedia' }}</p>
        <p><strong><i class="fas fa-tint mr-2"></i>Golongan Darah:</strong> {{ $patientDetails->blood_type ?? 'Tidak tersedia' }}</p>

        <button id="edit-profile-btn" class="bg-blue-500 text-white px-4 py-2 rounded mt-4 flex items-center">
            <i class="fas fa-edit mr-2"></i> Edit Profil
        </button>
    </div>

    <div id="profile-edit" class="bg-white shadow-md rounded p-4" style="display: none;">
        <form action="{{ route('pasien.profile.update') }}" method="POST">
            @csrf
            <h2 class="text-xl font-semibold mb-4"><i class="fas fa-info-circle mr-2"></i>Informasi Pribadi</h2>
            <div class="mb-4">
                <label for="phone" class="block font-bold mb-2"><i class="fas fa-phone mr-2"></i>Nomor Telepon</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $patientDetails->phone ?? '') }}" class="w-full border border-gray-300 p-2 rounded" pattern="^\+?[0-9]{10,15}$" title="Nomor telepon harus terdiri dari angka, dan dapat dimulai dengan tanda '+' (misalnya +628123456789)">
                @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="date_of_birth" class="block font-bold mb-2"><i class="fas fa-birthday-cake mr-2"></i>Tanggal Lahir</label>
                <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $patientDetails->date_of_birth ?? '') }}" class="w-full border border-gray-300 p-2 rounded" max="{{ now()->subYears(12)->toDateString() }}">
                @error('date_of_birth')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="address" class="block font-bold mb-2"><i class="fas fa-map-marker-alt mr-2"></i>Alamat</label>
                <textarea id="address" name="address" class="w-full border border-gray-300 p-2 rounded">{{ old('address', $patientDetails->address ?? '') }}</textarea>
                @error('address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <h2 class="text-xl font-semibold mt-6 mb-4"><i class="fas fa-notes-medical mr-2"></i>Informasi Medis</h2>
            <div class="mb-4">
                <label for="medical_history" class="block font-bold mb-2"><i class="fas fa-history mr-2"></i>Riwayat Medis</label>
                <textarea id="medical_history" name="medical_history" class="w-full border border-gray-300 p-2 rounded">{{ old('medical_history', $patient->medical_history ?? '') }}</textarea>
                @error('medical_history')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="insurance_number" class="block font-bold mb-2"><i class="fas fa-id-card mr-2"></i>Nomor Asuransi</label>
                <input type="text" id="insurance_number" name="insurance_number" value="{{ old('insurance_number', $patient->insurance_number ?? '') }}" class="w-full border border-gray-300 p-2 rounded">
                @error('insurance_number')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded flex items-center">
                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                </button>
                <button type="button" id="cancel-edit-btn" class="bg-gray-500 text-white px-4 py-2 rounded ml-2 flex items-center">
                    <i class="fas fa-times mr-2"></i> Batal
                </button>
            </div>
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
