@extends('layouts.app')

@section('title', 'Umpan Balik Pasien')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4"><i class="fas fa-comments mr-2"></i>Umpan Balik Pasien</h1>

    @if ($feedbacks->isEmpty())
        <div class="bg-yellow-100 text-yellow-700 p-4 rounded-md mb-4 flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <strong>Belum ada umpan balik untuk Anda.</strong>
        </div>
    @else
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border-b border-gray-200 p-4 text-left text-sm font-semibold"><i class="fas fa-user mr-2"></i>Pasien</th>
                    <th class="border-b border-gray-200 p-4 text-left text-sm font-semibold"><i class="fas fa-star mr-2"></i>Rating</th>
                    <th class="border-b border-gray-200 p-4 text-left text-sm font-semibold"><i class="fas fa-comment mr-2"></i>Komentar</th>
                    <th class="border-b border-gray-200 p-4 text-left text-sm font-semibold"><i class="fas fa-calendar-alt mr-2"></i>Tanggal</th>
                    <th class="border-b border-gray-200 p-4 text-left text-sm font-semibold"><i class="fas fa-clock mr-2"></i>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($feedbacks as $feedback)
                    <tr class="hover:bg-gray-50">
                        <td class="border-b border-gray-200 p-4">{{ $feedback->appointment->patient->user->name }}</td>
                        <td class="border-b border-gray-200 p-4">
                            <span class="text-yellow-500 font-semibold">{{ $feedback->rating }}</span> / 5
                        </td>
                        <td class="border-b border-gray-200 p-4">{{ $feedback->comment ?? 'Tidak ada komentar' }}</td>
                        <td class="border-b border-gray-200 p-4">{{ $feedback->created_at->format('d-m-Y') }}</td>
                        <td class="border-b border-gray-200 p-4">{{ $feedback->created_at->format('H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
