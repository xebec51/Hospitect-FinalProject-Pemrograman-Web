@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Daftar Obat</h1>
        <a href="{{ route('admin.medicines.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tambah Obat</a>
    </div>

    @if (session('success'))
        <div class="bg-green-500 text-white p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-200 p-2 text-left">Nama Obat</th>
                    <th class="border border-gray-200 p-2 text-left">Deskripsi</th>
                    <th class="border border-gray-200 p-2 text-left">Tipe</th>
                    <th class="border border-gray-200 p-2 text-left">Stok</th>
                    <th class="border border-gray-200 p-2 text-left">Gambar</th>
                    <th class="border border-gray-200 p-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($medicines as $medicine)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-200 p-2">{{ $medicine->name }}</td>
                        <td class="border border-gray-200 p-2">{{ $medicine->description }}</td>
                        <td class="border border-gray-200 p-2">{{ ucfirst($medicine->type) }}</td>
                        <td class="border border-gray-200 p-2">{{ $medicine->stock }}</td>
                        <td class="border border-gray-200 p-2">
                            @if($medicine->image)
                                <img src="{{ asset('storage/' . $medicine->image) }}" alt="Gambar Obat" class="h-16 w-16 object-cover">
                            @else
                                <span class="text-gray-500">Tidak ada gambar</span>
                            @endif
                        </td>
                        <td class="border border-gray-200 p-2 flex space-x-2">
                            <a href="{{ route('admin.medicines.edit', $medicine->id) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.medicines.destroy', $medicine->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center p-4">Tidak ada data obat yang tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
