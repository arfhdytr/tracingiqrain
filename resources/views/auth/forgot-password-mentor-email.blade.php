<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - IQRAIN</title>

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
            background-image: url('/images/pattern/pattern1.webp');
            background-size: 1000px;
            background-repeat: repeat;
            opacity: 0.5;
            pointer-events: none;
            z-index: 1;
        }

        .forgot-card-single {
            background-color: #56B1F3;
            border-radius: 1.5rem;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 10;
        }

        .btn-submit {
            background-color: #FF87AB;
            transition: all 0.2s ease-in-out;
            font-weight: 700;
        }

        .btn-submit:hover {
            background-color: #E85A8B;
            transform: translateY(-2px);
        }

        /* Style untuk Error (Merah/Pink) */
        .alert-pink {
            background-color: #FFE4E6;
            color: #9F1239;
            border-radius: 0.75rem;
            padding: 1rem;
            border: 1px solid #FDA4AF;
        }

        /* Style untuk Sukses (Hijau) */
        .alert-success {
            background-color: #D1FAE5;
            color: #065F46;
            border-radius: 0.75rem;
            padding: 1rem;
            border: 1px solid #34D399;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        input:focus {
            outline: none;
            border-color: #5CB8E6;
            ring: 2px solid #5CB8E6;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4 relative">

    <div class="pattern-bg"></div>

    <div class="w-full max-w-md relative z-20">

        <div class="forgot-card-single p-8 sm:p-10">

            <div class="text-center mb-6">
                <div
                    class="w-20 h-20 bg-white/20 rounded-full mx-auto flex items-center justify-center mb-4 shadow-sm backdrop-blur-sm">
                    <svg class="w-10 h-10 text-white drop-shadow-md" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>

                <h1 class="text-3xl font-bold text-white mb-1 drop-shadow-sm">Verifikasi Email</h1>
                <p class="text-white/90 text-sm font-medium">Masukkan alamat email yang terdaftar sebagai Mentor.</p>
            </div>

            {{-- BAGIAN SUKSES (HIJAU) --}}
            @if (session('status'))
                <div class="alert-success mb-6 shadow-sm">
                    <svg class="w-6 h-6 flex-shrink-0 text-green-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <span class="font-bold block text-green-800">Email Terkirim!</span>
                        <p class="text-sm leading-tight mt-1">{{ session('status') }}</p>
                    </div>
                </div>
            @endif

            {{-- BAGIAN ERROR (PINK) --}}
            @if ($errors->any() || session('error'))
                <div class="alert-pink mb-6 shadow-sm">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 flex-shrink-0 text-red-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-sm">
                            @if (session('error'))
                                <span class="font-bold block mb-1">Terjadi Kesalahan</span>
                                {{ session('error') }}
                            @else
                                <span class="font-bold block mb-1">Periksa Inputan</span>
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @if ($errors->has('throttle'))
                <div id="throttleWarning"
                    class="mb-6 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 rounded-lg flex items-start shadow-sm">
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
                                class="text-xl text-red-600">{{ session('retry_after', 300) }}</span> detik lagi.
                        </p>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('password.mentor.send') }}" class="space-y-6"
                id="emailVerificationForm">
                @csrf

                <div>
                    <label for="email" class="block text-base font-bold text-gray-800 mb-2 ml-1">
                        Email Mentor
                    </label>

                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-5 py-3 border-2 border-transparent focus:border-blue-300 rounded-xl text-gray-800 text-md shadow-sm transition-all"
                        style="background-color: white;" placeholder="Contoh: mentor@gmail.com">
                </div>

                <button type="submit" id="submitButton"
                    class="w-full btn-submit text-white font-bold py-3.5 px-10 rounded-xl shadow-lg text-lg tracking-wide">
                    Kirim Link Reset
                </button>

            </form>

            <div class="mt-8 text-center">
                <a href="{{ route('password.request') }}"
                    class="text-white/90 hover:text-white text-sm font-bold underline decoration-2 underline-offset-4 transition-colors">
                    ← Kembali ke Pengecekan Username
                </a>
            </div>

        </div>

    </div>

    @if ($errors->has('throttle') && session('retry_after'))
        <script>
            // Countdown timer untuk throttle email verification
            let retryAfter = {{ session('retry_after', 300) }};
            const countdownElement = document.getElementById('countdown');
            const form = document.getElementById('emailVerificationForm');
            const submitBtn = document.getElementById('submitButton');
            const emailInput = document.getElementById('email');

            // Disable form immediately
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            submitBtn.textContent = 'Tunggu...';
            emailInput.disabled = true;

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
                    const minutes = Math.floor(retryAfter / 60);
                    const seconds = retryAfter % 60;
                    countdownElement.textContent = minutes > 0 ?
                        `${minutes} menit ${seconds} detik` :
                        `${seconds} detik`;
                }

                if (retryAfter <= 0) {
                    clearInterval(timer);
                    // Enable form
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    submitBtn.textContent = 'Kirim Link Reset';
                    emailInput.disabled = false;

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
