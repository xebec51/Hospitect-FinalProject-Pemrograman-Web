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
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r-md flex items-center">
            <i class="fas fa-search mr-2"></i> Cari
        </button>
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
                                <i class="fas fa-sort{{ request('sort_order') === 'asc' ? '-up' : '-down' }} ml-2"></i>
                            @endif
                        </a>
                    </th>
                    <!-- Sorting Waktu -->
                    <th class="border border-gray-200 p-2 text-left">Waktu</th>
                    <th class="border border-gray-200 p-2 text-left">Dokter</th>
                    <!-- Sorting Status -->
                    <th class="border border-gray-200 p-2 text-left">
                        <a href="{{ route('pasien.appointments.index', ['sort_by' => 'status', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}" class="flex items-center">
                            Status
                            @if (request('sort_by') === 'status')
                                <i class="fas fa-sort{{ request('sort_order') === 'asc' ? '-up' : '-down' }} ml-2"></i>
                            @endif
                        </a>
                    </th>
                    <th class="border border-gray-200 p-2 text-left">Aksi</th>
                    <th class="border border-gray-200 p-2 text-left">Feedback</th>
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
                            @if ($appointment->status != 'completed')
                                <a href="{{ route('pasien.appointments.edit', $appointment->id) }}" class="text-blue-600 hover:underline mr-2">
                                    <i class="fas fa-edit mr-1"></i> Edit Jadwal
                                </a>
                            @endif
                            <form action="{{ route('pasien.appointments.destroy', $appointment->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </button>
                            </form>
                        </td>
                        <td class="border border-gray-200 p-2">
                            @if ($appointment->status == 'completed')
                                @php
                                    $feedback = $appointment->feedback;
                                @endphp
                                @if ($feedback)
                                    <div class="mb-2">
                                        <strong>Rating:</strong>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i <= $feedback->rating ? ' text-yellow-500' : ' text-gray-300' }}"></i>
                                        @endfor
                                        <br>
                                        <strong>Komentar:</strong> {{ Str::limit($feedback->comment, 50) }}
                                    </div>
                                    <form action="{{ route('pasien.feedback.edit', $feedback->id) }}" method="GET">
                                        <button type="submit" class="text-blue-600 hover:underline flex items-center">
                                            <i class="fas fa-edit mr-1"></i> Edit Feedback
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('pasien.feedback.create', $appointment->id) }}" method="GET">
                                        <button type="submit" class="text-blue-600 hover:underline flex items-center">
                                            <i class="fas fa-comment-dots mr-1"></i> Beri Feedback
                                        </button>
                                    </form>
                                @endif
                            @elseif ($appointment->status == 'cancelled')
                                <p class="text-gray-500"><i class="fas fa-ban mr-1"></i> Feedback tidak tersedia karena konsultasi dibatalkan.</p>
                            @else
                                <p class="text-gray-500"><i class="fas fa-clock mr-1"></i> Feedback tersedia setelah konsultasi selesai.</p>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
