<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Labirin Hijaiyah</title>

    {{-- 1. IMPORT FONT MOOLI & TEGAK BERSAMBUNG --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mooli&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])



    {{-- CSS Kustom --}}
    <style>
        /* Wrapper Utama Game */
        #game-content-wrapper {
            position: relative;
            z-index: 1;
            overflow: hidden;
            min-height: 100vh;
            background: linear-gradient(180deg, #56B1F3 0%, #D3F2FF 100%);
        }

        /* Font Kustom */
        @font-face {
            font-family: 'Tegak Bersambung_IWK';
            src: url("{{ asset('fonts/TegakBersambung_IWK.ttf') }}") format('truetype');
        }

        .font-cursive-iwk {
            font-family: 'Tegak Bersambung_IWK', cursive !important;
        }

        /* Font Mooli untuk Skor */
        .font-mooli {
            font-family: 'Mooli', sans-serif !important;
        }
        

        /* Styling Grid Labirin */
        .maze-cell {
            width: 33px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
        }

        .maze-wall {
            background-color: #D75C82;
        }

        .maze-path {
            background-color: #D9D9D9;
        }

        /* Animasi pop untuk skor saat berubah */
        @keyframes popScale {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.3);
                color: #D75C82;
            }

            100% {
                transform: scale(1);
            }
        }

        .score-pop {
            animation: popScale 0.3s ease-out;
        }
    </style>
</head>

