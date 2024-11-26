@extends('layouts.app')

@section('title', 'Jadwal Konsultasi Dokter')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Jadwal Konsultasi</h1>
        <a href="{{ route('dokter.appointments.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Tambah Jadwal Konsultasi
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-500 text-white p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($appointments->isEmpty())
        <p class="text-center">Tidak ada jadwal konsultasi yang tersedia.</p>
    @else
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-200 p-2 text-left">Tanggal</th>
                    <th class="border border-gray-200 p-2 text-left">Waktu</th>
                    <th class="border border-gray-200 p-2 text-left">Pasien</th>
                    <th class="border border-gray-200 p-2 text-left">Status</th>
                    <th class="border border-gray-200 p-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appointments as $appointment)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-200 p-2">{{ $appointment->date }}</td>
                        <td class="border border-gray-200 p-2">{{ $appointment->time }}</td>
                        <td class="border border-gray-200 p-2">{{ $appointment->patient->user->name }}</td>
                        <td class="border border-gray-200 p-2">
                            <form action="{{ route('dokter.appointments.update-status', $appointment->id) }}" method="POST" class="inline-block">
                                @csrf
                                <select name="status" onchange="this.form.submit()" class="border border-gray-300 rounded">
                                    <option value="scheduled" {{ $appointment->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                    <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>
                        </td>
                        <td class="border border-gray-200 p-2">
                            <a href="{{ route('dokter.appointments.edit', $appointment->id) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('dokter.appointments.destroy', $appointment->id) }}" method="POST" class="inline-block">
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
