<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - IQRAIN</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Font Mooli & Fredoka */
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

<body class="min-h-screen bg-[var(--color-iqrain-blue)]">

    <div class="max-w-7xl mx-auto py-20 px-6 relative">
        <div class="lg:w-[calc(100%-500px)] lg:pr-10">


        <div class="flex items-center justify-center mb-8 space-x-3">
            <div class="w-3 h-3 rounded-full bg-white opacity-60"></div>
            <div class="w-3 h-3 rounded-full bg-white opacity-60"></div>
            <div class="w-8 h-8 rounded-full bg-yellow-400 text-white flex items-center justify-center font-bold">3</div>
        </div>

        <div class="bg-white rounded-2xl p-8 shadow-lg border-2 border-white text-center">

            <div class="mb-6">
                <svg class="w-24 h-24 mx-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <h2 class="text-3xl font-fredoka text-pink-600 font-bold mb-4">
                Yeay! Semua Sudah Siap!
            </h2>

            <p class="font-fredoka text-gray-700 text-lg mb-6">
                Sekarang kamu bisa mulai belajar dan bermain bersama IQRAIN
            </p>

            <a href="{{ route('murid.pilih-iqra') }}"
                class="inline-block bg-pink-400 text-white font-fredoka font-bold py-4 px-12 rounded-xl shadow-lg
                        hover:bg-pink-500 transition text-lg">
                Mulai Belajar
            </a>

        </div>

    </div>
</div>

    <div class="absolute top-0 right-0 w-[500px] h-full hidden lg:block overflow-hidden">
        <img src="{{ asset('images/pattern/wafe-regist.webp') }}"
            class="h-full object-fill"
            style="width: 700px; position: absolute; left: 0px;" alt="Background Pattern">
        <img src="{{ asset('images/maskot/ceria.webp') }}"
            class="absolute bottom-0 right-0 w-[450px]" alt="Maskot Ceria">
    </div>

</body>
</html>
