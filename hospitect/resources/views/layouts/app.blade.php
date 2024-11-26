<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hospitect')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    @vite('resources/css/app.css')
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            transition: background-color 0.3s;
        }
        .sidebar-link:hover {
            background-color: #2d3748;
        }
        .active {
            background-color: #4a5568;
        }
        #loader {
            position: fixed;
            inset: 0;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            visibility: hidden;
            opacity: 0;
            transition: visibility 0s, opacity 0.3s ease-in-out;
        }
        #loader.show {
            visibility: visible;
            opacity: 1;
        }
    </style>
</head>
<body class="bg-gray-100 flex min-h-screen">
    <!-- Loader -->
    <div id="loader">
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-teal-900"></div>
    </div>

    @auth
        <!-- Sidebar -->
        <aside class="bg-teal-900 text-white w-64 flex-shrink-0 min-h-screen p-6 shadow-lg">
            <div class="flex items-center mb-8">
                <h1 class="text-3xl font-bold">Hospitect</h1>
            </div>
            <nav>
                <ul class="space-y-4">
                    @switch(Auth::user()->role)
                        @case('admin')
                            <li><a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard Admin</a></li>
                            <li><a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Manajemen Pengguna</a></li>
                            <li><a href="{{ route('admin.medicines.index') }}" class="sidebar-link {{ request()->routeIs('admin.medicines.*') ? 'active' : '' }}">Manajemen Obat</a></li>
                            @break
                        @case('dokter')
                            <li><a href="{{ route('dokter.dashboard') }}" class="sidebar-link {{ request()->routeIs('dokter.dashboard') ? 'active' : '' }}">Dashboard Dokter</a></li>
                            <li><a href="{{ route('dokter.appointments.index') }}" class="sidebar-link {{ request()->routeIs('dokter.appointments.*') ? 'active' : '' }}">Jadwal Konsultasi</a></li>
                            <li><a href="{{ route('dokter.medical-records.index') }}" class="sidebar-link {{ request()->routeIs('dokter.medical-records.*') ? 'active' : '' }}">Rekam Medis</a></li>
                            <li><a href="{{ route('dokter.feedback') }}" class="sidebar-link {{ request()->routeIs('dokter.feedback') ? 'active' : '' }}">Feedback</a></li>
                            @break
                        @case('pasien')
                            <li><a href="{{ route('pasien.dashboard') }}" class="sidebar-link {{ request()->routeIs('pasien.dashboard') ? 'active' : '' }}">Dashboard Pasien</a></li>
                            <li><a href="{{ route('pasien.appointments.index') }}" class="sidebar-link {{ request()->routeIs('pasien.appointments.*') ? 'active' : '' }}">Jadwal Konsultasi</a></li>
                            <li><a href="{{ route('pasien.records') }}" class="sidebar-link {{ request()->routeIs('pasien.records') ? 'active' : '' }}">Rekam Medis Saya</a></li>
                            @break
                        @default
                            <li><span class="block p-2 text-gray-400">Role tidak dikenal</span></li>
                    @endswitch
                </ul>
            </nav>
        </aside>
    @endauth

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col">
        <!-- Header -->
        <header class="bg-white text-teal-900 shadow p-4 flex justify-between items-center border-b border-gray-200">
            <div class="text-2xl font-semibold">Hospitect</div>
            @auth
                <div class="relative">
                    <button id="userMenuButton" class="flex items-center space-x-2 focus:outline-none">
                        <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('images/OIP.jpg') }}" alt="User Image" class="w-10 h-10 rounded-full border border-teal-900">
                        <span class="text-teal-900 font-medium">{{ Auth::user()->name }}</span>
                    </button>
                    <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white shadow-md rounded-md overflow-hidden z-50">
                        @php
                            $profileRoute = Auth::user()->role . '.profile';
                        @endphp
                        @if (Route::has($profileRoute))
                            <a href="{{ route($profileRoute) }}" class="block px-4 py-2 text-gray-700 hover:bg-teal-100">Profil</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-teal-100">Logout</button>
                        </form>
                    </div>
                </div>
            @endauth
        </header>

        <!-- Main Content -->
        <main class="flex-1 p-6 bg-white shadow-inner rounded-lg">
            @yield('content')
        </main>
    </div>

    <script>
        // User Menu Toggle
        const userMenuButton = document.getElementById('userMenuButton');
        if (userMenuButton) {
            userMenuButton.addEventListener('click', function () {
                document.getElementById('userMenu').classList.toggle('hidden');
            });
        }

        // Loader Logic
        document.addEventListener('DOMContentLoaded', () => {
            const loader = document.getElementById('loader');
            const links = document.querySelectorAll('a');

            links.forEach(link => {
                link.addEventListener('click', (e) => {
                    if (link.href.startsWith(window.location.origin) && !e.defaultPrevented) {
                        loader.classList.add('show');
                    }
                });
            });

            // Ensure loader hides when navigating back
            window.addEventListener('pageshow', (event) => {
                if (event.persisted && loader) {
                    loader.classList.remove('show');
                }
            });

            loader.classList.remove('show');
        });
    </script>

    @vite('resources/js/app.js')
</body>
</html>
