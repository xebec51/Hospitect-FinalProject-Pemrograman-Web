<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Pasien</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    @vite('resources/css/app.css')
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .register-container {
            background-image: url('{{ asset('images/images.jpg') }}');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-container .max-w-md {
            max-width: 400px;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="max-w-md w-full bg-white p-8 rounded shadow-lg">
            <h2 class="text-3xl font-bold mb-6 text-center text-blue-600">Registrasi Pasien</h2>

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
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-600">
                    @error('name')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-600">
                    @error('email')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Password</label>
                    <input id="password" type="password" name="password" required class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-600">
                    @error('password')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-gray-700">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>

                <div class="flex justify-between items-center">
                    <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">Sudah punya akun? Login</a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Daftar</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
