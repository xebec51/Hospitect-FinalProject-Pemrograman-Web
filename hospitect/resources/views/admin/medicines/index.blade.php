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

    <!-- Pencarian dan Sorting -->
    <div class="mb-4 flex space-x-4">
        <form action="{{ route('admin.medicines.index') }}" method="GET" class="flex space-x-4">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari Obat..." class="border p-2 rounded">
            <select name="sortBy" class="border p-2 rounded">
                <option value="name" {{ $sortBy == 'name' ? 'selected' : '' }}>Nama Obat</option>
                <option value="type" {{ $sortBy == 'type' ? 'selected' : '' }}>Tipe</option>
                <option value="stock" {{ $sortBy == 'stock' ? 'selected' : '' }}>Stok</option>
            </select>
            <select name="sortDirection" class="border p-2 rounded">
                <option value="asc" {{ $sortDirection == 'asc' ? 'selected' : '' }}>Ascending</option>
                <option value="desc" {{ $sortDirection == 'desc' ? 'selected' : '' }}>Descending</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Terapkan</button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b-2 border-gray-300 text-left">
                        <a href="{{ route('admin.medicines.index', ['search' => $search, 'sortBy' => 'name', 'sortDirection' => $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                            Nama Obat
                            @if($sortBy == 'name')
                                @if($sortDirection == 'asc')
                                    &darr;
                                @else
                                    &uarr;
                                @endif
                            @endif
                        </a>
                    </th>
                    <th class="py-2 px-4 border-b-2 border-gray-300 text-left">
                        <a href="{{ route('admin.medicines.index', ['search' => $search, 'sortBy' => 'type', 'sortDirection' => $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                            Tipe
                            @if($sortBy == 'type')
                                @if($sortDirection == 'asc')
                                    &darr;
                                @else
                                    &uarr;
                                @endif
                            @endif
                        </a>
                    </th>
                    <th class="py-2 px-4 border-b-2 border-gray-300 text-left">
                        <a href="{{ route('admin.medicines.index', ['search' => $search, 'sortBy' => 'stock', 'sortDirection' => $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                            Stok
                            @if($sortBy == 'stock')
                                @if($sortDirection == 'asc')
                                    &darr;
                                @else
                                    &uarr;
                                @endif
                            @endif
                        </a>
                    </th>
                    <th class="py-2 px-4 border-b-2 border-gray-300 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($medicines as $medicine)
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b border-gray-300">{{ $medicine->name }}</td>
                        <td class="py-2 px-4 border-b border-gray-300">{{ $medicine->type }}</td>
                        <td class="py-2 px-4 border-b border-gray-300">{{ $medicine->stock }}</td>
                        <td class="py-2 px-4 border-b border-gray-300">
                            <a href="{{ route('admin.medicines.edit', $medicine->id) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                            <form action="{{ route('admin.medicines.destroy', $medicine->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">Tidak ada data obat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
