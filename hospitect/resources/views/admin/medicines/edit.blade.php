@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Obat</h1>

    <form action="{{ route('admin.medicines.update', $medicine->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Obat</label>
            <input type="text" name="name" id="name" value="{{ old('name', $medicine->name) }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea name="description" id="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">{{ old('description', $medicine->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="type" class="block text-sm font-medium text-gray-700">Jenis Obat</label>
            <select name="type" id="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                <option value="biasa" {{ $medicine->type == 'biasa' ? 'selected' : '' }}>Biasa</option>
                <option value="keras" {{ $medicine->type == 'keras' ? 'selected' : '' }}>Keras</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="stock" class="block text-sm font-medium text-gray-700">Stok</label>
            <input type="number" name="stock" id="stock" value="{{ old('stock', $medicine->stock) }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
        </div>

        <div class="mb-4">
            <label for="image" class="block text-sm font-medium text-gray-700">Gambar Obat</label>
            <input type="file" name="image" id="image"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
            @if ($medicine->image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $medicine->image) }}" alt="Gambar Obat" class="h-16 w-16 object-cover">
                </div>
            @endif
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan Perubahan</button>
    </form>
</div>
@endsection
