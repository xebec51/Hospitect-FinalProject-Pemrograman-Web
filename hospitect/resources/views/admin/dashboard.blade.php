@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="bg-white shadow-md rounded p-6">
    <h1 class="text-3xl font-bold mb-4">Dashboard Admin</h1>
    <p>Selamat datang, {{ Auth::user()->name }}! Ini adalah halaman dashboard admin.</p>

    <div class="grid grid-cols-3 gap-6 mt-6">
        <div class="p-4 bg-blue-200 rounded shadow">
            <h2 class="text-lg font-semibold">Total Pengguna</h2>
            <p class="text-2xl">{{ $totalUsers }}</p>
        </div>
        <div class="p-4 bg-green-200 rounded shadow">
            <h2 class="text-lg font-semibold">Total Obat</h2>
            <p class="text-2xl">{{ $activeMedicines }}</p>
        </div>
        <div class="p-4 bg-yellow-200 rounded shadow">
            <h2 class="text-lg font-semibold">Laporan Operasional</h2>
            <p class="text-2xl">{{ $totalReports }} laporan</p>
        </div>
    </div>
</div>
@endsection
