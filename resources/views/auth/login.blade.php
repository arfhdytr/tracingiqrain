<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO Meta Tags -->
    <x-seo-meta title="Login - IQRAIN"
        description="Login ke IQRAIN untuk melanjutkan pembelajaran huruf hijaiyah. Platform game edukatif interaktif untuk belajar mengaji."
        keywords="login iqrain, masuk iqrain, belajar hijaiyah online" :noindex="true" />

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
                        'iqrain-dark-blue': '#2C5F7D',
                        'iqrain-yellow': '#FFD166',
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

            0%,
            100% {
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
            <div class="absolute inset-0 bg-iqrain-blue"></div>

            <!-- Pattern (di atas) -->
            <div class="absolute inset-0 pattern-bg"></div>

            <!-- Mascot Image -->
            <div class="mascot-container flex items-center justify-center" style="z-index: 10;">
                <img src="images/maskot/ceria.webp" alt="Qira Mascot" class="w-80 h-auto object-contain mascot-bounce"
                    onerror="this.style.display='none'">
            </div>

        </div>



        <!-- Right Side - Login Form (Blue Background) -->
        <div class="w-full md:w-1/2 p-12 relative flex flex-col justify-center bg-iqrain-blue">
            <div class="text-left mb-8">
                <h1 class="text-5xl font-bold text-white" style="font-weight: 700;">
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

            @if ($errors->has('throttle'))
                <div id="throttleWarning"
                    class="mb-4 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 rounded-lg flex items-start">
                    <svg class="w-6 h-6 mr-3 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    <div class="flex-1">
                        <p class="font-semibold text-lg">Terlalu Banyak Percobaan Login!</p>
                        {{-- <p class="text-sm mt-1">{{ $errors->first('throttle') }}</p> --}}
                        <p class="text-sm mt-2">
                            Silakan tunggu <span id="countdown"
                                class="text-xl text-red-600">{{ session('retry_after', 60) }}</span> detik lagi.
                        </p>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6" id="loginForm">
                @csrf

                <!-- Username -->
                <div>
                    <label for="username" class="block text-lg font-semibold text-white mb-2">
                        Username
                    </label>
                    <input id="username" type="text" name="username" value="{{ old('username') }}" required
                        autofocus
                        class="w-full px-5 py-4 border-0 rounded-xl text-gray-800 text-lg @error('username') border-2 border-red-500 ring-2 ring-red-500 @enderror"
                        style="background-color: white;">
                    @error('username')
                        <p class="mt-2 text-sm font-semibold text-red-100">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-lg font-semibold text-white mb-2">
                        Password
                    </label>
                    <input id="password" type="password" name="password" required
                        class="w-full px-5 py-4 border-0 rounded-xl text-gray-800 text-lg font-['Verdana']"
                        style="background-color: white;">

                </div>

                <!-- Forgot Password & Login Button -->
                <div class="flex items-center justify-between pt-4">
                    <a href="{{ route('password.request') }}"
                        class="text-iqrain-yellow hover:text-yellow-400 text-base font-semibold underline">
                        Lupa password?
                    </a>

                    <button type="submit" id="loginButton"
                        class="btn-login text-white font-bold py-3 px-10 rounded-xl shadow-lg text-lg transition-all">
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
                    <a href="{{ route('register.murid') }}"
                        class="font-bold underline text-iqrain-yellow hover:text-yellow-400">
                        Daftar di sini
                    </a>
                </p>
            </div>
        </div>
    </div>

    @if ($errors->has('throttle') && session('retry_after'))
        <script>
            // Countdown timer untuk throttle
            let retryAfter = {{ session('retry_after', 60) }};
            const countdownElement = document.getElementById('countdown');
            const loginButton = document.getElementById('loginButton');
            const loginForm = document.getElementById('loginForm');
            const usernameInput = document.getElementById('username');
            const passwordInput = document.getElementById('password');

            // Disable form immediately
            loginButton.disabled = true;
            loginButton.classList.add('opacity-50', 'cursor-not-allowed');
            loginButton.textContent = 'Tunggu...';
            usernameInput.disabled = true;
            passwordInput.disabled = true;

            // Prevent form submission
            loginForm.addEventListener('submit', function(e) {
                if (retryAfter > 0) {
                    e.preventDefault();
                    return false;
                }
            });

            const timer = setInterval(function() {
                retryAfter--;
                if (countdownElement) {
                    countdownElement.textContent = retryAfter;
                }

                if (retryAfter <= 0) {
                    clearInterval(timer);
                    // Enable form
                    loginButton.disabled = false;
                    loginButton.classList.remove('opacity-50', 'cursor-not-allowed');
                    loginButton.textContent = 'Login';
                    usernameInput.disabled = false;
                    passwordInput.disabled = false;

                    // Hide throttle warning
                    const throttleWarning = document.getElementById('throttleWarning');
                    if (throttleWarning) {
                        throttleWarning.style.display = 'none';
                    }
                }
            }, 1000);
        </script>
    @endif

</body>

</html>
