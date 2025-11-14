@extends('layouts.murid')

@section('title', 'Pasangkan Huruf - Drag & Drop')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-pink-300 to-pink-400 rounded-3xl p-6 shadow-lg mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-white mb-2">Pasangkan Huruf</h1>
                    <p class="text-white text-lg font-light">
                        Tarik huruf hijaiyah sesuai dengan huruf latinnya!
                    </p>
                </div>
                <div class="text-right">
                    <div class="text-white text-sm">Poin</div>
                    <div class="text-5xl font-bold text-white" id="score">0</div>
                </div>
            </div>
        </div>
        
        <!-- Progress -->
        <div class="text-center mb-6">
            <div class="text-3xl font-bold text-blue-900">
                Soal <span id="currentQuestion">1</span> dari <span id="totalQuestions">{{ $soals->count() }}</span>
            </div>
        </div>
        
        <!-- Game Board -->
        <div class="bg-gradient-to-br from-yellow-100 to-pink-100 rounded-3xl p-12 shadow-2xl mb-8">
            <div id="question-container">
                <!-- Question will be rendered here -->
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex justify-center gap-4">
            <button onclick="window.location.href='{{ route('murid.games.index', $tingkatan->tingkatan_id) }}'" 
                    class="btn-secondary px-8 py-3 text-xl">
                ← Kembali
            </button>
        </div>
        
    </div>
</div>

<!-- Result Modal -->
<div id="resultModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-3xl p-8 max-w-md mx-4 shadow-2xl text-center">
        <div id="resultEmoji" class="text-8xl mb-4">🎉</div>
        <h2 id="resultTitle" class="text-4xl font-bold text-pink-500 mb-4">Selesai!</h2>
        <p class="text-2xl text-gray-700 mb-2">Skor Akhir: <span id="finalScore" class="font-bold text-pink-500">0</span></p>
        <p class="text-xl text-gray-600 mb-6">Benar: <span id="correctCount">0</span> / <span id="totalCount">0</span></p>
        <button onclick="closeResultModal()" class="btn-primary px-8 py-3 text-xl">
            Oke! 👍
        </button>
    </div>
</div>

@push('scripts')
<script>
    const soals = @json($soals);
    const jenisGameId = {{ $jenisGame->jenis_game_id ?? 'null' }};
    
    let currentQuestionIndex = 0;
    let score = 0;
    let correctAnswers = 0;
    let selectedOption = null;
    
    function renderQuestion() {
        if (currentQuestionIndex >= soals.length) {
            showResult();
            return;
        }
        
        const soal = soals[currentQuestionIndex];
        const container = document.getElementById('question-container');
        
        const options = [soal.opsi_a, soal.opsi_b, soal.opsi_c, soal.opsi_d];
        const shuffledOptions = shuffleArray(options.map((opt, idx) => ({
            value: opt,
            letter: String.fromCharCode(65 + idx)
        })));
        
        container.innerHTML = `
            <div class="grid grid-cols-2 gap-8">
                <!-- Left: Huruf Hijaiyah -->
                <div class="bg-white rounded-3xl p-8 shadow-lg">
                    <p class="text-2xl text-gray-600 mb-4 text-center">Huruf Hijaiyah</p>
                    <div class="bg-gradient-to-br from-pink-200 to-pink-100 rounded-2xl p-8 text-center">
                        <div class="text-8xl font-bold text-pink-600">${soal.opsi_a}</div>
                    </div>
                </div>
                
                <!-- Right: Huruf Latin Options -->
                <div>
                    <p class="text-2xl text-gray-600 mb-4 text-center">Pilih Huruf Latin</p>
                    <div class="grid grid-cols-2 gap-4">
                        ${shuffledOptions.map((opt, idx) => `
                            <button onclick="selectOption('${opt.letter}', '${opt.value}')" 
                                    class="option-btn bg-gradient-to-br from-pink-300 to-pink-200 hover:from-pink-400 hover:to-pink-300 rounded-2xl p-6 text-4xl font-bold text-pink-700 transition-all duration-300 hover:scale-105 shadow-lg"
                                    data-option="${opt.letter}">
                                ${opt.value}
                            </button>
                        `).join('')}
                    </div>
                </div>
            </div>
        `;
        
        document.getElementById('currentQuestion').textContent = currentQuestionIndex + 1;
        document.getElementById('totalQuestions').textContent = soals.length;
    }
    
    function selectOption(letter, value) {
        const soal = soals[currentQuestionIndex];
        const isCorrect = letter === soal.jawaban_benar;
        
        if (isCorrect) {
            score += 100;
            correctAnswers++;
            showFeedback(true);
        } else {
            showFeedback(false);
        }
        
        document.getElementById('score').textContent = score;
        
        setTimeout(() => {
            currentQuestionIndex++;
            renderQuestion();
        }, 1500);
    }
    
    function showFeedback(isCorrect) {
        const feedback = document.createElement('div');
        feedback.className = `fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-8xl z-50 animate-bounce`;
        feedback.textContent = isCorrect ? '✅' : '❌';
        document.body.appendChild(feedback);
        
        setTimeout(() => feedback.remove(), 1000);
    }
    
    function showResult() {
        document.getElementById('finalScore').textContent = score;
        document.getElementById('correctCount').textContent = correctAnswers;
        document.getElementById('totalCount').textContent = soals.length;
        
        const percentage = (correctAnswers / soals.length) * 100;
        if (percentage >= 80) {
            document.getElementById('resultEmoji').textContent = '🎉';
            document.getElementById('resultTitle').textContent = 'Luar Biasa!';
        } else if (percentage >= 60) {
            document.getElementById('resultEmoji').textContent = '😊';
            document.getElementById('resultTitle').textContent = 'Bagus!';
        } else {
            document.getElementById('resultEmoji').textContent = '💪';
            document.getElementById('resultTitle').textContent = 'Ayo Coba Lagi!';
        }
        
        document.getElementById('resultModal').style.display = 'flex';
        
        // Save score
        saveScore();
    }
    
    function closeResultModal() {
        window.location.href = '{{ route('murid.games.index', $tingkatan->tingkatan_id) }}';
    }
    
    async function saveScore() {
        try {
            await fetchAPI('/murid/games/save-score', {
                method: 'POST',
                body: JSON.stringify({
                    jenis_game_id: jenisGameId,
                    skor: score,
                    total_poin: score
                })
            });
        } catch (error) {
            console.error('Error saving score:', error);
        }
    }
    
    function shuffleArray(array) {
        const newArray = [...array];
        for (let i = newArray.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [newArray[i], newArray[j]] = [newArray[j], newArray[i]];
        }
        return newArray;
    }
    
    // Initialize
    document.addEventListener('DOMContentLoaded', renderQuestion);
</script>
@endpush

@endsection