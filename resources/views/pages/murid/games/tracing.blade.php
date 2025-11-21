<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tracing Huruf Hijaiyah - IQRain</title>
    <link rel="stylesheet" href="{{ asset('css/game-tracing.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mooli&family=Titan+One&display=swap" rel="stylesheet">
</head>
<body>
    
    <!-- Welcome Animation Backdrop -->
    <div id="welcome-backdrop" class="welcome-backdrop fixed inset-0 bg-black opacity-0 transition-opacity duration-500 pointer-events-none z-50"></div>
    
    <!-- Welcome Message -->
    <div id="welcome-message" class="welcome-message fixed inset-0 flex items-center justify-center opacity-0 transition-opacity duration-500 pointer-events-none z-50">
        <div class="text-center">
            <h1 class="welcome-title text-6xl font-titan text-white mb-4">Selamat Bermain!</h1>
            <p class="welcome-subtitle text-2xl font-cursive-iwk text-white">Mari belajar menulis huruf hijaiyah</p>
        </div>
    </div>

    <!-- Game Container -->
    <div id="game-container" class="game-container">
        
        <!-- Header with Exit Button -->
        <div class="game-header">
            <div class="letter-info-display font-cursive-iwk">
                <span id="current-letter-arabic" class="arabic-letter">ا</span>
                <span id="current-letter-name" class="letter-name-display">Alif</span>
            </div>
            <a href="{{ url('/murid/games/1') }}" id="exit-button" class="exit-button">Keluar</a>
        </div>

        <!-- Main Game Area -->
        <div class="game-main">
            
            <!-- Canvas Area (Left Side) -->
            <div class="canvas-section">
                <div class="canvas-wrapper">
                    <!-- Guide Canvas - Shows the dotted path -->
                    <canvas id="guideCanvas" width="400" height="300"></canvas>
                    <!-- Tracing Canvas - Where user draws -->
                    <canvas id="tracingCanvas" width="400" height="300"></canvas>
                </div>
                
                <div class="canvas-controls font-cursive-iwk">
                    <button id="clear-button" class="control-btn btn-clear">Hapus</button>
                    <button id="replay-button" class="control-btn btn-replay">Ulang Animasi</button>
                </div>
            </div>

            <!-- Animation Preview (Right Side) -->
            <div class="preview-section font-cursive-iwk">
                <div class="preview-title">Perhatikan Cara Menulisnya</div>
                <div class="preview-wrapper">
                    <div id="letter-display" class="letter-display">ا</div>
                    <canvas id="animationCanvas" width="300" height="250"></canvas>
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
            class="btn bg-gray-500 hover:bg-gray-600 text-white mt-4 ml-2 font-titan" 
            style="display:none;" 
            id="back-to-menu-btn">
                Kembali ke Menu Game
            </a>

        </div>

        <!-- Progress Footer -->
        <div class="game-footer">
            <div class="progress-container">
                <div class="progress-label font-titan">Progress:</div>
                <div class="progress-bar">
                    <div id="progress-fill" class="progress-fill"></div>
                </div>
                <div id="progress-text" class="progress-text font-titan">0%</div>
            </div>

            <div class="score-container">
                <div class="score-label font-cursive-iwk">Akurasi:</div>
                <div id="score-display" class="score-display font-cursive-iwk">0%</div>
                <div id="stars-display" class="stars-display">☆☆☆</div>
            </div>

            <div class="navigation-buttons">
                <button id="prev-button" class="nav-btn btn-prev font-titan">← Sebelumnya</button>
                <button id="next-button" class="nav-btn btn-next font-titan">Berikutnya →</button>
            </div>
        </div>

        <!-- <button id="finish-button" class="btn btn-success" style="display:none;">Selesai & Simpan Skor</button> -->
    </div>

    <!-- Success Modal (Hidden by default) -->
    <div id="success-modal" class="success-modal" style="display:none;">
        <div class="success-container">
            <div class="success-animation">🎉</div>
            <h2 class="success-title font-titan">Hebat!</h2>
            <div id="final-stars" class="final-stars">⭐⭐⭐</div>
            <p id="success-message" class="success-message font-cursive-iwk">Kamu menulis huruf dengan sangat baik!</p>
            
            {{-- REVISI MINOR: Akurasi --}}
            <p id="final-accuracy" class="final-score font-cursive-iwk">Akurasi: 0%</p> 
            
            {{-- Pesan status penyimpanan skor --}}
            <p id="save-status" class="text-sm mt-2 text-yellow-600 font-cursive-iwk">Menyimpan skor...</p> 

            <div class="success-buttons">
                {{-- Tombol 1: Ulangi Huruf Ini --}}
                <button id="try-again-button" class="btn btn-secondary font-cursive-iwk" onclick="restartCurrentLetter()">
                    Ulangi Huruf Ini
                </button>
                
                {{-- Tombol 2: Lanjut Huruf Berikutnya --}}
                <button id="next-letter-button" class="btn btn-primary font-cursive-iwk" onclick="loadNextLetter()">
                    Huruf Berikutnya
                </button>
                
                {{-- Tombol 3: Selesai & Kembali ke Menu (Dipakai untuk mengambil tingkatan ID) --}}
                <button id="back-to-menu-button" 
                        class="btn btn-tertiary font-titan"
                        data-tingkatan-id="{{ $tingkatan->tingkatan_id ?? 1 }}"
                        onclick="window.location.href = '{{ route('murid.games.index', ['tingkatan_id' => $tingkatan->tingkatan_id ?? 1]) }}'"
                        style="margin-top: 10px;">
                    Selesai & Kembali ke Menu
                </button>
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
            showSuccessScreen(finalScore, accuracyPercentage);
            // window.gameFinalScore = finalScore; 
            // window.gameAccuracyPercentage = accuracyPercentage;
            
            // // 1. Update Tampilan Modal
            // document.getElementById('final-accuracy').innerText = `Akurasi: ${accuracyPercentage}%`; 
            // document.getElementById('success-modal').style.display = 'flex'; 
            
            // // 2. Langsung Panggil Fungsi Penyimpanan Skor
            // saveTracingScore(); // Didefinisikan di game-tracing.js
        }
    </script>


    <script src="{{ asset('js/game-tracing.js') }}"></script>
</body>
</html>
