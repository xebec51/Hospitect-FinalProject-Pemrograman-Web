@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Obat</h1>

    <!-- Form untuk mengedit data obat -->
    <form action="{{ route('admin.medicines.update', $medicine->id_obat) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nama_obat" class="block text-sm font-medium text-gray-700">Nama Obat</label>
            <input type="text" name="nama_obat" id="nama_obat" value="{{ old('nama_obat', $medicine->nama_obat) }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">{{ old('deskripsi', $medicine->deskripsi) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="jenis_obat" class="block text-sm font-medium text-gray-700">Jenis Obat</label>
            <select name="jenis_obat" id="jenis_obat" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                <option value="biasa" {{ $medicine->jenis_obat == 'biasa' ? 'selected' : '' }}>Biasa</option>
                <option value="keras" {{ $medicine->jenis_obat == 'keras' ? 'selected' : '' }}>Keras</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
            <input type="number" name="stok" id="stok" value="{{ old('stok', $medicine->stok) }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
        </div>

        <div class="mb-4">
            <label for="gambar_obat" class="block text-sm font-medium text-gray-700">Gambar Obat</label>
            <input type="file" name="gambar_obat" id="gambar_obat"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
            @if ($medicine->gambar_obat)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $medicine->gambar_obat) }}" alt="Gambar Obat" class="h-16 w-16 object-cover">
                </div>
            @endif
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan Perubahan</button>
    </form>
</div>
@endsection
