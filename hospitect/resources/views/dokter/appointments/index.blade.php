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
                    <th class="border border-gray-200 p-2 text-left"><i class="fas fa-calendar-day mr-2"></i>Tanggal</th>
                    <th class="border border-gray-200 p-2 text-left"><i class="fas fa-clock mr-2"></i>Waktu</th>
                    <th class="border border-gray-200 p-2 text-left"><i class="fas fa-user mr-2"></i>Pasien</th>
                    <th class="border border-gray-200 p-2 text-left"><i class="fas fa-info-circle mr-2"></i>Status</th>
                    <th class="border border-gray-200 p-2 text-left"><i class="fas fa-cogs mr-2"></i>Aksi</th>
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
