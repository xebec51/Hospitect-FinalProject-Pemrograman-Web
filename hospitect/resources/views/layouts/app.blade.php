<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hospitect')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    @vite('resources/css/app.css')
    <!-- FontAwesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        /* Sidebar Styling */
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-radius: 0.5rem;
            transition: background-color 0.3s, transform 0.2s ease;
        }

        .sidebar-link:hover {
            background-color: #006db6; /* Soft blue */
            transform: translateX(5px);
        }

        .sidebar-link.active {
            background-color: #004d80; /* Deep blue */
            color: white;
        }

        .sidebar-link i {
            margin-right: 0.75rem;
        }

        /* Sidebar Header Styling */
        .sidebar-header {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
            background-color: #003366; /* Match sidebar color */
            height: 80px; /* Match header height */
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }

        /* User Profile Styling */
        .user-profile img {
            border-radius: 50%;
            border: 2px solid #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .user-profile span {
            font-weight: bold;
        }

        /* Main Content Styling */
        .content-card {
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            padding: 24px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .content-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        /* Loader Styling */
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

        /* Sidebar Styling */
        .sidebar {
            transition: transform 0.3s ease, width 0.3s ease;
            background-color: #003366; /* Dark blue */
            width: 240px;
            min-height: 100vh;
            position: fixed;
            top: 0; /* Adjusted for header height */
            left: 0;
            z-index: 1;
            padding-top: 80px; /* Adjusted for better alignment */
            overflow-y: auto;
        }

        .sidebar-hidden {
            transform: translateX(-240px);
            visibility: hidden; /* Ensure sidebar is completely hidden */
            transition: transform 0.3s ease, visibility 0.3s ease; /* Ensure animation remains */
        }

        .sidebar-toggle {
            display: block;
            font-size: 24px;
            background: none;
            border: none;
            color: #fff;
            cursor: pointer;
        }

        /* Header Styling */
        header {
            position: fixed;
            top: 0;
            left: 240px; /* Adjusted to not overlap with sidebar */
            width: calc(100% - 240px); /* Adjusted to not overlap with sidebar */
            z-index: 2;
            background-color: #006db6; /* Lighter blue header */
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 0.75rem 1.25rem; /* Reduced padding */
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e0e0e0;
            transition: left 0.3s ease, width 0.3s ease;
        }

        header .text-2xl {
            font-weight: bold;
            font-size: 1.5rem; /* Slightly smaller font size */
            flex-grow: 1;
            text-align: center;
        }

        header .user-profile {
            display: flex;
            align-items: center;
        }

        header .user-profile img {
            margin-right: 0.5rem;
        }

        /* Main content padding for fixed header */
        .main-content {
            margin-top: 80px;
            flex-grow: 1;
            padding-left: 240px; /* Sidebar width */
            transition: padding-left 0.3s ease;
        }

        /* Responsive Sidebar */
        @media (max-width: 768px) {
            .sidebar {
                width: 240px;
                transform: translateX(0); /* Ensure sidebar is visible */
            }

            .sidebar-hidden {
                transform: translateX(-240px);
            }

            .sidebar-link {
                justify-content: flex-start; /* Align links to the start on small screens */
            }

            .user-profile span {
                display: inline; /* Show user name for small screens */
            }

            .main-content {
                padding-left: 0; /* Remove padding for small screens */
            }

            header {
                left: 0;
                width: 100%;
            }

            .sidebar-toggle {
                margin-left: 0.5rem;
            }
        }

        /* Dropdown Menu Styling */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            min-width: 150px;
            z-index: 1;
        }

        .dropdown.show .dropdown-content {
            display: block;
        }

        .dropdown-content a {
            color: #333;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown-content button {
            color: #333;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            cursor: pointer;
        }

        .dropdown-content button:hover {
            background-color: #f1f1f1;
        }

        /* Improved Grid Layout */
        .grid {
            display: grid;
            gap: 1.5rem;
        }

        .grid-cols-1 {
            grid-template-columns: 1fr;
        }

        .md\:grid-cols-3 {
            grid-template-columns: repeat(3, 1fr);
        }

        .md\:grid-cols-2 {
            grid-template-columns: repeat(2, 1fr);
        }

        /* Improved Chart Container Styling */
        .chart-container {
            background-color: #fff;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="flex min-h-screen">
    <!-- Loader -->
    <div id="loader">
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-teal-900"></div>
    </div>

    @auth
    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar text-white">
        <div class="sidebar-header">Hospitect</div>
        <nav>
            <ul class="space-y-4">
                @switch(Auth::user()->role)
                @case('admin')
                <li><a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt"></i>Dashboard Admin</a></li>
                <li><a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><i class="fas fa-users"></i>Manajemen Pengguna</a></li>
                <li><a href="{{ route('admin.medicines.index') }}" class="sidebar-link {{ request()->routeIs('admin.medicines.*') ? 'active' : '' }}"><i class="fas fa-pills"></i>Manajemen Obat</a></li>
                <li><a href="{{ route('admin.medical-records.index') }}" class="sidebar-link {{ request()->routeIs('admin.medical-records.*') ? 'active' : '' }}"><i class="fas fa-file-medical-alt"></i>Rekam Medis</a></li>
                <li><a href="{{ route('admin.appointments.index') }}" class="sidebar-link {{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}"><i class="fas fa-calendar-check"></i>Jadwal Konsultasi</a></li>
                @break
                @case('dokter')
                <li><a href="{{ route('dokter.dashboard') }}" class="sidebar-link {{ request()->routeIs('dokter.dashboard') ? 'active' : '' }}"><i class="fas fa-stethoscope"></i>Dashboard Dokter</a></li>
                <li><a href="{{ route('dokter.appointments.index') }}" class="sidebar-link {{ request()->routeIs('dokter.appointments.*') ? 'active' : '' }}"><i class="fas fa-calendar-check"></i>Jadwal Konsultasi</a></li>
                <li><a href="{{ route('dokter.medical-records.index') }}" class="sidebar-link {{ request()->routeIs('dokter.medical-records.*') ? 'active' : '' }}"><i class="fas fa-file-medical-alt"></i>Rekam Medis</a></li>
                <li><a href="{{ route('dokter.feedback') }}" class="sidebar-link {{ request()->routeIs('dokter.feedback') ? 'active' : '' }}"><i class="fas fa-comment-dots"></i>Feedback</a></li>
                @break
                @case('pasien')
                <li><a href="{{ route('pasien.dashboard') }}" class="sidebar-link {{ request()->routeIs('pasien.dashboard') ? 'active' : '' }}"><i class="fas fa-user"></i>Dashboard Pasien</a></li>
                <li><a href="{{ route('pasien.appointments.index') }}" class="sidebar-link {{ request()->routeIs('pasien.appointments.*') ? 'active' : '' }}"><i class="fas fa-calendar-alt"></i>Jadwal Konsultasi</a></li>
                <li><a href="{{ route('pasien.records.index') }}" class="sidebar-link {{ request()->routeIs('pasien.records.index') ? 'active' : '' }}"><i class="fas fa-history"></i>Rekam Medis</a></li>
                @break
                @endswitch
            </ul>
        </nav>
    </aside>
    @endauth

    <!-- Main Content -->
    <div class="main-content flex-grow">
        <header>
            <button class="sidebar-toggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            @auth
            <div class="dropdown">
                <button class="user-profile" onclick="toggleDropdown()">
                    <img src="{{ Auth::user()->profile_photo_url ?? asset('images/OIP.jpg') }}" alt="Profile" width="40" height="40" onerror="this.onerror=null;this.src='{{ asset('images/OIP.jpg') }}';">
                    <span>{{ Auth::user()->name }}</span>
                </button>
                <div class="dropdown-content">
                    @php
                        $profileRoute = Auth::user()->role . '.profile';
                    @endphp
                    @if (Route::has($profileRoute))
                        <a href="{{ route($profileRoute) }}">Profil</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </div>
            </div>
            @endauth
        </header>

        <!-- Content Card -->
        <div class="content-card">
            @yield('content')
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const header = document.querySelector('header');
        const mainContent = document.querySelector('.main-content');

        function toggleSidebar() {
            sidebar.classList.toggle('sidebar-hidden');
            if (sidebar.classList.contains('sidebar-hidden')) {
                header.style.left = '0';
                header.style.width = '100%';
                mainContent.style.paddingLeft = '0';
            } else {
                header.style.left = '240px';
                header.style.width = 'calc(100% - 240px)';
                mainContent.style.paddingLeft = '240px';
            }
        }

        function toggleDropdown() {
            document.querySelector('.dropdown').classList.toggle('show');
        }

        window.addEventListener('DOMContentLoaded', () => {
            // Optional: Show the loader when the page is loading
            const loader = document.getElementById('loader');
            loader.classList.add('show');

            // Hide loader after page load
            setTimeout(() => {
                loader.classList.remove('show');
            }, 500); // Adjust time as needed

            // Ensure sidebar is not covered by header on page load
            if (!sidebar.classList.contains('sidebar-hidden')) {
                header.style.left = '240px';
                header.style.width = 'calc(100% - 240px)';
                mainContent.style.paddingLeft = '240px';
            }

            // Check if "remember me" is checked and set the email value
            const rememberMeCheckbox = document.getElementById('remember_me');
            const emailInput = document.getElementById('email');
            if (rememberMeCheckbox && emailInput) {
                const rememberedEmail = localStorage.getItem('rememberedEmail');
                if (rememberedEmail) {
                    emailInput.value = rememberedEmail;
                    rememberMeCheckbox.checked = true;
                }

                rememberMeCheckbox.addEventListener('change', () => {
                    if (rememberMeCheckbox.checked) {
                        localStorage.setItem('rememberedEmail', emailInput.value);
                    } else {
                        localStorage.removeItem('rememberedEmail');
                    }
                });

                emailInput.addEventListener('input', () => {
                    if (rememberMeCheckbox.checked) {
                        localStorage.setItem('rememberedEmail', emailInput.value);
                    }
                });
            }
        });
    </script>
</body>

</html>
