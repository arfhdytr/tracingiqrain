<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tracing Huruf Hijaiyah - IQRain</title>

    <link rel="stylesheet" href="{{ asset('css/game-tracing.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        var ASSET_BASE = "{{ asset('') }}";
        var REDIRECT_URL = "{{ route('murid.games.index', $tingkatan->tingkatan_id) }}";

        // ID Game (Dari $jenisGame)
        var JENIS_GAME_ID = {{ $jenisGame->jenis_game_id }};
        var TINGKATAN_ID = {{ $tingkatan->tingkatan_id }};
        var HASIL_GAME_ID = {{ $sessionGame->hasil_game_id }};

        // Data Huruf (Convert PHP Array ke JSON)
        // Asumsi: materiPembelajarans punya kolom 'huruf_arab' dan 'nama_latin'
        var ALL_HIJAIYAH_DATA = @json($materiPembelajarans);
    </script>

</head>

<body>
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


    <!-- Letter Menu Container (Initial View) -->
    <div id="letter-menu-container" class="letter-menu-container">
        <!-- Header Menu -->
        <div class="menu-header">
            <a href="{{ route('murid.games.index', $tingkatan->tingkatan_id) }}" class="btn-kembali">
                <div class="btn-kembali-icon">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </div>
                <span class="btn-kembali-text">Kembali</span>
            </a>

            <div class="menu-title-wrapper">
                <h1 class="menu-title">
                    <span class="phrase-pink">Pilih</span>
                    <span class="phrase-pink">Huruf</span>
                    <span class="phrase-pink">Hijaiyah</span>
                </h1>
            </div>

            <div class="w-[100px] sm:w-[140px]"></div> <!-- Spacer for centering (matches btn-kembali width) -->
        </div>

        <!-- Grid Container -->
        <div id="letter-grid"
            class="w-full max-w-6xl px-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 md:gap-6">
            <!-- Di sini akan mucnul kartu  -->
        </div>
    </div>

    <!-- Game Container (Hidden by Default) -->
    <div id="game-container" class="game-container" style="display: none;">

        <!-- Header with Exit Button -->
        <div class="game-header">
            <!-- Tombol Kembali ke Menu -->
            <button onclick="showMenu()" class="btn-kembali">
                <div class="btn-kembali-icon">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </div>
                <span class="btn-kembali-text">
                    Menu
                </span>
            </button>
            <div class="letter-info-display">
                <span id="current-letter-arabic" class="arabic-letter" style="color:white;">ا</span>
                <span id="current-letter-name" class="letter-name-display" style="color: white;">Alif</span>
            </div>
        </div>

        <!-- Main Game Area -->
        <div class="game-main">

            {{-- Balon kiri --}}
            <div class="balloon balloon-left">
                <img src="{{ asset('images/icon/balon.webp') }}" alt="Balon Kiri" style="width:100%; height:auto;">
            </div>

            <!-- Canvas Area (Left Side) -->
            <div class="canvas-section">
                <div class="canvas-wrapper">
                    <!-- Guide Canvas - Shows the dotted path -->
                    <canvas id="guideCanvas" width="400" height="300"></canvas>
                    <!-- Tracing Canvas - Where user draws -->
                    <canvas id="tracingCanvas" width="400" height="300"></canvas>
                </div>

                <div class="canvas-controls">
                    <button id="clear-button" class="control-btn btn-clear font-titan">Hapus</button>
                    <button id="replay-button" class="control-btn btn-replay font-titan">Ulang Animasi</button>
                </div>
            </div>

            <!-- Animation Preview (Right Side) -->
            <div class="preview-section font-cursive-iwk">
                <div class="preview-wrapper">
                    <div id="letter-display" class="letter-display">ا</div>
                    <canvas id="animationCanvas" width="400" height="300"></canvas>
                </div>
            </div>

            <h2 id="final-score" class="text-2xl font-titan mt-4" style="display:none;">Skor Akhir: 0</h2>
            {{-- Tombol untuk menyimpan skor (muncul setelah game selesai) --}}
            {{-- PENTING: data-tingkatan-id harus diisi dari controller --}}
            <!-- <button id="save-score-btn" 
                    class="btn bg-indigo-500 hover:bg-indigo-600 text-white mt-4"
                    data-tingkatan-id="{{ $tingkatan->tingkatan_id ?? 0 }}" {{-- Pastikan $tingkatan tersedia dari controller tracing() --}}
                    style="display:none;" 
                    onclick="saveTracingScore()">
                Simpan Skor
            </button> -->

            {{-- Tombol kembali ke menu --}}
            <a href="{{ route('murid.games.index', ['tingkatan_id' => $tingkatan->tingkatan_id ?? 0]) }}"
                class="btn bg-gray-500 hover:bg-gray-600 text-white mt-4 ml-2 font-titan" style="display:none;"
                id="back-to-menu-btn">
                Kembali ke Menu Game
            </a>

            <!-- Balon kanan -->
            <div class="balloon balloon-right">
                <img src="{{ asset('images/icon/balon.webp') }}" alt="Balon Kanan" style="width:100%; height:auto;">
            </div>



        </div>



        <!-- Progress Footer -->
        <div class="game-footer">
            <div class="progress-container">
                <div class="progress-label font-cursive-iwk"><span class="phrase-pink-iqrain">Progress:</span></div>
                <div class="progress-bar">
                    <div id="progress-fill" class="progress-fill"></div>
                </div>
                <div id="progress-text" class="progress-text font-titan">0%</div>
            </div>

            <div class="score-container">
                <div class="score-label font-cursive-iwk"><span class="phrase-pink-iqrain">Akurasi:</span></div>
                <div id="score-display" class="score-display font-cursive-iwk">0%</div>
                <div id="stars-display" class="stars-display">☆☆☆</div>
            </div>

            <div class="navigation-buttons">
                <button id="prev-button" class="nav-btn btn-prev"><span>←</span><span class="phrase-blue">Sebelumnya</span></button>
                <button id="next-button" class="nav-btn btn-next"><span class="phrase-pink-iqrain">Berikutnya</span> <span>→</span></button>
            </div>
        </div>

        <!-- <button id="finish-button" class="btn btn-success" style="display:none;">Selesai & Simpan Skor</button> -->
    </div>



    <!-- Success Modal (Hidden by default) -->
    <div id="success-modal" class="custom-modal">
        <div class="modal-overlay"></div>

        <div class="modal-card">
            {{-- Ikon Piala --}}
            <div class="modal-icon animate-bounce">
                <img src="{{ asset('images/icon/piala.webp') }}" alt="Piala">
            </div>

            <h2 class="modal-title font-cursive-iwk">Luar Biasa!</h2>

            <p class="modal-subtitle font-cursive-iwk">
                Kamu berhasil menyelesaikan huruf ini!
            </p>

            {{-- WADAH BINTANG (Perbaikan Class) --}}
            <div id="final-stars" class="modal-stars">⭐⭐⭐</div>

            {{-- Kotak Skor --}}
            <div class="score-box">
                <p class="score-label">Akurasi</p>
                <p class="score-value" id="modal-score">0%</p>
            </div>

            {{-- Tombol Aksi --}}
            <div class="modal-actions">

                {{-- 1. Tombol Lanjut (Primary - Pink) --}}
                <button id="btn-next-letter" onclick="loadNextLetter()" class="btn-action btn-pink font-cursive-iwk">
                    Huruf Berikutnya ➔
                </button>

                {{-- 2. Tombol Ulangi (Secondary - Putih Border Pink) --}}
                <button onclick="restartCurrentLetter()" class="btn-action btn-outline-pink font-cursive-iwk">
                    Ulangi Huruf Ini ↺
                </button>

                {{-- 3. Tombol Menu (Tertiary - Abu) --}}
                <a href="{{ route('murid.games.index', $tingkatan->tingkatan_id) }}"
                    class="btn-action btn-ghost font-cursive-iwk">
                    Kembali ke Menu
                </a>
            </div>
        </div>
    </div>

    <!-- <div id="score-modal" class="modal d-none">
        <div class="modal-content">
            <h4>Skor tracing berhasil disimpan!</h4>
            <p id="modal-skor"></p>
            <p id="modal-total"></p>
            <button onclick="closeScoreModal()">Lanjut</button>
        </div>
    </div> -->




    <script>
        // Variabel global yang akan diisi oleh logika game Anda
        window.gameFinalScore = 0; // Skor yang akan masuk ke DB (misalnya, total poin)
        window.gameAccuracyPercentage = 0; // Akurasi (0-100) untuk tampilan

        // PENTING: Fungsi ini HARUS dipanggil oleh logika game tracing Anda 
        // saat tracing selesai.
        function showGameResults(finalScore, accuracyPercentage) {
            showSuccessModal(accuracyPercentage);
            // window.gameFinalScore = finalScore; 
            // window.gameAccuracyPercentage = accuracyPercentage;

            // // 1. Update Tampilan Modal
            // document.getElementById('final-accuracy').innerText = Akurasi: ${accuracyPercentage}%; 
            // document.getElementById('success-modal').style.display = 'flex'; 

            // // 2. Langsung Panggil Fungsi Penyimpanan Skor
            // saveTracingScore(); // Didefinisikan di game-tracing.js
        }
    </script>



    <script src="{{ asset('js/game-tracing.js') }}"></script>
</body>

</html>