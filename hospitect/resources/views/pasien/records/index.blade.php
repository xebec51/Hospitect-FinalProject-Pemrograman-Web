@extends('layouts.app')

@section('title', 'Rekam Medis Saya')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Rekam Medis Saya</h1>

    @if (session('success'))
        <div class="bg-green-500 text-white p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-white border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="py-2 px-4 border-b">Tanggal</th>
                <th class="py-2 px-4 border-b">Dokter</th>
                <th class="py-2 px-4 border-b">Catatan</th>
                <th class="py-2 px-4 border-b">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $appointment)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $appointment->date }}</td>
                    <td class="py-2 px-4 border-b">{{ $appointment->doctor->user->name }}</td>
                    <td class="py-2 px-4 border-b">{{ $appointment->notes }}</td>
                    <td class="py-2 px-4 border-b">
                        @if ($appointment->status == 'completed' && $appointment->date >= \Carbon\Carbon::now()->subDays(3))
                            <form action="{{ route('pasien.feedback.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                                <div class="mb-2">
                                    <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                                    <select name="rating" id="rating" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label for="comment" class="block text-sm font-medium text-gray-700">Komentar</label>
                                    <textarea name="comment" id="comment" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm"></textarea>
                                </div>
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Kirim Feedback</button>
                            </form>
                        @else
                            <span class="text-gray-500">Tidak dapat memberikan feedback</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
