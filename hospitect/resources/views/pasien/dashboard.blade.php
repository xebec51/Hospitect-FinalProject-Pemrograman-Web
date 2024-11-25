@extends('layouts.app')

@section('title', 'Dashboard Pasien')

@section('content')
<div class="bg-white shadow-md rounded p-6">
    <h1 class="text-3xl font-bold mb-4">Dashboard Pasien</h1>
    <p>Selamat datang, {{ Auth::user()->name }}!</p>

    <h2 class="text-xl font-semibold mt-4">Rekam Medis Terbaru</h2>
    @if($medicalRecords->isEmpty())
        <p class="text-gray-600">Belum ada rekam medis yang tersedia.</p>
    @else
        <ul class="mt-4">
            @foreach($medicalRecords as $record)
                <li class="border-b py-2">
                    <strong>Diagnosis:</strong> {{ $record->diagnosis }}<br>
                    <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($record->record_date)->format('d M Y') }}<br>
                    <strong>Dokter:</strong> {{ $record->doctor->user->name ?? 'Tidak diketahui' }}
                </li>
            @endforeach
        </ul>
    @endif

    <h2 class="text-xl font-semibold mt-4">Janji Temu Mendatang</h2>
    @if($upcomingAppointments->isEmpty())
        <p class="text-gray-600">Tidak ada janji temu yang dijadwalkan.</p>
    @else
        <ul class="mt-4">
            @foreach($upcomingAppointments as $appointment)
                <li class="border-b py-2">
                    <strong>Tanggal:</strong> {{ $appointment->date->format('d M Y') }}<br>
                    <strong>Waktu:</strong> {{ $appointment->time }}<br>
                    <strong>Dokter:</strong> {{ $appointment->doctor->user->name ?? 'Tidak diketahui' }}
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
