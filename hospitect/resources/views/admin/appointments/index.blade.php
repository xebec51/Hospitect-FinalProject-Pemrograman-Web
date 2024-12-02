@extends('layouts.app')

@section('title', 'Manajemen Jadwal Konsultasi')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Manajemen Jadwal Konsultasi</h1>
        <a href="{{ route('admin.appointments.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
            Tambah Jadwal Konsultasi
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-500 text-white p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Pencarian -->
    <form action="{{ route('admin.appointments.index') }}" method="GET" class="mb-4 flex">
        <input type="text" name="search" placeholder="Cari Tanggal, Waktu, atau Dokter" class="p-2 border border-gray-300 rounded-l-md" value="{{ request('search') }}">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r-md flex items-center">
            <i class="fas fa-search mr-2"></i> Cari
        </button>
    </form>

    @if ($appointments->isEmpty())
        <p class="text-center">Tidak ada jadwal konsultasi yang tersedia.</p>
    @else
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-200 p-2 text-left">
                        <a href="{{ route('admin.appointments.index', ['sort' => 'date', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}" class="flex items-center">
                            Tanggal
                            <i class="ml-2 fas fa-sort{{ request('sort') == 'date' ? (request('direction') == 'asc' ? '-up' : '-down') : '' }}"></i>
                        </a>
                    </th>
                    <th class="border border-gray-200 p-2 text-left">Waktu</th>
                    <th class="border border-gray-200 p-2 text-left">
                        <a href="{{ route('admin.appointments.index', ['sort' => 'doctor_name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}" class="flex items-center">
                            Dokter
                            <i class="ml-2 fas fa-sort{{ request('sort') == 'doctor_name' ? (request('direction') == 'asc' ? '-up' : '-down') : '' }}"></i>
                        </a>
                    </th>
                    <th class="border border-gray-200 p-2 text-left">Pasien</th>
                    <th class="border border-gray-200 p-2 text-left">
                        <a href="{{ route('admin.appointments.index', ['sort' => 'status', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}" class="flex items-center">
                            Status
                            <i class="ml-2 fas fa-sort{{ request('sort') == 'status' ? (request('direction') == 'asc' ? '-up' : '-down') : '' }}"></i>
                        </a>
                    </th>
                    <th class="border border-gray-200 p-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appointments as $appointment)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-200 p-2">{{ Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</td>
                        <td class="border border-gray-200 p-2">{{ Carbon\Carbon::parse($appointment->time)->format('H:i') }}</td>
                        <td class="border border-gray-200 p-2">{{ $appointment->doctor->user->name }}</td>
                        <td class="border border-gray-200 p-2">{{ $appointment->patient->user->name }}</td>
                        <td class="border border-gray-200 p-2">{{ ucfirst($appointment->status) }}</td>
                        <td class="border border-gray-200 p-2 flex items-center space-x-2">
                            <a href="{{ route('admin.appointments.edit', $appointment->id) }}" class="text-blue-600 hover:underline mr-2">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <form action="{{ route('admin.appointments.destroy', $appointment->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
