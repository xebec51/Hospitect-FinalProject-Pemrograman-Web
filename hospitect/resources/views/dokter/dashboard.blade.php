@extends('layouts.app')

@section('title', 'Dashboard Dokter')

@section('content')
<div class="bg-white shadow-md rounded p-6">
    <h1 class="text-3xl font-bold mb-4">Dashboard Dokter</h1>
    <p>Selamat datang, {{ Auth::user()->name }}! Berikut pasien terbaru yang telah diperiksa.</p>

    @if($recentMedicalRecords->isEmpty())
        <p class="mt-4 text-gray-600">Belum ada pasien yang diperiksa.</p>
    @else
        <ul class="mt-4">
            @foreach($recentMedicalRecords as $record)
                <li class="border-b py-2">
                    <strong>Nama Pasien:</strong> {{ $record->patient->user->name ?? 'Tidak diketahui' }}<br>
                    <strong>Tindakan:</strong> {{ $record->treatment ?? 'Tidak ada tindakan' }}<br>
                    <strong>Tanggal:</strong> {{ $record->record_date->format('d M Y') }}
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
