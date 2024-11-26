@extends('layouts.app')

@section('title', 'Jadwal Konsultasi Saya')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Jadwal Konsultasi</h1>
        <a href="{{ route('pasien.appointments.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
            Buat Janji Baru
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-500 text-white p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($appointments->isEmpty())
        <p class="text-center">Belum ada jadwal konsultasi.</p>
    @else
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-200 p-2 text-left">Tanggal</th>
                    <th class="border border-gray-200 p-2 text-left">Waktu</th>
                    <th class="border border-gray-200 p-2 text-left">Dokter</th>
                    <th class="border border-gray-200 p-2 text-left">Status</th>
                    <th class="border border-gray-200 p-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appointments as $appointment)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-200 p-2">{{ $appointment->date }}</td>
                        <td class="border border-gray-200 p-2">{{ $appointment->time }}</td>
                        <td class="border border-gray-200 p-2">{{ $appointment->doctor->user->name }}</td>
                        <td class="border border-gray-200 p-2">{{ ucfirst($appointment->status) }}</td>
                        <td class="border border-gray-200 p-2">
                            <a href="{{ route('pasien.appointments.edit', $appointment->id) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('pasien.appointments.destroy', $appointment->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
