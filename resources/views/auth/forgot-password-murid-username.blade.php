<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - IQRAIN</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Fredoka', sans-serif;
            background-color: #ffffff;
            position: relative;
        }


        .pattern-bg {
            position: fixed;
            inset: 0;
            background-image: url('images/pattern/pattern1.webp');
            background-size: 1000px;
            background-repeat: repeat;
            opacity: 0.5;
            pointer-events: none;
            z-index: 1;
        }

        .forgot-card-single {
            background: #56B1F3;
            border-radius: 1.5rem;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 10;
        }

        .btn-lanjut {
            background-color: #FF87AB;
            transition: all 0.2s ease-in-out;
            font-weight: 700;
        }

        .btn-lanjut:hover {
            background-color: #E85A8B;
            transform: translateY(-2px);
        }

        .alert-pink {
            background-color: #F7A0B3;
            color: #3d3d3d;
            border-radius: 0.75rem;
            padding: 1rem;
            border: 1px solid #f08097;
        }

        /* Menambahkan border merah untuk fokus/error */
        .input-error {
            border: 2px solid #ef4444 !important;
            /* Tailwind red-500 */
        }

        input:focus {
            outline: none;
            border-color: #5CB8E6;
            box-shadow: 0 0 0 2px #5CB8E6;
            /* Menggunakan box-shadow untuk fokus yang lebih menonjol */
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4 relative">

    <div class="pattern-bg"></div>

    <div class="w-full max-w-md relative z-20">

        <div class="forgot-card-single p-8 sm:p-10">

            <h2 class="text-3xl font-bold text-white text-center mb-6">
                Lupa Password
            </h2>

            <div class="alert-pink flex items-start mb-6">
                <svg class="w-6 h-6 mr-3 mt-0.5 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                        clip-rule="evenodd"></path>
                </svg>
                <p class="text-sm font-medium">
                    Masukkan username kamu untuk memulai proses pemulihan password.
                </p>
            </div>

            {{-- Menampilkan error non-spesifik (seperti 'Username tidak ditemukan') dan status --}}
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('status'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->has('throttle'))
                <div id="throttleWarning"
                    class="mb-4 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 rounded-lg flex items-start">
                    <svg class="w-6 h-6 mr-3 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    <div class="flex-1">
                        <p class="font-bold text-lg">Terlalu Banyak Percobaan!</p>
                        {{-- <p class="text-sm mt-1">{{ $errors->first('throttle') }}</p> --}}
                        <p class="text-sm mt-2">
                            Silakan tunggu <span id="countdown"
                                class="text-xl text-red-600">{{ session('retry_after', 60) }}</span> detik lagi.
                        </p>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('password.check') }}" class="space-y-6" id="forgotPasswordForm">
                @csrf
                <div>
                    <label for="username" class="block text-base font-bold text-gray-700 mb-2">
                        Username
                    </label>
                    <input id="username" type="text" name="username" value="{{ old('username') }}" required
                        autofocus
                        class="w-full px-5 py-3 border-0 rounded-xl text-gray-800 text-md {{ $errors->has('username') ? 'input-error' : '' }}"
                        style="background-color: white;">
                    {{-- Pesan Error Validasi Spesifik untuk Username --}}
                    @error('username')
                        <p class="text-red-600 text-sm mt-2 font-semibold">
                            ⚠️ {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="pt-4">
                    <button type="submit" id="submitButton"
                        class="w-full btn-lanjut text-white font-bold py-3 px-10 rounded-xl shadow-lg text-lg">
                        Lanjutkan
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('login') }}"
                    class="text-gray-700 hover:text-iqrain-dark-blue text-sm font-bold underline">
                    ← Kembali ke Login
                </a>
            </div>

        </div>
    </div>

    @if ($errors->has('throttle') && session('retry_after'))
        <script>
            // Countdown timer untuk throttle
            let retryAfter = {{ session('retry_after', 60) }};
            const countdownElement = document.getElementById('countdown');
            const form = document.getElementById('forgotPasswordForm');
            const submitBtn = document.getElementById('submitButton');
            const usernameInput = document.getElementById('username');

            // Disable form immediately
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            submitBtn.textContent = 'Tunggu...';
            usernameInput.disabled = true;

            // Prevent form submission
            form.addEventListener('submit', function(e) {
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
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    submitBtn.textContent = 'Lanjutkan';
                    usernameInput.disabled = false;

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
