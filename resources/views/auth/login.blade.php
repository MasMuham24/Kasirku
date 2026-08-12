<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name', 'Kasirku') }}</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="bg-gray-100 text-gray-900 antialiased min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-sm">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Kasirku</h1>
            <p class="text-sm text-gray-500 mt-1">Masuk untuk mengelola penjualan Anda</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                           required autofocus autocomplete="email">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" id="password"
                           class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                           required autocomplete="current-password">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5 flex items-center justify-between">
                    <label for="remember" class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" name="remember" id="remember"
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        Ingat saya
                    </label>
                </div>

                <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg transition">
                    Masuk
                </button>
            </form>
        </div>
    </div>
</body>
</html>
