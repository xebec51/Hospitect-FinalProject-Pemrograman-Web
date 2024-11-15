<!-- resources/views/pasien/profile.blade.php -->

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

    <!-- Navigasi Tab -->
    <div class="mb-6">
        <ul class="flex border-b">
            <li class="mr-1">
                <a href="#informasi-pribadi" class="bg-blue-600 text-white hover:bg-blue-700 inline-block py-2 px-4 rounded-t">Informasi Pribadi</a>
            </li>
            <li class="mr-1">
                <a href="#informasi-medis" class="bg-blue-600 text-white hover:bg-blue-700 inline-block py-2 px-4 rounded-t">Informasi Medis</a>
            </li>
        </ul>
    </div>

    <!-- Form untuk Informasi Pribadi -->
    <div id="informasi-pribadi">
        <form action="{{ route('pasien.profile.update') }}" method="POST">
            @csrf
            <h2 class="text-xl font-semibold mb-4">Informasi Pribadi</h2>

            <div class="mb-4">
                <label for="name" class="block font-bold mb-2">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" class="w-full border border-gray-300 p-2 rounded" readonly>
            </div>

            <div class="mb-4">
                <label for="phone" class="block font-bold mb-2">Nomor Telepon</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $patientDetails->phone ?? '') }}" class="w-full border border-gray-300 p-2 rounded">
                @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="date_of_birth" class="block font-bold mb-2">Tanggal Lahir</label>
                <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $patientDetails->date_of_birth ?? '') }}" class="w-full border border-gray-300 p-2 rounded">
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

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Perbarui Informasi Pribadi</button>
        </form>
    </div>

    <!-- Form untuk Informasi Medis -->
    <div id="informasi-medis" class="mt-8">
        <form action="{{ route('pasien.profile.updateMedical') }}" method="POST">
            @csrf
            <h2 class="text-xl font-semibold mb-4">Informasi Medis</h2>

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

            <div class="mb-4">
                <label for="chronic_diseases" class="block font-bold mb-2">Penyakit Kronis</label>
                <input type="text" id="chronic_diseases" name="chronic_diseases" value="{{ old('chronic_diseases', $patientDetails->chronic_diseases ?? '') }}" class="w-full border border-gray-300 p-2 rounded">
                @error('chronic_diseases')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="allergies" class="block font-bold mb-2">Alergi</label>
                <input type="text" id="allergies" name="allergies" value="{{ old('allergies', $patientDetails->allergies ?? '') }}" class="w-full border border-gray-300 p-2 rounded">
                @error('allergies')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="blood_type" class="block font-bold mb-2">Golongan Darah</label>
                <input type="text" id="blood_type" name="blood_type" value="{{ old('blood_type', $patientDetails->blood_type ?? '') }}" class="w-full border border-gray-300 p-2 rounded">
                @error('blood_type')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Perbarui Informasi Medis</button>
        </form>
    </div>
</div>
@endsection
