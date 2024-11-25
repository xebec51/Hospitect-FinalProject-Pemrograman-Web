@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
<div class="bg-white shadow-md rounded p-6">
    <h1 class="text-2xl font-bold mb-4">Tambah Pengguna</h1>
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700">Nama</label>
            <input type="text" name="name" id="name" class="w-full p-2 border rounded" required>
            @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input type="email" name="email" id="email" class="w-full p-2 border rounded" required>
            @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700">Password</label>
            <input type="password" name="password" id="password" class="w-full p-2 border rounded" required>
            @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="block text-gray-700">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full p-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label for="role" class="block text-gray-700">Peran</label>
            <select name="role" id="role" class="w-full p-2 border rounded" required onchange="toggleRoleFields(this.value)">
                <option value="admin">Admin</option>
                <option value="dokter">Dokter</option>
                <option value="pasien">Pasien</option>
            </select>
        </div>
        <div id="dokterFields" class="hidden">
            <div class="mb-4">
                <label for="license_number" class="block text-gray-700">Nomor Lisensi</label>
                <input type="text" name="license_number" id="license_number" class="w-full p-2 border rounded">
            </div>
            <div class="mb-4">
                <label for="specialization" class="block text-gray-700">Spesialisasi</label>
                <input type="text" name="specialization" id="specialization" class="w-full p-2 border rounded">
            </div>
        </div>
        <div id="pasienFields" class="hidden">
            <div class="mb-4">
                <label for="insurance_number" class="block text-gray-700">Nomor Asuransi</label>
                <input type="text" name="insurance_number" id="insurance_number" class="w-full p-2 border rounded">
            </div>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tambah Pengguna</button>
        </div>
    </form>
</div>
<script>
    function toggleRoleFields(role) {
        document.getElementById('dokterFields').classList.add('hidden');
        document.getElementById('pasienFields').classList.add('hidden');
        if (role === 'dokter') {
            document.getElementById('dokterFields').classList.remove('hidden');
        } else if (role === 'pasien') {
            document.getElementById('pasienFields').classList.remove('hidden');
        }
    }
</script>
@endsection
