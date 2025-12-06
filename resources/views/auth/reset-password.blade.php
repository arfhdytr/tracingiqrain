<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - IQRAIN</title>

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
            background-color: #56B1F3; /* Biru Solid */
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

        /* Style untuk Error */
        .alert-pink {
            background-color: #FFE4E6; 
            color: #9F1239; 
            border-radius: 0.75rem;
            padding: 1rem;
            border: 1px solid #FDA4AF;
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
                <div class="w-20 h-20 bg-white/20 rounded-full mx-auto flex items-center justify-center mb-4 shadow-sm backdrop-blur-sm">
                    <svg class="w-10 h-10 text-white drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>

                <h1 class="text-3xl font-bold text-white mb-1 drop-shadow-sm">Password Baru</h1>
                <p class="text-white/90 text-md font-medium">Silakan masukkan password baru untuk akun Anda.</p>
            </div>

            {{-- Menampilkan Error Validasi (Misal: Password tidak cocok) --}}
            @if ($errors->any())
                <div class="alert-pink mb-6 shadow-sm">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 flex-shrink-0 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-sm">
                            <span class="font-bold block mb-1">Periksa Inputan</span>
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                @csrf

                {{-- Token Wajib (Hidden) --}}
                <input type="hidden" name="token" value="{{ request()->route('token') }}">

                {{-- Input Email (Readonly agar user yakin ini akun dia) --}}
                <div>
                    <label for="email" class="block text-base font-bold text-gray-800 mb-2 ml-1">Email</label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email', request()->email) }}" 
                        required 
                        readonly
                        class="w-full px-5 py-3 border-2 border-transparent rounded-xl text-gray-500 bg-gray-100 text-md shadow-sm cursor-not-allowed"
                    >
                </div>

                {{-- Input Password Baru --}}
                <div>
                    <label for="password" class="block text-base font-bold text-gray-800 mb-2 ml-1">Password Baru (Min: 8 Karakter)</label>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        required 
                        autofocus
                        autocomplete="new-password"
                        class="w-full px-5 py-3 border-2 border-transparent focus:border-blue-300 rounded-xl text-gray-600 text-md shadow-sm transition-all bg-white font-['Verdana'] tracking-widest"
                    >
                </div>

                {{-- Input Konfirmasi Password --}}
                <div>
                    <label for="password_confirmation" class="block text-base font-bold text-gray-800 mb-2 ml-1">Ulangi Password</label>
                    <input 
                        id="password_confirmation" 
                        type="password" 
                        name="password_confirmation" 
                        required 
                        autocomplete="new-password"
                        class="w-full px-5 py-3 border-2 border-transparent focus:border-blue-300 rounded-xl text-gray-600 text-md shadow-sm transition-all bg-white font-['Verdana'] tracking-widest"
                    >
                </div>

                <div class="pt-2">
                    <button 
                        type="submit"
                        class="w-full btn-submit text-white font-bold py-3.5 px-10 rounded-xl shadow-lg text-lg tracking-wide">
                        Simpan Password Baru
                    </button>
                </div>

            </form>

        </div>

    </div>

</body>
</html>