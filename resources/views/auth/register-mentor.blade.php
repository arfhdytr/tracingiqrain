<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mentor - IQRAIN</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Menggunakan Font Mooli & Fredoka */
        @import url('https://fonts.googleapis.com/css2?family=Mooli&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&display=swap');
        
        /* Definisi Font Tegak Bersambung */
        @font-face {
            font-family: 'Tegak Bersambung_IWK';
            src: url("{{ asset('fonts/TegakBersambung_IWK.ttf') }}") format('truetype');
        }

        .font-fredoka { font-family: 'Fredoka', sans-serif; }
        .font-mooli { font-family: 'Mooli', sans-serif; }
        .font-cursive { font-family: 'Tegak Bersambung_IWK', cursive; }
    </style>
</head>

<body class="min-h-screen bg-[var(--color-iqrain-blue)] font-sans">

    <div class="max-w-7xl mx-auto py-10 px-6 relative">

        <div class="lg:w-[calc(100%-300px)] lg:pr-10">

            <h1 class="text-4xl lg:text-5xl font-fredoka font-bold text-white mb-4"
                style="text-shadow: 2px 2px 4px rgba(0,0,0,0.1);">
                Buat Akun Baru
            </h1>

            <div class="flex justify-center mb-4">
                <div class="inline-flex rounded-full border-2 border-white p-1 bg-white">
                    <a href="{{ route('register.murid') }}"
                        class="px-10 py-2 rounded-full text-gray-600 font-fredoka font-semibold text-lg">
                        Murid
                    </a>
                    <a href="{{ route('register.mentor') }}"
                        class="px-10 py-2 rounded-full bg-iqrain-pink text-white font-fredoka font-semibold text-lg">
                        Mentor
                    </a>
                </div>
            </div>

            {{-- **BAGIAN INI DIHAPUS** karena error akan ditampilkan per field.
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-600 text-red-700 rounded-xl">
                    <ul class="list-disc ml-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            --}}

            <form method="POST" action="{{ route('register.mentor.post') }}" id="registerMentorForm">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                    <div class="lg:col-span-2 flex items-center mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="text-white font-fredoka font-bold text-base">Data Diri</span>
                    </div>

                    <div>
                        <label for="username" class="text-base text-white font-fredoka font-semibold block mb-1">Username</label>
                        <input id="username" type="text" name="username" value="{{ old('username') }}" required
                            class="w-full px-3 py-2 rounded-xl border-2 {{ $errors->has('username') ? 'border-red-500' : 'border-white' }} bg-white text-gray-800 focus:ring-2 focus:ring-yellow-300"
                            placeholder="Pilih username unik">
                        @error('username')
                            <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nama_lengkap" class="text-base text-white font-fredoka font-semibold block mb-1">Nama Lengkap</label>
                        <input id="nama_lengkap" type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required autofocus
                            class="w-full px-3 py-2 rounded-xl border-2 {{ $errors->has('nama_lengkap') ? 'border-red-500' : 'border-white' }} bg-white text-gray-800 focus:ring-2 focus:ring-yellow-300"
                            placeholder="Masukkan nama lengkap">
                        @error('nama_lengkap')
                            <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="no_wa" class="text-base text-white font-fredoka font-semibold block mb-1">Nomor WhatsApp</label>
                        <input id="no_wa" type="tel" name="no_wa" value="{{ old('no_wa') }}" required
                            class="w-full px-3 py-2 rounded-xl border-2 {{ $errors->has('no_wa') ? 'border-red-500' : 'border-white' }} bg-white text-gray-800 focus:ring-2 focus:ring-yellow-300"
                            placeholder="08xxxxxxxxxx">
                        @error('no_wa')
                            <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="text-base text-white font-fredoka font-semibold block mb-1">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-3 py-2 rounded-xl border-2 {{ $errors->has('email') ? 'border-red-500' : 'border-white' }} bg-white text-gray-800 focus:ring-2 focus:ring-yellow-300"
                            placeholder="email@example.com">
                        @error('email')
                            <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs font-fredoka text-white opacity-75 mt-0.5">Untuk reset password dan notifikasi</p>
                    </div>

                    <div class="lg:col-span-2 flex items-center mt-2 mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span class="text-white font-fredoka font-bold text-base">Keamanan</span>
                    </div>

                    <div>
                        <label for="password" class="text-base text-white font-fredoka font-semibold block mb-1">Password</label>
                        <input id="password" type="password" name="password" required
                            class="w-full px-3 py-2 rounded-xl border-2 {{ $errors->has('password') ? 'border-red-500' : 'border-white' }} bg-white text-gray-800 focus:ring-2 focus:ring-yellow-300"
                            placeholder="Minimal 8 karakter">
                        @error('password')
                            <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs font-fredoka text-white opacity-75 mt-0.5">Password harus minimal 8 karakter.</p>
                    </div>

                    <div>
                        <label for="password_confirmation" class="text-base text-white font-fredoka font-semibold block mb-1">Konfirmasi Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="w-full px-3 py-2 rounded-xl border-2 {{ $errors->has('password_confirmation') ? 'border-red-500' : 'border-white' }} bg-white text-gray-800 focus:ring-2 focus:ring-yellow-300"
                            placeholder="Ketik ulang password">
                        @error('password_confirmation')
                            <p class="text-red-300 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs font-fredoka text-white opacity-75 mt-0.5">Pastikan password yang diketik sama.</p>
                    </div>

                </div>

                <div class="mt-4">
                    <button type="submit" id="submitBtnMentor"
                        class="bg-iqrain-pink font-fredoka text-white text-base font-bold py-2.5 px-8 rounded-xl shadow-lg hover:opacity-90 transition">
                        Ajukan Daftar
                    </button>
                </div>

            </form>

            <div class="border-t border-white mt-6 pt-3">
                <p class="text-base font-fredoka text-white">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-yellow-400">Login di sini</a>
                </p>
            </div>
        </div>

    </div>

    <script>
    // Mencegah double submission
    const form = document.getElementById('registerMentorForm');
    let isSubmitting = false;

    form.addEventListener('submit', function(e) {
        console.log('Form submit triggered');
        const submitBtn = document.getElementById('submitBtnMentor');

        // Jika sudah dalam proses submit, cegah submit lagi
        if (isSubmitting) {
            console.log('Already submitting, preventing duplicate submission');
            e.preventDefault();
            return false;
        }

        // Tandai bahwa sedang submit
        isSubmitting = true;
        console.log('Submitting form...');

        // Disable button setelah diklik
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        submitBtn.textContent = 'Memproses...';
    });
    </script>

    <div class="absolute top-0 right-0 w-[500px] h-full hidden lg:block overflow-hidden">
        <img src="{{ asset('images/pattern/wafe-regist.webp') }}"
            class="h-full object-fill"
            style="width: 700px; position: absolute; left: 0px;">
        <img src="{{ asset('images/maskot/ceria.webp') }}" class="absolute bottom-0 right-0 w-[450px]">
    </div>

</body>
</html>