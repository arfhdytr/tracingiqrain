<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracing Huruf Hijaiyah - IQRain</title>
    <link rel="stylesheet" href="{{ asset('css/game-tracing.css') }}">
</head>
<body>
    
    <!-- Welcome Animation Backdrop -->
    <div id="welcome-backdrop" class="welcome-backdrop fixed inset-0 bg-black opacity-0 transition-opacity duration-500 pointer-events-none z-50"></div>
    
    <!-- Welcome Message -->
    <div id="welcome-message" class="welcome-message fixed inset-0 flex items-center justify-center opacity-0 transition-opacity duration-500 pointer-events-none z-50">
        <div class="text-center">
            <h1 class="welcome-title text-6xl font-bold text-white mb-4">Selamat Bermain!</h1>
            <p class="welcome-subtitle text-2xl text-white">Mari belajar menulis huruf hijaiyah</p>
        </div>
    </div>

    <!-- Game Container -->
    <div id="game-container" class="game-container">
        
        <!-- Header with Exit Button -->
        <div class="game-header">
            <div class="letter-info-display">
                <span id="current-letter-arabic" class="arabic-letter">ا</span>
                <span id="current-letter-name" class="letter-name-display">Alif</span>
            </div>
            <a href="{{ url('/murid/games') }}" id="exit-button" class="exit-button">Keluar</a>
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
                
                <div class="canvas-controls">
                    <button id="clear-button" class="control-btn btn-clear">Hapus</button>
                    <button id="replay-button" class="control-btn btn-replay">Ulang Animasi</button>
                </div>
            </div>

            <!-- Animation Preview (Right Side) -->
            <div class="preview-section">
                <div class="preview-title">Perhatikan Cara Menulisnya</div>
                <div class="preview-wrapper">
                    <div id="letter-display" class="letter-display">ا</div>
                    <canvas id="animationCanvas" width="300" height="250"></canvas>
                </div>
            </div>

        </div>

        <!-- Progress Footer -->
        <div class="game-footer">
            <div class="progress-container">
                <div class="progress-label">Progress:</div>
                <div class="progress-bar">
                    <div id="progress-fill" class="progress-fill"></div>
                </div>
                <div id="progress-text" class="progress-text">0%</div>
            </div>

            <div class="score-container">
                <div class="score-label">Akurasi:</div>
                <div id="score-display" class="score-display">0%</div>
                <div id="stars-display" class="stars-display">☆☆☆</div>
            </div>

            <div class="navigation-buttons">
                <button id="prev-button" class="nav-btn btn-prev">← Sebelumnya</button>
                <button id="next-button" class="nav-btn btn-next">Berikutnya →</button>
            </div>
        </div>

    </div>

    <!-- Success Modal (Hidden by default) -->
    <div id="success-modal" class="success-modal">
        <div class="success-container">
            <div class="success-animation">🎉</div>
            <h2 class="success-title">Hebat!</h2>
            <div id="final-stars" class="final-stars">⭐⭐⭐</div>
            <p id="success-message" class="success-message">Kamu menulis huruf dengan sangat baik!</p>
            <p id="final-score" class="final-score">Akurasi: 0%</p>
            <div class="success-buttons">
                <button id="try-again-button" class="btn btn-secondary">Coba Lagi</button>
                <button id="next-letter-button" class="btn btn-primary">Huruf Berikutnya</button>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/game-tracing.js') }}"></script>
</body>
</html>
