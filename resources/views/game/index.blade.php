<x-layouts.game>
    <div id="app">
        <div id="menuScreen" class="screen active">
            <div class="menu-container">
                <h1 class="game-title">Tracing Iqra</h1>
                <p class="game-subtitle">Belajar Menulis Huruf Hijaiyah</p>
                <div class="letter-grid" id="letterGrid"></div>
            </div>
        </div>

        <div id="gameScreen" class="screen">
            <div class="game-container">
                <div class="tracing-section">
                    <div class="section-header">
                        <h2 id="letterName" class="letter-name">Alif</h2>
                        <button id="clearBtn" class="btn btn-secondary">🔄 Ulangi</button>
                    </div>
                    <div class="canvas-wrapper">
                        <canvas id="guideCanvas" width="400" height="300"></canvas>
                        <canvas id="tracingCanvas" width="400" height="300"></canvas>
                    </div>
                    <div class="hint-text">Ikuti garis putus-putus untuk menulis huruf</div>
                </div>

                <div class="preview-section">
                    <div class="section-header">
                        <h3 class="preview-title">Cara Menulis</h3>
                        <button id="replayBtn" class="btn btn-small">▶️ Ulang</button>
                    </div>
                    <div class="preview-wrapper">
                        <div class="letter-display" id="letterDisplay">ا</div>
                        <canvas id="animationCanvas" width="200" height="250"></canvas>
                    </div>
                    <div class="letter-info">
                        <p class="letter-arabic" id="letterArabic">ا</p>
                        <p class="letter-transliteration" id="letterTransliteration">Alif</p>
                    </div>
                </div>
            </div>

            <div class="game-footer">
                <div class="progress-container">
                    <div class="progress-label">Progress:</div>
                    <div class="progress-bar">
                        <div id="progressFill" class="progress-fill"></div>
                    </div>
                    <div id="progressText" class="progress-text">0%</div>
                </div>
                <div class="score-container">
                    <div class="score-label">Akurasi:</div>
                    <div id="scoreDisplay" class="score-display">0%</div>
                    <div id="starsDisplay" class. ="stars-display"></div>
                </div>
                <button id="backBtn" class="btn btn-outline">← Kembali</button>
            </div>
        </div>

        <div id="successScreen" class="screen">
            <div class="success-container">
                <div class="success-animation">🎉</div>
                <h2 class="success-title">Hebat!</h2>
                <div id="finalStars" class="final-stars"></div>
                <p id="successMessage" class="success-message">Kamu berhasil menulis huruf dengan sempurna!</p>
                <div id="finalScore" class="final-score">Akurasi: 0%</div>
                <div class="success-buttons">
                    <button id="tryAgainBtn" class="btn btn-primary">🔄 Coba Lagi</button>
                    <button id="nextLetterBtn" class="btn btn-secondary">Huruf Lain</button>
                </div>
            </div>
        </div>
    </div>

</x-layouts.game>