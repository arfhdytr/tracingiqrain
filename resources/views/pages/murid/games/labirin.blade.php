@extends('layouts.murid')

@section('title', 'Labirin Hijaiyah')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-yellow-300 to-yellow-400 rounded-3xl p-6 shadow-lg mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-white mb-2">Labirin Huruf</h1>
                    <p class="text-white text-lg font-light">
                        Bantu Qira menemukan huruf yang dicari!
                    </p>
                </div>
                <div class="text-right">
                    <div class="text-white text-sm">Poin</div>
                    <div class="text-5xl font-bold text-white" id="score">0</div>
                </div>
            </div>
        </div>
        
        <!-- Target Letter -->
        <div class="text-center mb-6">
            <p class="text-2xl text-gray-600 mb-2">Cari huruf:</p>
            <div class="inline-block bg-gradient-to-br from-pink-300 to-pink-400 rounded-2xl px-8 py-4">
                <span class="text-6xl font-bold text-white" id="targetLetter">ا</span>
            </div>
        </div>
        
        <!-- Game Board -->
        <div class="bg-gradient-to-br from-blue-50 to-pink-50 rounded-3xl p-8 shadow-2xl mb-8">
            <div id="maze-container" class="grid grid-cols-10 gap-1 max-w-2xl mx-auto">
                <!-- Maze will be generated here -->
            </div>
        </div>
        
        <!-- Controls -->
        <div class="text-center mb-6">
            <p class="text-xl text-gray-600 mb-4">Gunakan tombol panah untuk bergerak:</p>
            <div class="inline-grid grid-cols-3 gap-2">
                <div></div>
                <button onclick="move('up')" class="bg-blue-400 hover:bg-blue-500 text-white rounded-xl p-4 text-3xl">
                    ⬆️
                </button>
                <div></div>
                <button onclick="move('left')" class="bg-blue-400 hover:bg-blue-500 text-white rounded-xl p-4 text-3xl">
                    ⬅️
                </button>
                <div></div>
                <button onclick="move('right')" class="bg-blue-400 hover:bg-blue-500 text-white rounded-xl p-4 text-3xl">
                    ➡️
                </button>
                <div></div>
                <button onclick="move('down')" class="bg-blue-400 hover:bg-blue-500 text-white rounded-xl p-4 text-3xl">
                    ⬇️
                </button>
                <div></div>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex justify-center gap-4">
            <button onclick="window.location.href='{{ route('murid.games.index', $tingkatan->tingkatan_id) }}'" 
                    class="btn-secondary px-8 py-3 text-xl">
                ← Kembali
            </button>
            <button onclick="resetMaze()" class="btn-primary px-8 py-3 text-xl">
                🔄 Main Lagi
            </button>
        </div>
        
    </div>
</div>

