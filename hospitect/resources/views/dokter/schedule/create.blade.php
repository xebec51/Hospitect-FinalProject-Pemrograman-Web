<!-- resources/views/dokter/schedule/create.blade.php -->
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
            <label for="id_dokter" class="block text-gray-700">Dokter:</label>
            <select name="id_dokter" id="id_dokter" class="w-full border-gray-300 rounded p-2" required>
                <option value="">Pilih Dokter</option>
                @foreach($dokters as $dokter)
                    <option value="{{ $dokter->id }}">{{ $dokter->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="id_pasien" class="block text-gray-700">Pasien:</label>
            <select name="id_pasien" id="id_pasien" class="w-full border-gray-300 rounded p-2" required>
                <option value="">Pilih Pasien</option>
                @foreach($pasiens as $pasien)
                    <option value="{{ $pasien->id }}">{{ $pasien->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="tanggal" class="block text-gray-700">Tanggal Konsultasi:</label>
            <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal') }}" class="w-full border-gray-300 rounded p-2" required>
        </div>

        <div class="mb-4">
            <label for="status" class="block text-gray-700">Status:</label>
            <select name="status" id="status" class="w-full border-gray-300 rounded p-2">
                <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Confirmed" {{ old('status') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="catatan" class="block text-gray-700">Catatan:</label>
            <textarea name="catatan" id="catatan" rows="4" class="w-full border-gray-300 rounded p-2">{{ old('catatan') }}</textarea>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection
