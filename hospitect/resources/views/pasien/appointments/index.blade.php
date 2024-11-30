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

    <!-- Pencarian -->
    <form action="{{ route('pasien.appointments.index') }}" method="GET" class="mb-4 flex">
        <input type="text" name="search" placeholder="Cari Tanggal, Waktu, atau Dokter" class="p-2 border border-gray-300 rounded-l-md" value="{{ request('search') }}">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r-md">Cari</button>
    </form>

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
                    <!-- Sorting Tanggal -->
                    <th class="border border-gray-200 p-2 text-left">
                        <a href="{{ route('pasien.appointments.index', ['sort_by' => 'date', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}" class="flex items-center">
                            Tanggal
                            @if (request('sort_by') === 'date')
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            @endif
                        </a>
                    </th>
                    <!-- Sorting Waktu -->
                    <th class="border border-gray-200 p-2 text-left">Waktu</th>
                    <th class="border border-gray-200 p-2 text-left">Dokter</th>
                    <!-- Sorting Status -->
                    <th class="border border-gray-200 p-2 text-left">
                        <a href="{{ route('pasien.appointments.index', ['sort_by' => 'status', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}">
                            Status
                            @if (request('sort_by') === 'status')
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            @endif
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
                        <td class="border border-gray-200 p-2">{{ ucfirst($appointment->status) }}</td>
                        <td class="border border-gray-200 p-2">
                            @if ($appointment->status == 'completed' && $appointment->date >= \Carbon\Carbon::now()->subDays(3))
                                @php
                                    $feedback = $appointment->feedback;
                                @endphp
                                @if ($feedback)
                                    <form action="{{ route('pasien.feedback.edit', $feedback->id) }}" method="GET">
                                        <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">Edit Feedback</button>
                                    </form>
                                @else
                                    <form action="{{ route('pasien.feedback.create', $appointment->id) }}" method="GET">
                                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Beri Feedback</button>
                                    </form>
                                @endif
                            @endif
                            @if ($appointment->status != 'completed')
                                <a href="{{ route('pasien.appointments.edit', $appointment->id) }}" class="text-blue-600 hover:underline">Edit Jadwal</a>
                            @endif
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
