@extends('layouts.app')

@section('title', 'Dashboard Pasien')

@section('content')
<div class="bg-white shadow-md rounded p-6">
    <h1 class="text-3xl font-bold mb-4">Dashboard Pasien</h1>
    <p>Selamat datang, {{ Auth::user()->name }}!</p>

    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white shadow-md rounded p-4">
            <h2 class="text-xl font-semibold flex items-center">
                <i class="fas fa-notes-medical mr-2"></i> Rekam Medis Terbaru
            </h2>
            @if($medicalRecords->isEmpty())
                <p class="text-gray-600">Belum ada rekam medis yang tersedia.</p>
            @else
                <ul class="mt-4 space-y-4">
                    @foreach($medicalRecords as $record)
                        <li class="border-b py-2 flex justify-between items-center">
                            <div>
                                <strong>Diagnosis:</strong> {{ $record->diagnosis }}<br>
                                <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($record->record_date)->format('d M Y') }}<br>
                                <strong>Dokter:</strong> {{ $record->doctor->user->name ?? 'Tidak diketahui' }}
                            </div>
                            <a href="{{ route('pasien.records.index') }}" class="text-blue-500 hover:underline flex items-center">
                                <i class="fas fa-eye mr-2"></i> Lihat Detail
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="bg-white shadow-md rounded p-4">
            <h2 class="text-xl font-semibold flex items-center">
                <i class="fas fa-calendar-alt mr-2"></i> Janji Temu Mendatang
            </h2>
            @if($upcomingAppointments->isEmpty())
                <p class="text-gray-600">Tidak ada janji temu yang dijadwalkan.</p>
            @else
                <ul class="mt-4 space-y-4">
                    @foreach($upcomingAppointments as $appointment)
                        <li class="border-b py-2 flex justify-between items-center">
                            <div>
                                <strong>Tanggal:</strong> {{ $appointment->date->format('d M Y') }}<br>
                                <strong>Waktu:</strong> {{ $appointment->time }}<br>
                                <strong>Dokter:</strong> {{ $appointment->doctor->user->name ?? 'Tidak diketahui' }}
                            </div>
                            <a href="{{ route('pasien.appointments.index') }}" class="text-blue-500 hover:underline flex items-center">
                                <i class="fas fa-eye mr-2"></i> Lihat Detail
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
