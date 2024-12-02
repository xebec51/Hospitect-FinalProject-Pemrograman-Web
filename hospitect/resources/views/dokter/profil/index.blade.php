@extends('layouts.app')

@section('title', 'Profil Dokter')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4"><i class="fas fa-user-md mr-2"></i>Profil Saya</h1>

    @if (session('success'))
        <div class="bg-green-500 text-white p-2 rounded mb-4">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <div id="profile-view" class="bg-white shadow-md rounded p-4">
        <h2 class="text-xl font-semibold mb-4"><i class="fas fa-info-circle mr-2"></i>Informasi Pribadi</h2>
        <p><strong><i class="fas fa-user mr-2"></i>Nama Lengkap:</strong> {{ Auth::user()->name }}</p>
        <p><strong><i class="fas fa-phone mr-2"></i>Nomor Telepon:</strong> {{ $doctorDetails->phone ?? 'Tidak tersedia' }}</p>
        <p><strong><i class="fas fa-map-marker-alt mr-2"></i>Alamat Klinik:</strong> {{ $doctorDetails->clinic_address ?? 'Tidak tersedia' }}</p>
        <p><strong><i class="fas fa-briefcase-medical mr-2"></i>Pengalaman:</strong> {{ $doctorDetails->experience_years ?? 'Tidak tersedia' }} tahun</p>
        <p><strong><i class="fas fa-stethoscope mr-2"></i>Spesialisasi:</strong> {{ $doctor->specialization ?? 'Tidak tersedia' }}</p>

        <button id="edit-profile-btn" class="bg-blue-500 text-white px-4 py-2 rounded mt-4 flex items-center">
            <i class="fas fa-edit mr-2"></i> Edit Profil
        </button>
    </div>

    <div id="profile-edit" class="bg-white shadow-md rounded p-4" style="display: none;">
        <form action="{{ route('dokter.profile.update') }}" method="POST">
            @csrf
            <h2 class="text-xl font-semibold mb-4"><i class="fas fa-info-circle mr-2"></i>Informasi Pribadi</h2>

            <div class="mb-4">
                <label for="phone" class="block font-bold mb-2"><i class="fas fa-phone mr-2"></i>Nomor Telepon</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $doctorDetails->phone ?? '') }}" class="w-full border border-gray-300 p-2 rounded">
                @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="clinic_address" class="block font-bold mb-2"><i class="fas fa-map-marker-alt mr-2"></i>Alamat Klinik</label>
                <textarea id="clinic_address" name="clinic_address" class="w-full border border-gray-300 p-2 rounded">{{ old('clinic_address', $doctorDetails->clinic_address ?? '') }}</textarea>
                @error('clinic_address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="experience_years" class="block font-bold mb-2"><i class="fas fa-briefcase-medical mr-2"></i>Pengalaman (tahun)</label>
                <input type="number" id="experience_years" name="experience_years" value="{{ old('experience_years', $doctorDetails->experience_years ?? '') }}" class="w-full border border-gray-300 p-2 rounded">
                @error('experience_years')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="specialization" class="block font-bold mb-2"><i class="fas fa-stethoscope mr-2"></i>Spesialisasi</label>
                <input type="text" id="specialization" name="specialization" value="{{ old('specialization', $doctor->specialization ?? '') }}" class="w-full border border-gray-300 p-2 rounded">
                @error('specialization')
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
