<!-- resources/views/dokter/schedule/index.blade.php -->
@extends('layouts.app')

@section('title', 'Jadwal Konsultasi Dokter')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Jadwal Konsultasi</h1>
        <!-- Tombol Tambah Jadwal -->
        <a href="{{ route('dokter.jadwal-konsultasi.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tambah Jadwal Konsultasi</a>
    </div>

    @if (session('success'))
        <div class="bg-green-500 text-white p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-white border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="border border-gray-200 p-2 text-left">Tanggal</th>
                <th class="border border-gray-200 p-2 text-left">Dokter</th>
                <th class="border border-gray-200 p-2 text-left">Pasien</th>
                <th class="border border-gray-200 p-2 text-left">Status</th>
                <th class="border border-gray-200 p-2 text-left">Catatan</th>
                <th class="border border-gray-200 p-2 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($schedules as $schedule)
                <tr class="hover:bg-gray-50">
                    <td class="border border-gray-200 p-2">{{ \Carbon\Carbon::parse($schedule->tanggal)->format('d M Y') }}</td>
                    <td class="border border-gray-200 p-2">{{ $schedule->dokter->name ?? 'N/A' }}</td>
                    <td class="border border-gray-200 p-2">{{ $schedule->pasien->name ?? 'N/A' }}</td>
                    <td class="border border-gray-200 p-2">{{ $schedule->status }}</td>
                    <td class="border border-gray-200 p-2">{{ $schedule->catatan }}</td>
                    <td class="border border-gray-200 p-2">
                        <a href="{{ route('dokter.jadwal-konsultasi.edit', $schedule->id) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('dokter.jadwal-konsultasi.destroy', $schedule->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center p-4">Tidak ada jadwal konsultasi yang tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
