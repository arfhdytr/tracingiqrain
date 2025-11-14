@extends('layouts.murid')

@section('title', 'Memory Card - Cocokkan Huruf')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-300 to-blue-400 rounded-3xl p-6 shadow-lg mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-white mb-2">Cocokkan Huruf</h1>
                    <p class="text-white text-lg font-light">
                        Temukan pasangan huruf hijaiyah dengan nama latinnya!
                    </p>
                </div>
                <div class="text-right">
                    <div class="text-white text-sm">Poin</div>
                    <div class="text-5xl font-bold text-white" id="score">0</div>
                </div>
            </div>
        </div>
        
        <!-- Game Stats -->
        <div class="flex justify-center gap-8 mb-8">
            <div class="text-center">
                <div class="text-pink-400 text-6xl mb-2">⏱️</div>
                <div class="text-3xl font-bold text-blue-900" id="timer">00:00</div>
            </div>
            <div class="text-center">
                <div class="text-pink-400 text-6xl mb-2">🎯</div>
                <div class="text-3xl font-bold text-blue-900"><span id="moves">0</span> gerakan</div>
            </div>
        </div>
        
        <!-- Game Board -->
        <div class="bg-gradient-to-br from-yellow-100 to-pink-100 rounded-3xl p-8 shadow-2xl mb-8">
            <div id="game-board" class="grid grid-cols-4 gap-4">
                <!-- Cards will be generated here -->
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex justify-center gap-4">
            <button onclick="window.location.href='{{ route('murid.games.index', $tingkatan->tingkatan_id) }}'" 
                    class="btn-secondary px-8 py-3 text-xl">
                ← Kembali
            </button>
            <button onclick="resetGame()" class="btn-primary px-8 py-3 text-xl">
                🔄 Main Lagi
            </button>
        </div>
        
    </div>
</div>

<!-- Win Modal -->
<div id="winModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-3xl p-8 max-w-md mx-4 shadow-2xl text-center">
        <div class="text-8xl mb-4">🎉</div>
        <h2 class="text-4xl font-bold text-pink-500 mb-4">Hebat!</h2>
        <p class="text-2xl text-gray-700 mb-2">Skor: <span id="finalScore" class="font-bold text-pink-500">0</span></p>
        <p class="text-xl text-gray-600 mb-6">Waktu: <span id="finalTime" class="font-bold">00:00</span></p>
        <button onclick="closeWinModal()" class="btn-primary px-8 py-3 text-xl">
            Oke! 👍
        </button>
    </div>
</div>

