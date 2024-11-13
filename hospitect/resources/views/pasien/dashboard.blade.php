@extends('layouts.app')

@section('title', 'Dashboard Pasien')

@section('content')
<div class="bg-white shadow-md rounded p-6">
    <h1 class="text-3xl font-bold mb-4">Dashboard Pasien</h1>
    <p>Selamat datang, {{ Auth::user()->name }}! Berikut rekam medis Anda.</p>

    <ul class="mt-4">
        <li class="border-b py-2">Tindakan Medis 1 - 01/01/2023</li>
        <li class="border-b py-2">Tindakan Medis 2 - 15/02/2023</li>
        <li class="border-b py-2">Tindakan Medis 3 - 20/03/2023</li>
    </ul>
</div>
@endsection
