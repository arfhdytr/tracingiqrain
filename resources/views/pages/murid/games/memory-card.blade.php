<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Memory Card Game</title>

    <script>
        var ASSET_BASE = "{{ asset('') }}";
        var JENIS_GAME_ID = {{ $jenisGame->jenis_game_id }};
        var POIN_MAKSIMAL = {{ $jenisGame->poin_maksimal ?? 100 }};
        var SESSION_ID = {{ $sessionGame->hasil_game_id }};    
    </script>

    @vite(['resources/css/app.css', 'resources/js/memory-card.js'])
</head>

<body>
    {{-- Main --}}
    <div class="font-sans text-center min-h-screen flex flex-col bg-gradient-to-b from-[#56B1F3] to-[#D3F2FF]">
        {{-- Tombol Kembali --}}
        <div class="p-4">
            <a href="{{ route('murid.games.index', $tingkatan->tingkatan_id) }}"
                class="relative flex items-center justify-center w-[140px] h-[45px] rounded-full bg-pink-400 shadow-md transition-transform hover:scale-105">
                {{-- icon < --}} <div class="absolute left-4 flex items-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="3"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                    </svg>
        </div>
        <span class="font-['TegakBersambung'] text-white text-[25px] font-normal leading-none pt-2 pl-4">
            Kembali
        </span>
        </a>
    </div>

    {{-- Balon kiri --}}
    <div class="fixed left-4 top-1/3 w-40 md:w-50 h-auto animate-bounce-slow z-10 pointer-events-none">
        <img src="{{ asset('images/icon/balon.webp') }}" alt="Balon Kiri" class="w-full h-auto drop-shadow-lg">
    </div>

    {{-- Letak Game utama nya --}}
    <main class="relative z-20 flex-grow flex flex-col items-center pt-8">
        <div class="flex justify-between items-center w-full max-w-[420px] mb-5 px-3">
            <div class="flex items-center gap-2.5">
                <span class="font-['TegakBersambung'] text-3xl font-bold text-[#ffffff]">Poin :</span>
                <div
                    class="bg-gradient-to-br from-[#E897BA] to-[#D084A8] text-white px-7 py-2 rounded-full text-xl font-bold shadow-md">
                    <span id="poin-benar">0</span>
                </div>
            </div>
            <div class="text-2xl font-bold text-[#ffffff]">
                <span id="current-matches">0</span>/6
            </div>
            <button id="reset-button"
                class="font-['TegakBersambung'] bg-white text-[#D084A8] border-2 border-[#D084A8] px-5 py-2 rounded-full text-2xl font-bold cursor-pointer shadow-sm transition-all duration-300 hover:bg-[#D084A8] hover:text-white">
                ↻ Restart
            </button>
        </div>

        <div id="board"
            class="w-fit mx-auto grid grid-cols-4 gap-3 p-5 bg-white border-[12px] border-pink-200 rounded-3xl shadow-2xl">
        </div>

    </main>

    {{-- Balon kanan --}}
    <div class="fixed right-4 top-1/4 w-40 md:w-50 h-auto animate-bounce-slow z-10 pointer-events-none">
        <img src="{{ asset('images/icon/balon.webp') }}" alt="Balon Kanan"
            class="w-full h-auto drop-shadow-lg transform scale-x-[-1]">
    </div>

    {{-- Ucapan selamat bermain --}}
    <div id="welcome-backdrop" class="fixed inset-0 z-40 transition-all duration-1000 opacity-0"
        style="background: linear-gradient(135deg, rgba(255, 255, 255, 0.5) 0%, rgba(214, 93, 177, 0.3) 100%); backdrop-filter: blur(8px);">
    </div>

    <div id="welcome-message-container"
        class="fixed inset-0 z-50 flex items-center justify-center opacity-0 transition-all duration-1000 pointer-events-none">
        <h1 id="welcome-message"
            class="font-['TegakBersambung'] text-7xl md:text-8xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-pink-400 via-pink-500 to-pink-600 transform scale-75 transition-all duration-1000 p-4 leading-normal"
            style="text-shadow: 0 8px 24px rgba(236, 72, 153, 0.6), 0 0 40px rgba(236, 72, 153, 0.4);">
            Selamat Bermain
        </h1>
    </div>
    </div>

    {{-- POP UP SELESAI BERMAIN --}}
    <div id="success-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <div class="absolute inset-0 transition-opacity duration-300" style="background-color: rgba(0, 0, 0, 0.6);">
        </div>

        <div
            class="relative bg-white rounded-3xl p-8 max-w-sm w-full mx-4 shadow-2xl transform  scale-90 transition-transform duration-300 border-4 border-pink-300 text-center">
            <div class=" mb-4 animate-bounce">
                <img src="{{ asset('images/icon/piala.webp') }}" alt="Piala" class="w-24 h-auto mx-auto">
            </div>

            <h2 class="font-['TegakBersambung'] text-4xl text-pink-500 font-bold mb-2">
                Luar Biasa!
            </h2>

            <p class="font-['TegakBersambung'] text-gray-600 mb-6 text-lg">
                Kamu berhasil menyelesaikan permainan!
            </p>

            <div class="bg-pink-50 rounded-xl p-4 mb-6 border border-pink-100">
                <p class="text-gray-500 text-sm font-bold uppercase">Total Poin</p>
                <p class="text-4xl font-bold text-pink-600" id="modal-score">0</p>
            </div>

            <div class="flex flex-col gap-3">
                <button onclick="restartGame()"
                    class="w-full py-3 bg-gradient-to-r from-pink-400 to-pink-500 text-white rounded-xl font-bold text-xl shadow-lg hover:scale-105 transition-transform font-['TegakBersambung']">
                    Main Lagi ↻
                </button>

                <a href="{{ route('murid.games.index', $tingkatan->tingkatan_id) }}"
                    class="w-full py-3 bg-white border-2 border-gray-200 text-gray-500 rounded-xl font-bold text-lg hover:bg-gray-50 transition-colors font-['TegakBersambung']">
                    Kembali ke Menu
                </a>
            </div>
        </div>
    </div>
</body>

</html>