@push('scripts')
<script>
    const materiPembelajarans = @json($materiPembelajarans);
    const gameStaticId = {{ $gameStatic->game_static_id ?? 'null' }};
    const jenisGameId = {{ $gameStatic->jenis_game_id ?? 'null' }};
    
    let cards = [];
    let flippedCards = [];
    let matchedPairs = 0;
    let moves = 0;
    let score = 0;
    let timer = 0;
    let timerInterval;
    
    function initGame() {
        // Create card pairs (hijaiyah + latin)
        cards = [];
        materiPembelajarans.forEach((materi, index) => {
            if (index < 6) { // 6 pairs = 12 cards
                // Add hijaiyah card
                cards.push({
                    id: `h-${materi.materi_id}`,
                    pairId: materi.materi_id,
                    value: materi.judul_materi,
                    type: 'hijaiyah',
                    matched: false
                });
                // Add latin card
                cards.push({
                    id: `l-${materi.materi_id}`,
                    pairId: materi.materi_id,
                    value: materi.moduls[0]?.teks_latin || materi.judul_materi,
                    type: 'latin',
                    matched: false
                });
            }
        });
        
        // Shuffle cards
        cards = shuffleArray(cards);
        
        // Render cards
        renderCards();
        
        // Start timer
        startTimer();
    }
    
    function shuffleArray(array) {
        const newArray = [...array];
        for (let i = newArray.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [newArray[i], newArray[j]] = [newArray[j], newArray[i]];
        }
        return newArray;
    }
    
    function renderCards() {
        const gameBoard = document.getElementById('game-board');
        gameBoard.innerHTML = '';
        
        cards.forEach((card, index) => {
            const cardElement = document.createElement('div');
            cardElement.className = 'card bg-gradient-to-br from-pink-300 to-pink-400 rounded-2xl p-6 cursor-pointer transition-all duration-300 hover:scale-105';
            cardElement.dataset.index = index;
            cardElement.innerHTML = `
                <div class="card-inner relative" style="min-height: 100px;">
                    <div class="card-front absolute inset-0 flex items-center justify-center">
                        <div class="text-5xl">❓</div>
                    </div>
                    <div class="card-back absolute inset-0 flex items-center justify-center hidden">
                        <div class="text-4xl font-bold text-white">${card.value}</div>
                    </div>
                </div>
            `;
            
            cardElement.addEventListener('click', () => flipCard(index));
            gameBoard.appendChild(cardElement);
        });
    }
    
    function flipCard(index) {
        if (flippedCards.length >= 2 || cards[index].matched || flippedCards.includes(index)) {
            return;
        }
        
        const cardElements = document.querySelectorAll('.card');
        const cardElement = cardElements[index];
        const front = cardElement.querySelector('.card-front');
        const back = cardElement.querySelector('.card-back');
        
        front.classList.add('hidden');
        back.classList.remove('hidden');
        
        flippedCards.push(index);
        
        if (flippedCards.length === 2) {
            moves++;
            document.getElementById('moves').textContent = moves;
            
            setTimeout(checkMatch, 800);
        }
    }
    
    function checkMatch() {
        const [index1, index2] = flippedCards;
        const card1 = cards[index1];
        const card2 = cards[index2];
        
        if (card1.pairId === card2.pairId && card1.type !== card2.type) {
            // Match!
            card1.matched = true;
            card2.matched = true;
            matchedPairs++;
            score += 100;
            document.getElementById('score').textContent = score;
            
            // Mark as matched
            const cardElements = document.querySelectorAll('.card');
            cardElements[index1].classList.add('opacity-50');
            cardElements[index2].classList.add('opacity-50');
            
            if (matchedPairs === 6) {
                // Win!
                clearInterval(timerInterval);
                setTimeout(showWinModal, 500);
            }
        } else {
            // No match - flip back
            const cardElements = document.querySelectorAll('.card');
            const front1 = cardElements[index1].querySelector('.card-front');
            const back1 = cardElements[index1].querySelector('.card-back');
            const front2 = cardElements[index2].querySelector('.card-front');
            const back2 = cardElements[index2].querySelector('.card-back');
            
            front1.classList.remove('hidden');
            back1.classList.add('hidden');
            front2.classList.remove('hidden');
            back2.classList.add('hidden');
        }
        
        flippedCards = [];
    }
    
    function startTimer() {
        timer = 0;
        timerInterval = setInterval(() => {
            timer++;
            const minutes = Math.floor(timer / 60).toString().padStart(2, '0');
            const seconds = (timer % 60).toString().padStart(2, '0');
            document.getElementById('timer').textContent = `${minutes}:${seconds}`;
        }, 1000);
    }
    
    function showWinModal() {
        const finalScore = score - (moves * 5); // Deduct points for moves
        document.getElementById('finalScore').textContent = Math.max(0, finalScore);
        const minutes = Math.floor(timer / 60).toString().padStart(2, '0');
        const seconds = (timer % 60).toString().padStart(2, '0');
        document.getElementById('finalTime').textContent = `${minutes}:${seconds}`;
        document.getElementById('winModal').style.display = 'flex';
        
        // Save score
        saveScore(Math.max(0, finalScore));
    }
    
    function closeWinModal() {
        document.getElementById('winModal').style.display = 'none';
        window.location.href = '{{ route('murid.games.index', $tingkatan->tingkatan_id) }}';
    }
    
    async function saveScore(finalScore) {
        try {
            await fetchAPI('/murid/games/save-score', {
                method: 'POST',
                body: JSON.stringify({
                    jenis_game_id: jenisGameId,
                    game_static_id: gameStaticId,
                    skor: finalScore,
                    total_poin: finalScore
                })
            });
        } catch (error) {
            console.error('Error saving score:', error);
        }
    }
    
    function resetGame() {
        clearInterval(timerInterval);
        matchedPairs = 0;
        moves = 0;
        score = 0;
        flippedCards = [];
        document.getElementById('score').textContent = '0';
        document.getElementById('moves').textContent = '0';
        initGame();
    }
    
    // Initialize game on load
    document.addEventListener('DOMContentLoaded', initGame);
</script>
@endpush

@endsection