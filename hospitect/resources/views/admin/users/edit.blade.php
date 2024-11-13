@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Pengguna</h1>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
        </div>

        <div>
            <label for="role" class="block text-sm font-medium text-gray-700">Peran</label>
            <select name="role" id="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" onchange="toggleEditRoleFields(this.value)">
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="dokter" {{ $user->role == 'dokter' ? 'selected' : '' }}>Dokter</option>
                <option value="pasien" {{ $user->role == 'pasien' ? 'selected' : '' }}>Pasien</option>
            </select>
        </div>

        <div id="editDokterFields" class="mb-4 {{ $user->role == 'dokter' ? '' : 'hidden' }}">
            <label for="license_number" class="block text-gray-700">Nomor Lisensi (Dokter)</label>
            <input type="text" name="license_number" id="license_number" value="{{ old('license_number', $user->dokter->license_number ?? '') }}"
                   class="w-full p-2 border rounded">
        </div>
        <div id="editPasienFields" class="mb-4 {{ $user->role == 'pasien' ? '' : 'hidden' }}">
            <label for="insurance_number" class="block text-gray-700">Nomor Asuransi (Pasien)</label>
            <input type="text" name="insurance_number" id="insurance_number" value="{{ old('insurance_number', $user->pasien->insurance_number ?? '') }}"
                   class="w-full p-2 border rounded">
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan Perubahan</button>
        </div>
    </form>
</div>
<script>
    function toggleEditRoleFields(role) {
        document.getElementById('editDokterFields').classList.add('hidden');
        document.getElementById('editPasienFields').classList.add('hidden');
        if (role === 'dokter') {
            document.getElementById('editDokterFields').classList.remove('hidden');
        } else if (role === 'pasien') {
            document.getElementById('editPasienFields').classList.remove('hidden');
        }
    }
</script>
@endsection
