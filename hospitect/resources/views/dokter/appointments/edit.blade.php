@extends('layouts.app')

@section('title', 'Edit Jadwal Konsultasi')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Jadwal Konsultasi</h1>

    @if ($errors->any())
        <div class="bg-red-500 text-white p-2 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('dokter.appointments.update', $appointment->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="doctor_id" class="block">Pilih Dokter:</label>
            <select name="doctor_id" id="doctor_id" class="w-full border-gray-300 rounded p-2" required>
                <option value="">Pilih Dokter</option>
                @foreach($dokters as $dokter)
                    <option value="{{ $dokter->id }}" {{ $dokter->id == $appointment->doctor_id ? 'selected' : '' }}>
                        {{ $dokter->user->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="patient_id" class="block">Pasien:</label>
            <select name="patient_id" id="patient_id" class="w-full border-gray-300 rounded p-2" required>
                <option value="">Pilih Pasien</option>
                @foreach($pasiens as $pasien)
                    <option value="{{ $pasien->id }}" {{ $pasien->id == $appointment->patient_id ? 'selected' : '' }}>
                        {{ $pasien->user->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="date" class="block">Tanggal:</label>
            <input type="date" name="date" id="date" class="w-full border-gray-300 rounded p-2" value="{{ $appointment->date }}" required>
        </div>
        <div class="mb-4">
            <label for="time" class="block">Waktu:</label>
            <select name="time" id="time" class="w-full border-gray-300 rounded p-2" required>
                @foreach ($timeSlots as $slot)
                    <option value="{{ $slot }}" {{ $slot == $appointment->time ? 'selected' : '' }}>{{ $slot }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="notes" class="block">Catatan:</label>
            <textarea name="notes" id="notes" rows="4" class="w-full border-gray-300 rounded p-2">{{ $appointment->notes }}</textarea>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan Perubahan</button>
    </form>
</div>
@endsection
