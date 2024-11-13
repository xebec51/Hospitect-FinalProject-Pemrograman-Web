@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Daftar Pengguna</h1>
        <a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tambah Pengguna</a>
    </div>

    @if (session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b-2 border-gray-300 text-left">Nama</th>
                    <th class="py-2 px-4 border-b-2 border-gray-300 text-left">Email</th>
                    <th class="py-2 px-4 border-b-2 border-gray-300 text-left">Peran</th>
                    <th class="py-2 px-4 border-b-2 border-gray-300 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b border-gray-300">{{ $user->name }}</td>
                        <td class="py-2 px-4 border-b border-gray-300">{{ $user->email }}</td>
                        <td class="py-2 px-4 border-b border-gray-300 capitalize">{{ $user->role }}</td>
                        <td class="py-2 px-4 border-b border-gray-300">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
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
