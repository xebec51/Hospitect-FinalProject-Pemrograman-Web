@extends('layouts.app')

@section('title', 'Umpan Balik Pasien')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Umpan Balik Pasien</h1>

    @if ($feedbacks->isEmpty())
        <div class="bg-yellow-100 text-yellow-700 p-4 rounded-md mb-4">
            <strong>Belum ada umpan balik untuk Anda.</strong>
        </div>
    @else
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border-b border-gray-200 p-4 text-left text-sm font-semibold">Pasien</th>
                    <th class="border-b border-gray-200 p-4 text-left text-sm font-semibold">Rating</th>
                    <th class="border-b border-gray-200 p-4 text-left text-sm font-semibold">Komentar</th>
                    <th class="border-b border-gray-200 p-4 text-left text-sm font-semibold">Tanggal</th>
                    <th class="border-b border-gray-200 p-4 text-left text-sm font-semibold">Waktu</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($feedbacks as $feedback)
                    <tr>
                        <td class="border-b border-gray-200 p-4">{{ $feedback->appointment->patient->user->name }}</td>
                        <td class="border-b border-gray-200 p-4">
                            <span class="text-yellow-500 font-semibold">{{ $feedback->rating }}</span> / 5
                        </td>
                        <td class="border-b border-gray-200 p-4">{{ $feedback->comment ?? 'Tidak ada komentar' }}</td>
                        <td class="border-b border-gray-200 p-4">{{ $feedback->created_at->format('d-m-Y') }}</td> <!-- Hanya Tanggal -->
                        <td class="border-b border-gray-200 p-4">{{ $feedback->created_at->format('H:i') }}</td> <!-- Hanya Jam -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
