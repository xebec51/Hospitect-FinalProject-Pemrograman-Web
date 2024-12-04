<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Hospitect</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    @vite('resources/css/app.css')
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .login-container {
            background-image: url('{{ asset('images/images.jpg') }}');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container .max-w-md {
            max-width: 400px;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="max-w-md w-full bg-white p-8 rounded shadow-lg">
            <h2 class="text-3xl font-bold mb-6 text-center text-blue-600">Login to Hospitect</h2>

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

                <div class="mb-4 flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="mr-2">
                        <span class="text-sm text-gray-600">Remember me</span>
                    </label>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Log in</button>
                </div>
            </form>

            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Register here</a>.
                </p>
            </div>
        </div>
    </div>
</body>

</html>