@push('scripts')
<script>
    const materiPembelajarans = @json($materiPembelajarans);
    const gameStaticId = {{ $gameStatic->game_static_id ?? 'null' }};
    const jenisGameId = {{ $gameStatic->jenis_game_id ?? 'null' }};
    
    const MAZE_SIZE = 10;
    let maze = [];
    let playerPos = { x: 0, y: 0 };
    let targetPos = { x: 0, y: 0 };
    let currentMateriIndex = 0;
    let score = 0;
    let moves = 0;
    
    function generateMaze() {
        maze = Array(MAZE_SIZE).fill().map(() => Array(MAZE_SIZE).fill('path'));
        
        // Add some walls randomly
        for (let i = 0; i < 20; i++) {
            const x = Math.floor(Math.random() * MAZE_SIZE);
            const y = Math.floor(Math.random() * MAZE_SIZE);
            if ((x !== 0 || y !== 0) && (x !== MAZE_SIZE-1 || y !== MAZE_SIZE-1)) {
                maze[y][x] = 'wall';
            }
        }
        
        // Set player and target
        playerPos = { x: 0, y: 0 };
        targetPos = { 
            x: MAZE_SIZE - 1, 
            y: MAZE_SIZE - 1 
        };
        
        maze[playerPos.y][playerPos.x] = 'player';
        maze[targetPos.y][targetPos.x] = 'target';
        
        renderMaze();
    }
    
    function renderMaze() {
        const container = document.getElementById('maze-container');
        container.innerHTML = '';
        
        for (let y = 0; y < MAZE_SIZE; y++) {
            for (let x = 0; x < MAZE_SIZE; x++) {
                const cell = document.createElement('div');
                cell.className = 'maze-cell w-12 h-12 rounded flex items-center justify-center text-2xl';
                
                if (x === playerPos.x && y === playerPos.y) {
                    cell.className += ' bg-blue-400';
                    cell.textContent = '🐘'; // Qira
                } else if (x === targetPos.x && y === targetPos.y) {
                    cell.className += ' bg-pink-400';
                    cell.textContent = materiPembelajarans[currentMateriIndex]?.moduls[0]?.teks_latin || 'A';
                } else if (maze[y][x] === 'wall') {
                    cell.className += ' bg-gray-600';
                    cell.textContent = '🧱';
                } else {
                    cell.className += ' bg-white border border-gray-200';
                }
                
                container.appendChild(cell);
            }
        }
    }
    
    function move(direction) {
        let newX = playerPos.x;
        let newY = playerPos.y;
        
        switch(direction) {
            case 'up': newY--; break;
            case 'down': newY++; break;
            case 'left': newX--; break;
            case 'right': newX++; break;
        }
        
        // Check bounds
        if (newX < 0 || newX >= MAZE_SIZE || newY < 0 || newY >= MAZE_SIZE) {
            return;
        }
        
        // Check walls
        if (maze[newY][newX] === 'wall') {
            return;
        }
        
        // Move player
        playerPos.x = newX;
        playerPos.y = newY;
        moves++;
        
        // Check if reached target
        if (newX === targetPos.x && newY === targetPos.y) {
            score += Math.max(50, 200 - moves);
            document.getElementById('score').textContent = score;
            showToast('Hebat! Huruf ditemukan! 🎉', 'success');
            
            currentMateriIndex++;
            moves = 0;
            
            if (currentMateriIndex >= materiPembelajarans.length) {
                // Game complete
                setTimeout(() => {
                    showToast('Semua huruf berhasil ditemukan! 🏆', 'success');
                    saveScore();
                    setTimeout(() => {
                        window.location.href = '{{ route('murid.games.index', $tingkatan->tingkatan_id) }}';
                    }, 2000);
                }, 500);
                return;
            }
            
            setTimeout(() => {
                document.getElementById('targetLetter').textContent = materiPembelajarans[currentMateriIndex]?.moduls[0]?.teks_latin || 'A';
                generateMaze();
            }, 1000);
        } else {
            renderMaze();
        }
    }
    
    // Keyboard controls
    document.addEventListener('keydown', (e) => {
        switch(e.key) {
            case 'ArrowUp': move('up'); break;
            case 'ArrowDown': move('down'); break;
            case 'ArrowLeft': move('left'); break;
            case 'ArrowRight': move('right'); break;
        }
    });
    
    function resetMaze() {
        currentMateriIndex = 0;
        score = 0;
        moves = 0;
        document.getElementById('score').textContent = '0';
        document.getElementById('targetLetter').textContent = materiPembelajarans[0]?.moduls[0]?.teks_latin || 'A';
        generateMaze();
    }
    
    async function saveScore() {
        try {
            await fetchAPI('/murid/games/save-score', {
                method: 'POST',
                body: JSON.stringify({
                    jenis_game_id: jenisGameId,
                    game_static_id: gameStaticId,
                    skor: score,
                    total_poin: score
                })
            });
        } catch (error) {
            console.error('Error saving score:', error);
        }
    }
    
    // Initialize
    document.addEventListener('DOMContentLoaded', () => {
        generateMaze();
        document.getElementById('targetLetter').textContent = materiPembelajarans[0]?.moduls[0]?.teks_latin || 'A';
    });
</script>
@endpush

@endsection