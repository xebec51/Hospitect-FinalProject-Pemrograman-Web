@extends('layouts.app')

@section('title', 'Buat Janji Temu')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Buat Janji Temu</h1>

    @if ($errors->any())
        <div class="bg-red-500 text-white p-2 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-500 text-white p-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('pasien.appointments.store') }}" method="POST" class="bg-white shadow-md rounded p-4">
        @csrf
        <div class="mb-4">
            <label for="doctor_id" class="block">Pilih Dokter:</label>
            <select name="doctor_id" id="doctor_id" class="w-full border border-gray-300 p-2 rounded" required>
                <option value="">Pilih Dokter</option>
                @foreach ($dokters as $dokter)
                    <option value="{{ $dokter->id }}">{{ $dokter->user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="date" class="block">Tanggal:</label>
            <input type="date" name="date" id="date" class="w-full border border-gray-300 p-2 rounded" required min="{{ now()->toDateString() }}">
        </div>

        <div class="mb-4">
            <label for="time" class="block">Waktu:</label>
            <select name="time" id="time" class="w-full border border-gray-300 p-2 rounded" required>
                <option value="">Pilih Waktu</option>
                @foreach ($timeSlots as $slot)
                    <option value="{{ $slot }}">{{ $slot }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded flex items-center">
            <i class="fas fa-calendar-plus mr-2"></i> Buat Janji
        </button>
    </form>
</div>
@endsection
