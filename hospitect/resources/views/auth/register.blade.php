@extends('layouts.app')

@section('title', 'Register - Pasien')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-center">Registrasi Pasien</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register.store') }}">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-gray-700">Nama</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required class="w-full p-2 border rounded">
            @error('name')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required class="w-full p-2 border rounded">
            @error('email')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-gray-700">Password</label>
            <input id="password" type="password" name="password" required class="w-full p-2 border rounded">
            @error('password')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block text-gray-700">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required class="w-full p-2 border rounded">
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">Sudah punya akun? Login</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Daftar</button>
        </div>
    </form>
</div>
@endsection
