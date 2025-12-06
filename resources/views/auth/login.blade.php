<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - IQRAIN</title>
    
    <!-- Import font Fredoka -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'iqrain-blue': '#5CB8E6',
                        'iqrain-pink': '#FF87AB',
                        'iqrain-dark-blue': '#2C5F7D'
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Fredoka', sans-serif;
        }

        /* Animasi Loncat */
        @keyframes bounceMascot {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-25px);
            }
        }

        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background-size: 500px;
            background-repeat: repeat;
            opacity: 0.4; 
            z-index: -1; 
        }


        .mascot-bounce {
            animation: bounceMascot 2s ease-in-out infinite;
        }

        /* Pattern background untuk sisi kiri */
        .pattern-bg {
            background-image: url('images/pattern/wafe-login.webp');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }


        /* Mascot positioning */
        .mascot-container {
            position: relative;
            z-index: 10;
        }

        /* Login button styling */
        .btn-login {
            background-color: #FF87AB;
            transition: all 0.2s ease-in-out;
        }
        .btn-login:hover {
            background-color: #E85A8B;
            transform: translateY(-2px);
        }

        /* Input focus style */
        input:focus {
            outline: none;
            border-color: #5CB8E6;
            ring: 2px;
            ring-color: #5CB8E6;
        }
    </style>
</head>
    <body class="min-h-screen flex items-center justify-center relative bg-[#afe4ffff]">
    
    <div class="w-full max-w-6xl flex rounded-3xl shadow-2xl overflow-hidden relative min-h-[600px]">

        <!-- Left Side -->
        <div class="hidden md:flex md:w-1/2 items-center justify-center relative">

            <!-- Solid Blue Background (di bawah) -->
            <div class="absolute inset-0 bg-[#5CB8E6]"></div>

            <!-- Pattern (di atas) -->
            <div class="absolute inset-0 pattern-bg"></div>

            <!-- Mascot Image -->
            <div class="mascot-container flex items-center justify-center" style="z-index: 10;">
                <img 
                    src="images/maskot/ceria.webp" 
                    alt="Qira Mascot" 
                    class="w-80 h-auto object-contain mascot-bounce"
                    onerror="this.style.display='none'"
                >
            </div>

        </div>



        <!-- Right Side - Login Form (Blue Background) -->
        <div class="w-full md:w-1/2 p-12 relative flex flex-col justify-center" style="background-color: #5CB8E6;">
            <div class="text-left mb-8">
                <h1 class="text-5xl font-bold text-white mb-8" style="font-weight: 700;">
                    Selamat Datang!
                </h1>
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

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
                <!-- Username -->
                <div>
                    <label for="username" class="block text-lg font-semibold text-white mb-2">
                        Username
                    </label>
                    <input 
                        id="username" 
                        type="text" 
                        name="username" 
                        value="{{ old('username') }}"
                        required 
                        autofocus
                        class="w-full px-5 py-4 border-0 rounded-xl text-gray-800 text-lg @error('username') border-2 border-red-500 ring-2 ring-red-500 @enderror"
                        style="background-color: white;"
                    >
                    @error('username')
                        <p class="mt-2 text-sm font-semibold text-red-100">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-lg font-semibold text-white mb-2">
                        Password
                    </label>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        required
                        class="w-full px-5 py-4 border-0 rounded-xl text-gray-800 text-lg font-['Verdana']"
                        style="background-color: white;"
                    >
                    
                </div>

                <!-- Forgot Password & Login Button -->
                <div class="flex items-center justify-between pt-4">
                    <a href="{{ route('password.request') }}" class="text-white hover:text-blue-900 text-base font-semibold underline">
                        Lupa password?
                    </a>
                    
                    <button 
                        type="submit"
                        class="btn-login text-white font-bold py-3 px-10 rounded-xl shadow-lg text-lg @error('password') border-2 border-red-500 ring-2 ring-red-500 @enderror"
                    >
                        Login
                    </button>
                </div>
            </form>

            <!-- Divider Line -->
            <div class="mt-8 mb-6 border-t border-white/30"></div>

            <!-- Register Link -->
            <div class="text-left">
                <p class="text-white text-base">
                    Belum punya akun? 
                    <a href="{{ route('register.murid') }}" class="font-bold underline hover:text-blue-900">
                        Daftar di sini
                    </a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>