@extends('layouts.app')

@section('title', 'Verify Email - Hospitect')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-center">Verify Your Email Address</h2>

    <p class="mb-4 text-gray-600">A fresh verification link has been sent to your email address.</p>
    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 text-green-600">
            {{ __('A new verification link has been sent to your email address.') }}
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Resend Verification Email</button>
    </form>

    <div class="mt-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-blue-600 hover:underline">Log Out</button>
        </form>
    </div>
</div>
@endsection
