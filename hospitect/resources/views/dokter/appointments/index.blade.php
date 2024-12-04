@extends('layouts.app')

@section('title', 'Jadwal Konsultasi Dokter')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold"><i class="fas fa-calendar-alt mr-2"></i>Jadwal Konsultasi</h1>
        <a href="{{ route('dokter.appointments.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 flex items-center">
            <i class="fas fa-plus mr-2"></i> Tambah Jadwal Konsultasi
        </a>
    </div>

    <!-- Pencarian -->
    <form action="{{ route('dokter.appointments.index') }}" method="GET" class="mb-4 flex">
        <input type="text" name="search" placeholder="Cari Tanggal, Waktu, atau Pasien" class="p-2 border border-gray-300 rounded-l-md" value="{{ request('search') }}">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r-md flex items-center">
            <i class="fas fa-search mr-2"></i> Cari
        </button>
    </form>

    @if (session('success'))
        <div class="bg-green-500 text-white p-2 rounded mb-4">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    @if ($appointments->isEmpty())
        <p class="text-center">Tidak ada jadwal konsultasi yang tersedia.</p>
    @else
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <!-- Sorting Tanggal -->
                    <th class="border border-gray-200 p-2 text-left">
                        <a href="{{ route('dokter.appointments.index', ['sort_by' => 'date', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}" class="flex items-center">
                            Tanggal
                            @if (request('sort_by') === 'date')
                                <i class="fas fa-sort{{ request('sort_order') === 'asc' ? '-up' : '-down' }} ml-2"></i>
                            @endif
                        </a>
                    </th>
                    <!-- Sorting Waktu -->
                    <th class="border border-gray-200 p-2 text-left">Waktu</th>
                    <th class="border border-gray-200 p-2 text-left">Pasien</th>
                    <!-- Sorting Status -->
                    <th class="border border-gray-200 p-2 text-left">
                        <a href="{{ route('dokter.appointments.index', ['sort_by' => 'status', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}" class="flex items-center">
                            Status
                            @if (request('sort_by') === 'status')
                                <i class="fas fa-sort{{ request('sort_order') === 'asc' ? '-up' : '-down' }} ml-2"></i>
                            @endif
                        </a>
                    </th>
                    <th class="border border-gray-200 p-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appointments as $appointment)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-200 p-2">{{ \Carbon\Carbon::parse($appointment->date)->format('d-m-Y') }}</td>
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
                            <a href="{{ route('dokter.appointments.edit', $appointment->id) }}" class="text-blue-600 hover:underline flex items-center">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <form action="{{ route('dokter.appointments.destroy', $appointment->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline flex items-center" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">
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
