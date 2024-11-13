@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Tambah Obat Baru</h1>

    <!-- Form untuk menambahkan obat baru -->
    <form action="{{ route('admin.medicines.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label for="nama_obat" class="block text-sm font-medium text-gray-700">Nama Obat</label>
            <input type="text" name="nama_obat" id="nama_obat" value="{{ old('nama_obat') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" required>
        </div>

        <div>
            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">{{ old('deskripsi') }}</textarea>
        </div>

        <div>
            <label for="jenis_obat" class="block text-sm font-medium text-gray-700">Jenis Obat</label>
            <select name="jenis_obat" id="jenis_obat" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" required>
                <option value="biasa" {{ old('jenis_obat') == 'biasa' ? 'selected' : '' }}>Biasa</option>
                <option value="keras" {{ old('jenis_obat') == 'keras' ? 'selected' : '' }}>Keras</option>
            </select>
        </div>

        <div>
            <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
            <input type="number" name="stok" id="stok" value="{{ old('stok') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" required>
        </div>

        <div>
            <label for="gambar_obat" class="block text-sm font-medium text-gray-700">Gambar Obat</label>
            <input type="file" name="gambar_obat" id="gambar_obat"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
    </form>
</div>
@endsection
