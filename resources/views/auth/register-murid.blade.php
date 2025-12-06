<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun Baru - IQRAIN</title>
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

    <div class="max-w-7xl mx-auto py-20 px-6 relative">

        <div class="lg:w-[calc(100%-300px)] lg:pr-10">
            
            <h1 class="text-5xl lg:text-5xl font-fredoka font-bold text-white mb-6"
                style="text-shadow: 2px 2px 4px rgba(0,0,0,0.1);">
                Buat Akun Baru
            </h1>

            <div class="inline-flex rounded-full border-2 border-white p-1 bg-white mb-6">
                <a href="{{ route('register.murid') }}" 
                    class="px-10 py-2 rounded-full bg-pink-400 text-white font-fredoka font-semibold text-lg">
                    Murid
                </a>
                <a href="{{ route('register.mentor') }}" 
                    class="px-10 py-2 rounded-full text-gray-600 font-fredoka font-semibold text-lg">
                    Mentor
                </a>
            </div>

            <div class="flex items-center mb-6 space-x-3">
                <div class="w-8 h-8 rounded-full bg-yellow-400 text-white flex items-center justify-center font-bold">1</div>
                <div class="w-3 h-3 rounded-full bg-white opacity-60"></div>
                <div class="w-3 h-3 rounded-full bg-white opacity-60"></div>
            </div>

            <form method="POST" action="{{ route('register.murid.post') }}">
                @csrf
                <input type="hidden" name="step" value="1">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6"> 
                
                    <div>
                        <label class="text-lg text-white font-fredoka font-semibold block mb-2">Username</label>
                        <input type="text"
                            name="username"
                            value="{{ old('username') }}"
                            required
                            class="w-full px-4 py-3 rounded-xl border-2 {{ $errors->has('username') ? 'border-red-500' : 'border-white' }} bg-white text-gray-800 focus:ring-2 focus:ring-yellow-300"
                            placeholder="Masukkan username">
                        {{-- Pesan Error untuk Username --}}
                        @error('username')
                            <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        {{-- Tambahkan petunjuk jika perlu, misal: <p class="text-white text-sm mt-1 opacity-80">Minimal 4 karakter, hanya boleh huruf dan angka.</p> --}}
                    </div>

                    <div>
                        <label class="text-lg text-white font-fredoka font-semibold block mb-2">Sekolah</label>
                        <input type="text"
                            name="sekolah"
                            value="{{ old('sekolah') }}"
                            class="w-full px-4 py-3 rounded-xl border-2 border-white bg-white text-gray-800 focus:ring-2 focus:ring-yellow-300"
                            placeholder="Nama sekolah">
                        {{-- Sekolah tidak memiliki @error karena dianggap opsional atau validasi sederhana --}}
                    </div>

                    <div>
                        <label class="text-lg text-white font-fredoka font-semibold block mb-2">Password</label>
                        <input type="password"
                            name="password"
                            required
                            class="w-full px-4 py-3 rounded-xl border-2 {{ $errors->has('password') ? 'border-red-500' : 'border-white' }} bg-white text-gray-800 focus:ring-2 focus:ring-yellow-300 font-['Verdana']"
                        {{-- Pesan Error untuk Password --}}
                        @error('password')
                            <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="text-lg text-white font-fredoka font-semibold block mb-2">Konfirmasi Password</label>
                        <input type="password"
                            name="password_confirmation"
                            required
                            class="w-full px-4 py-3 rounded-xl border-2 {{ $errors->has('password_confirmation') ? 'border-red-500' : 'border-white' }} bg-white text-gray-800 focus:ring-2 focus:ring-yellow-300"
                            placeholder="Ketik ulang password">
                        {{-- Pesan Error untuk Konfirmasi Password --}}
                        @error('password_confirmation')
                            <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="mt-6">
                    <button type="submit"
                    class="bg-pink-400 font-fredoka text-white text-lg font-bold py-3 px-10 rounded-xl shadow-lg hover:bg-pink-500 transition">
                        Lanjut
                    </button>
                </div>
            </form>

            <div class="border-t border-white mt-10 pt-4">
                <p class="text-base font-fredoka text-white">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-yellow-400">Login di sini</a>
                </p>
            </div>
        </div>

    </div>

    <div class="absolute top-0 right-0 w-[500px] h-full hidden lg:block overflow-hidden">
        <img src="{{ asset('images/pattern/wafe-regist.webp') }}" 
            class="h-full object-fill"
            style="width: 700px; position: absolute; left: 0px;">
        <img src="{{ asset('images/maskot/ceria.webp') }}" class="absolute bottom-0 right-0 w-[450px]">
    </div>

</body>
</html>