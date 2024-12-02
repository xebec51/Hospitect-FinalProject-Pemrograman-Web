@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold"><i class="fas fa-users"></i> Daftar Pengguna</h1>
        <a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            <i class="fas fa-user-plus"></i> Tambah Pengguna
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Pencarian dan Sorting -->
    <div class="mb-4 flex space-x-4">
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex space-x-4">
            <div class="relative">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari Nama..." class="border p-2 rounded pl-10">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded"><i class="fas fa-search"></i> Cari</button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b-2 border-gray-300 text-left">
                        <a href="{{ route('admin.users.index', ['search' => $search, 'sortBy' => 'name', 'sortDirection' => $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                            <i class="fas fa-user"></i> Nama
                            @if($sortBy == 'name')
                                @if($sortDirection == 'asc')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </a>
                    </th>
                    <th class="py-2 px-4 border-b-2 border-gray-300 text-left">
                        <a href="{{ route('admin.users.index', ['search' => $search, 'sortBy' => 'email', 'sortDirection' => $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                            <i class="fas fa-envelope"></i> Email
                            @if($sortBy == 'email')
                                @if($sortDirection == 'asc')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </a>
                    </th>
                    <th class="py-2 px-4 border-b-2 border-gray-300 text-left">
                        <a href="{{ route('admin.users.index', ['search' => $search, 'sortBy' => 'role', 'sortDirection' => $sortDirection == 'asc' ? 'desc' : 'asc']) }}">
                            <i class="fas fa-user-tag"></i> Peran
                            @if($sortBy == 'role')
                                @if($sortDirection == 'asc')
                                    <i class="fas fa-sort-up"></i>
                                @else
                                    <i class="fas fa-sort-down"></i>
                                @endif
                            @endif
                        </a>
                    </th>
                    <th class="py-2 px-4 border-b-2 border-gray-300 text-left"><i class="fas fa-cogs"></i> Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b border-gray-300">{{ $user->name }}</td>
                        <td class="py-2 px-4 border-b border-gray-300">{{ $user->email }}</td>
                        <td class="py-2 px-4 border-b border-gray-300 capitalize">{{ $user->role }}</td>
                        <td class="py-2 px-4 border-b border-gray-300">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:underline mr-2">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">Tidak ada pengguna yang terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
