@extends('layouts.app')

@section('title', 'Tambah Jadwal Konsultasi')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Tambah Jadwal Konsultasi</h1>

    @if ($errors->any())
        <div class="bg-red-500 text-white p-2 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('dokter.jadwal-konsultasi.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="doctor_id" class="block text-gray-700">Dokter:</label>
            <select name="doctor_id" id="doctor_id" class="w-full border-gray-300 rounded p-2" required>
                <option value="">Pilih Dokter</option>
                @foreach($dokters as $dokter)
                    <option value="{{ $dokter->id }}">{{ $dokter->user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="patient_id" class="block text-gray-700">Pasien:</label>
            <select name="patient_id" id="patient_id" class="w-full border-gray-300 rounded p-2" required>
                <option value="">Pilih Pasien</option>
                @foreach($pasiens as $pasien)
                    <option value="{{ $pasien->id }}">{{ $pasien->user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="date" class="block text-gray-700">Tanggal:</label>
            <input type="date" name="date" id="date" value="{{ old('date') }}" class="w-full border-gray-300 rounded p-2" required>
        </div>

        <div class="mb-4">
            <label for="time" class="block text-gray-700">Waktu:</label>
            <input type="time" name="time" id="time" value="{{ old('time') }}" class="w-full border-gray-300 rounded p-2" required>
        </div>

        <div class="mb-4">
            <label for="notes" class="block text-gray-700">Catatan:</label>
            <textarea name="notes" id="notes" rows="4" class="w-full border-gray-300 rounded p-2">{{ old('notes') }}</textarea>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection
