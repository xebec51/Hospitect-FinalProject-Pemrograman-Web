@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4"><i class="fas fa-pills"></i> Tambah Obat Baru</h1>

    <form action="{{ route('admin.medicines.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700"><i class="fas fa-capsules"></i> Nama Obat</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" required>
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea name="description" id="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">{{ old('description') }}</textarea>
        </div>

        <div>
            <label for="type" class="block text-sm font-medium text-gray-700">Jenis Obat</label>
            <select name="type" id="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" required>
                <option value="Tablet" {{ old('type') == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                <option value="Kapsul" {{ old('type') == 'Kapsul' ? 'selected' : '' }}>Kapsul</option>
                <option value="Sirup" {{ old('type') == 'Sirup' ? 'selected' : '' }}>Sirup</option>
                <option value="Injeksi" {{ old('type') == 'Injeksi' ? 'selected' : '' }}>Injeksi</option>
            </select>
        </div>

        <div>
            <label for="stock" class="block text-sm font-medium text-gray-700">Stok</label>
            <input type="number" name="stock" id="stock" value="{{ old('stock') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" required>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"><i class="fas fa-save"></i> Simpan</button>
    </form>
</div>
@endsection
