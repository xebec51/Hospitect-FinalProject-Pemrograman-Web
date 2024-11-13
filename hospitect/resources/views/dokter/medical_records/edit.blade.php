@extends('layouts.app')

@section('title', 'Edit Catatan Medis')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Catatan Medis</h1>

    @if ($errors->any())
        <div class="bg-red-500 text-white p-2 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('dokter.medical-records.update', $medicalRecord->id_rekam_medis) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="id_pasien" class="block text-gray-700">Nama Pasien:</label>
            <select name="id_pasien" id="id_pasien" class="w-full border-gray-300 rounded p-2" disabled>
                <option value="">Pilih Pasien</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}" {{ $patient->id == $medicalRecord->id_pasien ? 'selected' : '' }}>
                        {{ $patient->user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="tindakan" class="block text-gray-700">Tindakan:</label>
            <textarea name="tindakan" id="tindakan" rows="4" class="w-full border-gray-300 rounded p-2" required>{{ old('tindakan', $medicalRecord->tindakan) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="tanggal_periksa" class="block text-gray-700">Tanggal Periksa:</label>
            <input type="date" name="tanggal_periksa" id="tanggal_periksa" value="{{ old('tanggal_periksa', $medicalRecord->tanggal_periksa->format('Y-m-d')) }}" class="w-full border-gray-300 rounded p-2" required>
        </div>

        <div class="mb-4">
            <label for="obat" class="block text-gray-700">Obat:</label>
            <input type="text" name="obat" id="obat" value="{{ old('obat', $medicalRecord->obat) }}" class="w-full border-gray-300 rounded p-2">
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
        </div>
    </form>
</div>
@endsection
