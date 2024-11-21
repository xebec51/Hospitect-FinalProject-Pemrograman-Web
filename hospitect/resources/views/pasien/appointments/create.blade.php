@extends('layouts.app')

@section('title', 'Buat Janji Temu')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Buat Janji Temu</h1>
    <form action="{{ route('pasien.appointment.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="doctor_id" class="block">Pilih Dokter:</label>
            <select name="doctor_id" id="doctor_id" class="w-full border border-gray-300 p-2 rounded" required>
                @foreach ($dokters as $dokter)
                    <option value="{{ $dokter->id }}">{{ $dokter->user->name }} ({{ $dokter->specialization }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="date" class="block">Tanggal:</label>
            <input type="date" name="date" id="date" class="w-full border border-gray-300 p-2 rounded" required>
        </div>
        <div class="mb-4">
            <label for="time" class="block">Waktu:</label>
            <input type="time" name="time" id="time" class="w-full border border-gray-300 p-2 rounded" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Buat Janji</button>
    </form>
</div>
@endsection
