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

    <form action="{{ route('dokter.jadwal-konsultasi.update', $schedule->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="date" class="block text-sm font-medium text-gray-700">Tanggal</label>
            <input type="date" name="date" id="date" value="{{ $schedule->date->format('Y-m-d') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
        </div>
        <div class="mb-4">
            <label for="time" class="block text-sm font-medium text-gray-700">Jam</label>
            <select name="time" id="time" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                @for ($hour = 9; $hour <= 17; $hour++)
                    <option value="{{ $hour }}:00" {{ $schedule->time == "$hour:00" ? 'selected' : '' }}>{{ $hour }}:00</option>
                    <option value="{{ $hour }}:30" {{ $schedule->time == "$hour:30" ? 'selected' : '' }}>{{ $hour }}:30</option>
                @endfor
            </select>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>
@endsection
