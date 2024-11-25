@extends('layouts.app')

@section('title', 'Login - Hospitect')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-center">Login to Hospitect</h2>

    <!-- Session Status -->
    @if (session('info'))
        <div class="mb-4 text-blue-600">
            {{ session('info') }}
        </div>
    @endif
    @if ($errors->has('error'))
        <div class="mb-4 text-red-600">
            {{ $errors->first('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

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
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" name="remember" class="mr-2">
                <span class="text-sm text-gray-600">Remember me</span>
            </label>
        </div>

        <div class="flex items-center justify-between">
            @if (Route::has('password.request'))
                <a class="text-sm text-blue-600 hover:underline" href="{{ route('password.request') }}">Forgot your password?</a>
            @endif

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Log in</button>
        </div>
    </form>

    <div class="mt-4 text-center">
        <p class="text-sm text-gray-600">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Register here</a>.
        </p>
    </div>
</div>
@endsection
