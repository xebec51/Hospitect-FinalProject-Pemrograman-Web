@extends('layouts.app')

@section('title', 'Edit Feedback')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Feedback</h1>

    @if ($feedback->appointment->status == 'completed')
        <form action="{{ route('pasien.feedback.update', $feedback->id) }}" method="POST" class="bg-white shadow-md rounded p-4">
            @csrf
            @method('PUT')

            <input type="hidden" name="appointment_id" value="{{ $feedback->appointment_id }}">

            <div class="mb-4">
                <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                <select name="rating" id="rating" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                    <option value="1" {{ old('rating', $feedback->rating) == 1 ? 'selected' : '' }}>1</option>
                    <option value="2" {{ old('rating', $feedback->rating) == 2 ? 'selected' : '' }}>2</option>
                    <option value="3" {{ old('rating', $feedback->rating) == 3 ? 'selected' : '' }}>3</option>
                    <option value="4" {{ old('rating', $feedback->rating) == 4 ? 'selected' : '' }}>4</option>
                    <option value="5" {{ old('rating', $feedback->rating) == 5 ? 'selected' : '' }}>5</option>
                </select>

                @error('rating')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label for="comment" class="block text-sm font-medium text-gray-700">Komentar</label>
                <textarea name="comment" id="comment" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">{{ old('comment', $feedback->comment) }}</textarea>

                @error('comment')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded flex items-center">
                <i class="fas fa-save mr-2"></i> Perbarui Feedback
            </button>
        </form>
    @else
        <p class="text-red-500">Feedback hanya dapat diedit jika janji temu sudah selesai.</p>
    @endif
</div>
@endsection
