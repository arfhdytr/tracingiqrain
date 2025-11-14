<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - IQRAIN</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-400 to-blue-600 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-5xl flex bg-white rounded-3xl shadow-2xl overflow-hidden">
        <!-- Left Side - Mascot -->
        <div class="hidden md:flex md:w-1/2 bg-gradient-to-br from-blue-100 to-white items-center justify-center p-12 relative">
            <div class="absolute top-0 left-0 w-full h-full opacity-10">
                <!-- Decorative pattern -->
                <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                    <pattern id="pattern" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
                        <circle cx="25" cy="25" r="20" fill="#FF69B4" opacity="0.3"/>
                        <rect x="60" y="10" width="30" height="30" fill="#FFD700" opacity="0.3" rx="5"/>
                        <path d="M 10 70 Q 30 50, 50 70" stroke="#87CEEB" stroke-width="4" fill="none" opacity="0.3"/>
                    </pattern>
                    <rect width="100%" height="100%" fill="url(#pattern)"/>
                </svg>
            </div>
            <div class="relative z-10 text-center">
                <img src="{{ asset('images/qira-mascot.webp') }}" alt="Qira Mascot" class="w-64 h-auto mx-auto mb-4">
                <h2 class="text-2xl font-bold text-gray-800">Belajar Bersama Qira!</h2>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full md:w-1/2 p-12">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-blue-600 mb-2">Selamat Datang!</h1>
                <div class="flex justify-center space-x-2 mb-4">
                    <span class="text-3xl">🐘</span>
                    <span class="text-3xl">📚</span>
                    <span class="text-3xl">✨</span>
                </div>
            </div>

            <!-- Error Messages -->
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Username -->
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                        Username
                    </label>
                    <input 
                        id="username" 
                        type="text" 
                        name="username" 
                        value="{{ old('username') }}"
                        required 
                        autofocus
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="Masukkan username"
                    >
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="Masukkan password"
                    >
                </div>

                <!-- Forgot Password Link -->
                <div class="text-right">
                    <a href="{{ route('password.murid.request') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Lupa password?
                    </a>
                </div>

                <!-- Login Button -->
                <button 
                    type="submit"
                    class="w-full bg-gradient-to-r from-pink-400 to-pink-500 hover:from-pink-500 hover:to-pink-600 text-white font-bold py-3 px-4 rounded-lg transition duration-300 transform hover:scale-105 shadow-lg"
                >
                    Login
                </button>
            </form>

            <!-- Register Links -->
            <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                <p class="text-gray-600 mb-3">Belum punya akun? 
                    <a href="{{ route('register.murid') }}" class="text-blue-600 hover:text-blue-800 font-medium">Daftar di sini</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>