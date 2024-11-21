@extends('layouts.app')

@section('title', 'Umpan Balik Pasien')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Umpan Balik Pasien</h1>
    <table class="min-w-full bg-white border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="border border-gray-200 p-2 text-left">Pasien</th>
                <th class="border border-gray-200 p-2 text-left">Rating</th>
                <th class="border border-gray-200 p-2 text-left">Komentar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($feedbacks as $feedback)
                <tr>
                    <td class="border border-gray-200 p-2">{{ $feedback->appointment->patient->user->name }}</td>
                    <td class="border border-gray-200 p-2">{{ $feedback->rating }}</td>
                    <td class="border border-gray-200 p-2">{{ $feedback->comment ?? 'Tidak ada komentar' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
