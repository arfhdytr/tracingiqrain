<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Memory Card Game</title>

    <script>
        var ASSET_BASE = "{{ asset('') }}";    
        var GAME_STATIC_ID = {{ $gameStatic->game_static_id }};
        var JENIS_GAME_ID = {{ $gameStatic->jenis_game_id }};
        var POIN_MAKSIMAL = {{ $gameStatic->jenisGame->poin_maksimal ?? 100 }};
    </script> 

    @vite(['resources/css/app.css', 'resources/js/memory-card.js'])       

    <style>
        @font-face {
            font-family: 'TegakBersambung';            
            src: url("{{ asset('fonts/TegakBersambung_IWK.ttf') }}") format('truetype');
            font-weight: normal;
            font-style: normal;
        }
    </style>
    
</head>

<body class="font-sans text-center min-h-screen flex flex-col">
    <div class="p-4">
            {{-- Tombol Kembali --}}
            <a href="{{ route('murid.games.index', $tingkatan->tingkatan_id) }}"
                class="relative flex items-center justify-center w-[140px] h-[45px] rounded-full bg-[#FEFFD0] shadow-md transition-transform hover:scale-105">
                
                {{-- Ikon: Tetap di posisi kiri (absolute) --}}
                <div class="absolute left-4 flex items-center">
                    <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </div>

                {{-- Teks: Ditambah pl-4 agar geser ke kanan sedikit --}}
                <span class="font-['TegakBersambung'] text-gray-800 text-[25px] font-normal leading-none pt-2 pl-4">
                    Kembali
                </span>
            </a>
        </div>
    
    <main class="relative z-20 flex-grow flex flex-col items-center pt-8 
                 bg-gradient-to-br from-[#FFF9E6] to-[#F5E6D3]">
        
        <div class="flex justify-between items-center w-full max-w-[420px] mb-5 px-3">
            <div class="flex items-center gap-2.5">
                <span class="font-['TegakBersambung'] text-2xl font-bold text-[#D084A8]">Poin :</span>
                <div class="bg-gradient-to-br from-[#E897BA] to-[#D084A8] text-white px-7 py-2 rounded-full text-xl font-bold shadow-md">
                    <span id="poin-benar">0</span>
                </div>
            </div>
            <div class="text-xl font-bold text-[#D084A8]">
                <span id="current-matches">0</span>/6
            </div>
            <button
                id="reset-button"
                class="font-['TegakBersambung'] bg-white text-[#D084A8] border-2 border-[#D084A8] px-5 py-2 rounded-full text-base font-bold cursor-pointer shadow-sm transition-all duration-300 hover:bg-[#D084A8] hover:text-white"
            >
                ↻ Main lagi
            </button>
        </div>

        <div id="board" class="w-fit mx-auto grid grid-cols-4 gap-3 p-5 bg-white border-[12px] border-gray-200 rounded-3xl shadow-2xl">
        </div>

    </main>

<footer class="relative w-full h-20 mt-1 z-50 overflow-hidden">
    <img 
        src="{{ asset('images/asset/flowers.svg') }}" 
        alt="Bunga-bunga" 
        class="absolute -bottom-12 left-0 w-full z-10 pointer-events-none"
    />
</footer>

    <div id="welcome-backdrop" class="fixed inset-0 z-40 transition-opacity duration-1000" style="background-color: rgba(0, 0, 0, 0.6);"></div>
    <h1 id="welcome-message" class="font-['TegakBersambung'] fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-50 
                                   font-sans text-7xl md:text-8xl font-bold text-white 
                                   opacity-0 transition-opacity duration-1000 ease-out"
                                   style="text-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);">
        Selamat Datang!
    </h1> 
    
</body>
</html>