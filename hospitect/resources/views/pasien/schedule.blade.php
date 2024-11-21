@extends('layouts.app')

@section('title', 'Jadwal Konsultasi Saya')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Jadwal Konsultasi Saya</h1>

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
                        <td class="border border-gray-200 p-2">{{ \Carbon\Carbon::parse($appointment->date)->format('d M Y') }}</td>
                        <td class="border border-gray-200 p-2">{{ $appointment->time }}</td>
                        <td class="border border-gray-200 p-2">{{ $appointment->doctor->user->name }}</td>
                        <td class="border border-gray-200 p-2">{{ ucfirst($appointment->status) }}</td>
                        <td class="border border-gray-200 p-2">
                            <form action="{{ route('appointments.update-status', $appointment->id) }}" method="POST" class="inline-block">
                                @csrf
                                <select name="status" onchange="this.form.submit()" class="border border-gray-300 rounded">
                                    <option value="scheduled" {{ $appointment->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                    <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
