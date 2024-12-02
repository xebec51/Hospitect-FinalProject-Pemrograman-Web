@extends('layouts.app')

@section('title', 'Dashboard Dokter')

@section('content')
<div class="bg-white shadow-md rounded p-6">
    <h1 class="text-3xl font-bold mb-4"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard Dokter</h1>
    <p>Selamat datang, {{ Auth::user()->name }}! Berikut pasien terbaru yang telah diperiksa.</p>

    @if($recentMedicalRecords->isEmpty())
        <p class="mt-4 text-gray-600">Belum ada pasien yang diperiksa.</p>
    @else
        <div class="mt-4 space-y-4">
            @foreach($recentMedicalRecords as $record)
                <div class="border border-gray-200 rounded-lg p-4 shadow-md bg-white">
                    <p><strong><i class="fas fa-user mr-2"></i>Nama Pasien:</strong> {{ $record->patient->user->name ?? 'Tidak diketahui' }}</p>
                    <p><strong><i class="fas fa-procedures mr-2"></i>Tindakan:</strong> {{ $record->treatment ?? 'Tidak ada tindakan' }}</p>
                    <p><strong><i class="fas fa-calendar-alt mr-2"></i>Tanggal:</strong> {{ $record->record_date->format('d M Y') }}</p>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
