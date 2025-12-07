<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Berhasil - IQRAIN</title>
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

    <div class="max-w-7xl mx-auto py-10 px-6 relative min-h-screen flex items-center">

        <div class="lg:w-[calc(100%-500px)] lg:pr-10 text-center lg:text-left">
            
            <div class="flex items-center mb-6 space-x-3 justify-center lg:justify-start">
                <div class="w-3 h-3 rounded-full bg-white opacity-60"></div>
                <div class="w-3 h-3 rounded-full bg-white opacity-60"></div>
                <div class="w-8 h-8 rounded-full bg-yellow-400 text-white flex items-center justify-center font-bold">3</div>
            </div>

            <div class="mb-6">
                <h1 class="text-5xl lg:text-6xl font-fredoka font-bold text-white mb-2"
                    style="text-shadow: 2px 2px 4px rgba(0,0,0,0.1);">
                    Selamat!
                </h1>
                <p class="font-fredoka text-2xl text-white mb-4">
                    Akun kamu sudah siap digunakan!
                </p>
            </div>

            <a href="{{ route('auto.login') }}"
               class="inline-block bg-pink-400 text-white font-fredoka font-bold py-3 px-8 rounded-xl shadow-lg hover:bg-pink-500 transition">
                Yuk Mulai Belajar!
            </a>
            
        </div>

    </div>

    <div class="absolute top-0 right-0 w-[500px] h-full hidden lg:block overflow-hidden z-0">
        <img src="{{ asset('images/pattern/wafe-regist.webp') }}" 
            class="h-full w-full object-fill"
            alt="Pattern Gelombang Registrasi"
            style="width: 700px; position: absolute; left: 0px;">
        <img src="{{ asset('images/maskot/mengaji.webp') }}" 
            class="absolute bottom-0 right-0 w-[500px]"
            alt="Maskot Ceria">
    </div>

</body>
</html>