<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memory Card Game</title>
    
    <script>
        var ASSET_BASE = "{{ asset('') }}"; 
    </script> 
    @vite(['resources/css/app.css', 'resources/js/memory-card.js'])       
</head>

<body class="font-sans text-center min-h-screen flex flex-col">
    
    <main class="relative z-20 flex-grow flex flex-col items-center pt-8 
                 bg-gradient-to-br from-[#FFF9E6] to-[#F5E6D3]">
        
        <div class="flex justify-between items-center w-full max-w-[420px] mb-5 px-3">
            <div class="flex items-center gap-2.5">
                <span class="text-2xl font-bold text-[#D084A8]">Poin :</span>
                <div class="bg-gradient-to-br from-[#E897BA] to-[#D084A8] text-white px-7 py-2 rounded-full text-xl font-bold shadow-md">
                    <span id="poin-benar">0</span>
                </div>
            </div>
            <div class="text-xl font-bold text-[#D084A8]">
                <span id="current-matches">0</span>/6
            </div>
            <button
                id="reset-button"
                class="bg-white text-[#D084A8] border-2 border-[#D084A8] px-5 py-2 rounded-full text-base font-bold cursor-pointer shadow-sm transition-all duration-300 hover:bg-[#D084A8] hover:text-white"
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
    <h1 id="welcome-message" class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-50 
                                   font-sans text-7xl md:text-8xl font-bold text-white 
                                   opacity-0 transition-opacity duration-1000 ease-out"
                                   style="text-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);">
        Selamat Datang!
    </h1> 
    
</body>
</html>