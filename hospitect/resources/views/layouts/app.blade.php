<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hospitect')</title>
    <!-- Menggunakan Vite untuk memuat CSS -->
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <!-- Navbar -->
    <nav class="bg-blue-600 p-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-white text-2xl font-bold">Hospitect</a>
            <ul class="flex space-x-4 text-white">
                @if(Auth::check())
                    @if(Auth::user()->role === 'admin')
                        <li><a href="{{ route('admin.dashboard') }}" class="hover:text-gray-300">Dashboard Admin</a></li>
                        <li><a href="{{ route('admin.users.index') }}" class="hover:text-gray-300">Manajemen Pengguna</a></li>
                        <li><a href="{{ route('admin.medicines.index') }}" class="hover:text-gray-300">Manajemen Obat</a></li>
                    @elseif(Auth::user()->role === 'dokter')
                        <li><a href="{{ route('dokter.dashboard') }}" class="hover:text-gray-300">Dashboard Dokter</a></li>
                        <li><a href="{{ route('dokter.medical-records.index') }}" class="hover:text-gray-300">Rekam Medis</a></li>
                        <li><a href="{{ route('dokter.jadwal-konsultasi.index') }}" class="hover:text-gray-300">Jadwal Konsultasi</a></li> <!-- Menu baru untuk dokter -->
                    @elseif(Auth::user()->role === 'pasien')
                        <li><a href="{{ route('pasien.dashboard') }}" class="hover:text-gray-300">Dashboard Pasien</a></li>
                        <li><a href="{{ route('pasien.records') }}" class="hover:text-gray-300">Rekam Medis Saya</a></li>
                    @endif
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="hover:text-gray-300">Logout</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}" class="hover:text-gray-300">Login</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-gray-300">Register</a></li>
                @endif
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto mt-10">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="bg-blue-600 text-white mt-10 p-4 text-center">
        &copy; {{ date('Y') }} Hospitect. All rights reserved.
    </footer>

    <!-- Menggunakan Vite untuk memuat JS -->
    @vite('resources/js/app.js')
</body>
</html>
