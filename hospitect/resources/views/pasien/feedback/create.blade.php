@extends('layouts.app')

@section('title', 'Beri Feedback')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Beri Feedback</h1>

    @if ($appointment->status == 'completed')
        <form action="{{ route('pasien.feedback.store') }}" method="POST" class="bg-white shadow-md rounded p-4">
            @csrf

            <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">

            <div class="mb-4">
                <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                <select name="rating" id="rating" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="comment" class="block text-sm font-medium text-gray-700">Komentar</label>
                <textarea name="comment" id="comment" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm"></textarea>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded flex items-center">
                <i class="fas fa-paper-plane mr-2"></i> Kirim Feedback
            </button>
        </form>
    @else
        <p class="text-red-500">Feedback hanya dapat diberikan jika janji temu sudah selesai.</p>
    @endif
</div>
@endsection