<body class="bg-white">

    {{-- Konten Halaman --}}
    <div id="game-content-wrapper">
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
                    <span class="font-mooli font-semibold text-white text-[18px] font-normal leading-none pl-4">
                        Kembali
                    </span>
                </a>
            </div>

            {{-- Balon kiri --}}
            <div class="fixed left-4 top-1/3 w-40 md:w-50 h-auto animate-bounce-slow z-10 pointer-events-none">
                <img src="{{ asset('images/icon/balon.webp') }}" alt="Balon Kiri" class="w-full h-auto drop-shadow-lg">
            </div>

            <div class="container mx-auto p-2 max-w-4xl">

                {{-- Area Target Pencarian Huruf --}}
                <div class="mb-8 text-center flex flex-col items-center">
                    <p class="text-[#AC3F61] font-cursive-iwk font-semibold text-[36px] leading-tight mb-2">
                        <span class="phrase-pink-tua">Cari</span> <span class="phrase-pink-tua">huruf:</span>
                    </p>
                    
                    {{-- Kontainer background pink tua --}}
                    <div class="min-w-[200px] px-8 py-4 rounded-[35px] bg-[#D75C82] flex items-center justify-center my-2 shadow-lg">
                        {{-- Flex container untuk menata huruf dan tanda strip --}}
                        <p id="target-letters-display" class="flex flex-wrap justify-center items-end gap-x-4 gap-y-2 font-cursive-iwk text-2xl leading-none tracking-wide text-white">
                            
                            {{-- Looping setiap huruf target --}}
                            @foreach($targetLetters as $letter)
                                {{-- HANYA KATA INI yang diberi garis lengkung di bawahnya --}}
                                <span class="phrase-putih">
                                    {{ $letter }}
                                </span>

                                {{-- Tanda strip pemisah (jika bukan huruf terakhir) --}}
                                @if(!$loop->last)
                                    <span class="opacity-70 pb-2">-</span>
                                @endif
                            @endforeach

                        </p>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row justify-center items-start gap-8">

                    {{-- Kolom Kiri: Papan Game --}}
                    <div class="w-full md:w-auto flex flex-col items-center md:items-start">
                        {{-- 3. TAMPILAN PROGRES SKOR --}}
                        <div class="mb-3 bg-white/80 px-6 py-2 rounded-full shadow-sm border-2 border-[#AC3F61]">
                            <p id="skor-labirin-display" class="text-medium font-mooli font-semibold text-[#D75C82]">
                                Huruf: 0/4
                            </p>
                        </div>

                        {{-- 3. TAMPILAN PROGRES SKOR (DIPERBAIKI) --}}
                        {{-- Grid Labirin (Akan diisi JS) --}}
                        <div id="maze-grid"
                            class="grid gap-[11px] p-4 bg-white rounded-[34px] shadow-[0_4px_10px_0_rgba(0,0,0,0.50)] place-content-start">
                            {{-- Cells generated by JS --}}
                        </div>
                    </div>

                    {{-- Kolom Kanan: Tombol Kontrol --}}
                    <div class="w-full md:w-auto flex flex-col items-center gap-6 pt-4 md:pt-10">

                        {{-- Tombol Reset / Main Lagi --}}
                        <button id="reset-button"
                            class="flex items-center justify-center gap-2 w-[140px] h-[55px] rounded-[35px] border-2 border-[#AC3F61] bg-white/80 hover:bg-white shadow-md transition-all font-mooli font-semibold text-[#AC3F61] text-2xl">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M23 4v6h-6"></path>
                                <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path>
                            </svg>
                            <p class="font-mooli font font-semibold text-[18px]"> Main lagi </p>
                        </button>

                        {{-- D-PAD Kontrol Arah --}}
                        <div
                            class="grid grid-cols-3 grid-rows-3 items-center justify-items-center w-[180px] h-[180px] bg-white rounded-[30px] shadow-lg p-3">
                            <div class="col-start-2 row-start-1">
                                <button id="btn-up"
                                    class="dpad-btn w-[45px] h-[45px] rounded-full bg-[#FFCE6B] shadow-md hover:scale-110 active:scale-95 transition-transform flex items-center justify-center">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                        stroke="#D75C82" stroke-width="4" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M12 4L12 20M12 4L6 10M12 4L18 10" />
                                    </svg>
                                </button>
                            </div>
                            <div class="col-start-1 row-start-2">
                                <button id="btn-left"
                                    class="dpad-btn w-[45px] h-[45px] rounded-full bg-[#FFCE6B] shadow-md hover:scale-110 active:scale-95 transition-transform flex items-center justify-center">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                        stroke="#D75C82" stroke-width="4" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M20 12L4 12M4 12L10 6M4 12L10 18" />
                                    </svg>
                                </button>
                            </div>
                            <div
                                class="col-start-2 row-start-2 w-[25px] h-[25px] rounded-full bg-[#FFCE6B]/50 border-2 border-[#D75C82]">
                            </div>
                            <div class="col-start-3 row-start-2">
                                <button id="btn-right"
                                    class="dpad-btn w-[45px] h-[45px] rounded-full bg-[#FFCE6B] shadow-md hover:scale-110 active:scale-95 transition-transform flex items-center justify-center">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                        stroke="#D75C82" stroke-width="4" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M4 12L20 12M20 12L14 6M20 12L14 18" />
                                    </svg>
                                </button>
                            </div>
                            <div class="col-start-2 row-start-3">
                                <button id="btn-down"
                                    class="dpad-btn w-[45px] h-[45px] rounded-full bg-[#FFCE6B] shadow-md hover:scale-110 active:scale-95 transition-transform flex items-center justify-center">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                        stroke="#D75C82" stroke-width="4" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M12 20L12 4M12 20L18 14M12 20L6 14" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <p class="font-cursive-iwk text-center text-2xl text-[#AC3F61] px-4">
                            <span class="phrase-pink-tua"> Gunakan </span>
                            <span class="phrase-pink-tua"> panah </span>
                            <span class="phrase-pink-tua"> layar </span>
                            <span class="phrase-pink-tua"> atau </span>
                            <span class="phrase-pink-tua"> keyboard </span>
                            <span class="phrase-pink-tua"> untuk </span>
                            <span class="phrase-pink-tua"> bergerak. </span>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Balon kanan --}}
            <div class="fixed right-4 top-1/4 w-40 md:w-50 h-auto animate-bounce-slow z-10 pointer-events-none">
                <img src="{{ asset('images/icon/balon.webp') }}" alt="Balon Kanan"
                    class="w-full h-auto drop-shadow-lg transform scale-x-[-1]">
            </div>

            {{-- Spacer Bottom --}}
            <div class="h-24"></div>
        </div>

        {{-- Balon kanan --}}
        <div class="fixed right-4 top-1/4 w-40 md:w-50 h-auto animate-bounce-slow z-10 pointer-events-none">
            <img src="{{ asset('images/icon/balon.webp') }}" alt="Balon Kanan"
                class="w-full h-auto drop-shadow-lg transform scale-x-[-1]">
        </div>

        {{-- Spacer Bottom --}}
        <div class="h-24"></div>
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
                <span class="phrase-pink-kontras">Luar </span>
                <span class="phrase-pink-kontras">Biasa!</span>
            </h2>

            <p class="font-['TegakBersambung'] text-[gray-600] mb-6 text-2xl">
                <span class="phrase-hitam">Kamu </span>
                <span class="phrase-hitam">berhasil </span>
                <span class="phrase-hitam">menyelesaikan </span>
                <span class="phrase-hitam">permainan! </span>
            </p>

            <div class="bg-pink-50 rounded-xl p-4 mb-6 border border-pink-100">
                <p class="text-gray-500 text-sm font-bold uppercase">Total Poin</p>
                <p class="text-4xl font-bold text-pink-600" id="modal-score">0</p>
            </div>

            <div class="flex flex-col gap-3">
                <button onclick="restartGame()"
                    class="w-full py-3 bg-gradient-to-r from-pink-400 to-pink-500 text-white rounded-xl font-bold text-xl shadow-lg hover:scale-105 transition-transform font-mooli font-semibold text-base">
                    Main Lagi ↻
                </button>

                <a href="{{ route('murid.games.index', $tingkatan->tingkatan_id) }}"
                    class="w-full py-3 bg-white border-2 border-gray-200 text-gray-500 rounded-xl font-bold text-lg hover:bg-gray-50 transition-colors  font-mooli font-semibold text-base">
                    Kembali ke Menu </a>
            </div>
        </div>
    </div>


    {{-- POP UP BELUM SELESAI --}}
    <div id="incomplete-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <div class="absolute inset-0 transition-opacity duration-300" style="background-color: rgba(0, 0, 0, 0.6);">
        </div>

        <div
            class="relative bg-white rounded-3xl p-8 max-w-sm w-full mx-4 shadow-2xl transform scale-90 transition-transform duration-300 border-4 border-yellow-400 text-center">
            <div class="mb-4 animate-bounce">
                <img src="{{ asset('images/icon/tanda-tanya.webp') }}" alt="Tanda Tanya" class="w-24 h-auto mx-auto">
            </div>

            <h2 class="font-['TegakBersambung'] text-4xl text-yellow-500 font-bold mb-2">
                Belum Selesai!
            </h2>

            <p id="incomplete-message" class="font-['TegakBersambung'] text-gray-600 mb-6 text-lg">
                Masih ada huruf yang belum dikumpulkan.
            </p>

            <button onclick="closeIncompleteModal()"
                class="w-full py-3 bg-gradient-to-r from-yellow-400 to-yellow-500 text-white rounded-xl font-bold text-xl shadow-lg hover:scale-105 transition-transform font-['TegakBersambung']">
                Lanjut Main
            </button>
        </div>
    </div>

    {{-- JavaScript Game --}}
    <script>
        // --- 1. DATA DARI CONTROLLER ---
        window.gameData = {
            mapLayout: @json($mapLayout),
            targetLetters: @json($targetLetters),
            targetFiles: @json($targetFiles),
            sessionId: {{ $currentSessionId }},
            allMaps: @json($allMaps)
        };

        const jenisGameId = {{ $jenisGame->jenis_game_id }};

        // URL Routes
        const saveScoreUrl = '{{ route('murid.game.saveScore') }}';
        const redirectUrl = '{{ route('murid.games.index', $tingkatan->tingkatan_id) }}';

        // --- 2. FUNGSI GLOBAL (UI & SKOR) ---

        // A. Fungsi Restart Game (Dipanggil tombol HTML)
        window.restartGame = function() {
            location.reload();
        }

        // B. Fungsi Tampilkan Modal Menang
        function showSuccessModal(skorAkhir) {
            const modal = document.getElementById('success-modal');
            const scoreText = document.getElementById('modal-score');

            // Update teks skor
            if (scoreText) scoreText.innerText = skorAkhir;

            // Tampilkan Modal
            modal.classList.remove('hidden');
            modal.classList.add('flex'); // Pastikan display flex agar tengah

            // Animasi Masuk
            const modalBox = modal.querySelector('div.relative');
            setTimeout(() => {
                modalBox.classList.remove('scale-90');
                modalBox.classList.add('scale-100');
            }, 10);

            // Panggil Confetti
            triggerWinConfetti();
        }

        // B.2. Fungsi Tampilkan Modal Belum Selesai
        window.showIncompleteModal = function(remaining) {
            const modal = document.getElementById('incomplete-modal');
            const message = document.getElementById('incomplete-message');

            if (message) message.innerText = `Kumpulkan ${remaining} huruf lagi ya!`;

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            const modalBox = modal.querySelector('div.relative');
            setTimeout(() => {
                modalBox.classList.remove('scale-90');
                modalBox.classList.add('scale-100');
            }, 10);
        }

        window.closeIncompleteModal = function() {
            const modal = document.getElementById('incomplete-modal');
            const modalBox = modal.querySelector('div.relative');

            modalBox.classList.remove('scale-100');
            modalBox.classList.add('scale-90');

            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 300);
        }

        // C. Fungsi Confetti
        function triggerWinConfetti() {
            var duration = 3 * 1000;
            var animationEnd = Date.now() + duration;
            var defaults = {
                startVelocity: 30,
                spread: 360,
                ticks: 60,
                zIndex: 9999
            };

            var random = function(min, max) {
                return Math.random() * (max - min) + min;
            }

            var interval = setInterval(function() {
                var timeLeft = animationEnd - Date.now();
                if (timeLeft <= 0) return clearInterval(interval);

                var particleCount = 50 * (timeLeft / duration);
                confetti(Object.assign({}, defaults, {
                    particleCount,
                    origin: {
                        x: random(0.1, 0.3),
                        y: Math.random() - 0.2
                    }
                }));
                confetti(Object.assign({}, defaults, {
                    particleCount,
                    origin: {
                        x: random(0.7, 0.9),
                        y: Math.random() - 0.2
                    }
                }));
            }, 250);
        }

        async function saveScore(skor, poin) {
            const currentId = window.gameData.sessionId; // Ambil ID yang dibuat pas masuk
            const timestamp = new Date().toLocaleTimeString();

            console.log(`[${timestamp}] MENGUPDATE SKOR ID: ${currentId}...`, { skor, poin });

            // ALERT DEBUG (Boleh dihapus nanti kalau sudah oke)
            // alert(`[UPDATE MODE] Mengupdate data ID: ${currentId} menjadi skor ${skor}`);

            if (!currentId) {
                alert("ERROR FATAL: Session ID tidak ditemukan! Cek Controller.");
                return;
            }

            try {
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const response = await fetch(saveScoreUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        // PERUBAHAN DISINI: Kirim ID Sesi, bukan Jenis Game lagi
                        hasil_game_id: currentId,
                        skor: skor,
                        // total_poin dihitung ulang di backend biar aman, tapi kirim aja gapapa
                    })
                });

                const data = await response.json();
                console.log(`[${timestamp}] RESPON SERVER:`, data);

                if (!response.ok || (data.success === false)) {
                    console.error("Gagal Update:", data);
                    let pesanError = data.message || "Terjadi kesalahan server";
                    alert("GAGAL MENGUPDATE SKOR!\n\n" + pesanError);
                } else {
                    console.log("Berhasil diupdate:", data);
                    // alert(`SUKSES UPDATE!\nData ID: ${data.hasil_game_id} sekarang bernilai ${data.poin_didapat} poin.`);
                }

            } catch (error) {
                console.error('Error Jaringan:', error);
                alert("ERROR JARINGAN!\n" + error.message);
            }
        }

        // --- 3. LOGIKA UTAMA GAME (Jalan saat Load) ---
        document.addEventListener("DOMContentLoaded", () => {

            // === WELCOME ANIMATION ===
            const welcomeBackdrop = document.getElementById("welcome-backdrop");
            const welcomeContainer = document.getElementById("welcome-message-container");
            const welcomeMessage = document.getElementById("welcome-message");

            if (welcomeBackdrop && welcomeContainer && welcomeMessage) {
                // Step 1: Fade in backdrop (100ms)
                setTimeout(() => {
                    welcomeBackdrop.classList.remove("opacity-0");
                    welcomeBackdrop.classList.add("opacity-100");
                }, 100);

                // Step 2: Show message with scale animation (200ms)
                setTimeout(() => {
                    welcomeContainer.classList.remove("opacity-0");
                    welcomeContainer.classList.add("opacity-100");

                    welcomeMessage.classList.remove("scale-75");
                    welcomeMessage.classList.add("scale-100");
                }, 200);

                // Step 3: Start fade out (2.5s)
                setTimeout(() => {
                    welcomeMessage.classList.remove("scale-100");
                    welcomeMessage.classList.add("scale-110");
                    welcomeContainer.classList.remove("opacity-100");
                    welcomeContainer.classList.add("opacity-0");

                    welcomeBackdrop.classList.remove("opacity-100");
                    welcomeBackdrop.classList.add("opacity-0");
                }, 2500);

                // Step 4: Hide completely (3.5s total)
                setTimeout(() => {
                    welcomeBackdrop.classList.add("hidden");
                    welcomeContainer.classList.add("hidden");
                }, 3500);
            }
            // ==================================================

            const gridContainer = document.getElementById("maze-grid");
            const scoreDisplay = document.getElementById("skor-labirin-display");

            let mapLayout = window.gameData.mapLayout;
            const targetFiles = window.gameData.targetFiles;
            const allMaps = window.gameData.allMaps;

            // Dinamis Grid (Biar aman kalau map berubah ukuran)
            let gridRows = mapLayout.length;
            let gridCols = mapLayout[0].length;

            let playerPosition = {
                x: 0,
                y: 0
            };
            let collectedLetters = [];
            let gameItems = [];

            // Setup Awal
            function initGame() {
                renderBoard();
                placeItems();
            }

            // Render Grid
            function renderBoard() {
                gridContainer.innerHTML = "";
                gridContainer.style.gridTemplateColumns = `repeat(${gridCols}, minmax(0, 1fr))`;

                for (let y = 0; y < gridRows; y++) {
                    for (let x = 0; x < gridCols; x++) {
                        const cell = document.createElement("div");
                        cell.className = "maze-cell";
                        cell.dataset.x = x;
                        cell.dataset.y = y;

                        if (mapLayout[y][x] === 1) {
                            cell.classList.add("maze-wall");
                        } else {
                            cell.classList.add("maze-path");
                        }
                        gridContainer.appendChild(cell);
                    }
                }
            }

            // Place Items Logic
            function placeItems() {
                const validCells = [];
                for (let y = 0; y < gridRows; y++) {
                    for (let x = 0; x < gridCols; x++) {
                        if (mapLayout[y][x] === 0) validCells.push({
                            x,
                            y
                        });
                    }
                }

                // Shuffle function helper
                for (let i = validCells.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [validCells[i], validCells[j]] = [validCells[j], validCells[i]];
                }

                if (validCells.length < 6) return console.error("Map terlalu kecil!");

                playerPosition = validCells.pop(); // Set Player Pos

                // Set Items
                gameItems = [{
                        type: 'letter',
                        value: targetFiles[0],
                        ...validCells.pop(),
                        collected: false
                    },
                    {
                        type: 'letter',
                        value: targetFiles[1],
                        ...validCells.pop(),
                        collected: false
                    },
                    {
                        type: 'letter',
                        value: targetFiles[2],
                        ...validCells.pop(),
                        collected: false
                    },
                    {
                        type: 'letter',
                        value: targetFiles[3],
                        ...validCells.pop(),
                        collected: false
                    },
                    {
                        type: 'goal',
                        ...validCells.pop(),
                        collected: false
                    }
                ];

                updateItemDisplay();
            }

            // Update Tampilan Icon
            function updateItemDisplay() {
                gridContainer.querySelectorAll('.game-item').forEach(item => item.remove());

                // Player Icon
                const playerCell = getCell(playerPosition.x, playerPosition.y);
                if (playerCell) {
                    const playerIcon = document.createElement('div');
                    playerIcon.className = "game-item w-full h-full flex items-center justify-center animate-pulse";
                    playerIcon.innerHTML =
                        `<img src="/images/games/qira-labirin.webp" alt="Player" class="w-full h-full object-contain drop-shadow-md">`;
                    playerCell.appendChild(playerIcon);
                }

                // Items Icons
                gameItems.forEach(item => {
                    if (item.collected) return;
                    const itemCell = getCell(item.x, item.y);
                    if (itemCell) {
                        const itemIcon = document.createElement('div');
                        itemIcon.className = "game-item w-full h-full flex items-center justify-center";

                        if (item.type === 'letter') {
                            itemIcon.innerHTML =
                                `<img src="/images/hijaiyah/${item.value}" alt="Hijaiyah" class="w-5 h-5 object-contain hover:scale-125 transition-transform">`;
                        } else {
                            itemIcon.innerHTML =
                                `<img src="/images/games/finish-labirin.webp" alt="Finish" class="w-full h-full object-contain">`;
                        }
                        itemCell.appendChild(itemIcon);
                    }
                });
            }

            // Move Logic
            function movePlayer(dx, dy) {
                // Cek Modal sudah muncul atau belum (biar gak bisa jalan pas menang)
                if (!document.getElementById('success-modal').classList.contains('hidden')) return;

                const newX = playerPosition.x + dx;
                const newY = playerPosition.y + dy;

                if (newX < 0 || newX >= gridCols || newY < 0 || newY >= gridRows) return;
                if (mapLayout[newY][newX] === 1) return;

                playerPosition.x = newX;
                playerPosition.y = newY;

                updateItemDisplay();
                checkCollision();
            }

            // Collision Check
            function checkCollision() {
                const item = gameItems.find(i => !i.collected && i.x === playerPosition.x && i.y === playerPosition
                    .y);
                if (!item) return;

                if (item.type === 'letter') {
                    item.collected = true;
                    collectedLetters.push(item.value);

                    // Update Score UI
                    scoreDisplay.textContent = `Huruf: ${collectedLetters.length}/4`;
                    scoreDisplay.classList.remove('score-pop');
                    void scoreDisplay.offsetWidth;
                    scoreDisplay.classList.add('score-pop');

                    updateItemDisplay();

                } else if (item.type === 'goal') {
                    if (collectedLetters.length === 4) {
                        // PERUBAHAN DISINI:

                        // 1. Tampilkan Pop-up & Confetti LANGSUNG (Tanpa Loading)
                        showSuccessModal(100);

                        // 2. Simpan ke database di latar belakang (User tidak perlu nunggu ini)
                        saveScore(100, 100);

                    } else {
                        showIncompleteModal(4 - collectedLetters.length);
                    }
                }
            }

            function getCell(x, y) {
                return gridContainer.querySelector(`div[data-x='${x}'][data-y='${y}']`);
            }

            // Input Listener
            document.getElementById("btn-up").onclick = () => movePlayer(0, -1);
            document.getElementById("btn-down").onclick = () => movePlayer(0, 1);
            document.getElementById("btn-left").onclick = () => movePlayer(-1, 0);
            document.getElementById("btn-right").onclick = () => movePlayer(1, 0);

            document.addEventListener("keydown", (e) => {
                if (["ArrowUp", "ArrowDown", "ArrowLeft", "ArrowRight"].indexOf(e.code) > -1) e
                    .preventDefault();
                if (e.key === "ArrowUp") movePlayer(0, -1);
                if (e.key === "ArrowDown") movePlayer(0, 1);
                if (e.key === "ArrowLeft") movePlayer(-1, 0);
                if (e.key === "ArrowRight") movePlayer(1, 0);
            });

            // Fungsi Reset Game (Client Side)
            function resetGame() {
                // 1. Pilih Map Baru secara Acak
                if (allMaps && allMaps.length > 0) {
                    mapLayout = allMaps[Math.floor(Math.random() * allMaps.length)];
                    gridRows = mapLayout.length;
                    gridCols = mapLayout[0].length;
                }

                // 2. Reset State
                collectedLetters = [];
                gameItems = [];
                playerPosition = { x: 0, y: 0 };

                // 3. Reset UI Skor
                scoreDisplay.textContent = `Huruf: 0/4`;

                // 4. Init Ulang
                initGame();
            }

            document.getElementById("reset-button").onclick = () => resetGame();

            initGame();
        });
    </script>

</body>

</html>
