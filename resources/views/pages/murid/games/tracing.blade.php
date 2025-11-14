@extends('layouts.murid')

@section('title', 'Menulis Huruf - Tracing')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-300 to-green-400 rounded-3xl p-6 shadow-lg mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-white mb-2">Menulis Huruf</h1>
                    <p class="text-white text-lg font-light">
                        Ikuti garis titik-titik untuk menulis huruf hijaiyah!
                    </p>
                </div>
                <div class="text-right">
                    <div class="text-white text-sm">Huruf ke-</div>
                    <div class="text-5xl font-bold text-white" id="currentLetter">1</div>
                </div>
            </div>
        </div>
        
        <!-- Game Board -->
        <div class="bg-white rounded-3xl p-8 shadow-2xl mb-8">
            <div class="text-center mb-6">
                <p class="text-3xl font-bold text-gray-700 mb-2">Tulis huruf "<span id="hurufName">Alif</span>"</p>
                <p class="text-xl text-gray-500">Ikuti garis putus-putus</p>
            </div>
            
            <!-- Canvas untuk tracing -->
            <div class="bg-gradient-to-br from-pink-50 to-blue-50 rounded-2xl p-8 flex items-center justify-center" style="min-height: 400px;">
                <canvas id="tracingCanvas" width="600" height="400" 
                        class="border-4 border-pink-200 rounded-xl bg-white cursor-crosshair">
                </canvas>
            </div>
            
            <div class="flex justify-center gap-4 mt-6">
                <button onclick="clearCanvas()" class="btn-secondary px-6 py-2">
                    🗑️ Hapus
                </button>
                <button onclick="nextLetter()" class="btn-primary px-6 py-2">
                    Lanjut ➡️
                </button>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex justify-center gap-4">
            <button onclick="window.location.href='{{ route('murid.games.index', $tingkatan->tingkatan_id) }}'" 
                    class="btn-secondary px-8 py-3 text-xl">
                ← Selesai
            </button>
        </div>
        
    </div>
</div>

@push('scripts')
<script>
    const materiPembelajarans = @json($materiPembelajarans);
    const gameStaticId = {{ $gameStatic->game_static_id ?? 'null' }};
    const jenisGameId = {{ $gameStatic->jenis_game_id ?? 'null' }};
    
    let currentIndex = 0;
    let canvas, ctx;
    let isDrawing = false;
    let score = 0;
    
    function initCanvas() {
        canvas = document.getElementById('tracingCanvas');
        ctx = canvas.getContext('2d');
        
        drawDottedLetter();
        
        // Mouse events
        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('mouseout', stopDrawing);
        
        // Touch events
        canvas.addEventListener('touchstart', handleTouch);
        canvas.addEventListener('touchmove', handleTouch);
        canvas.addEventListener('touchend', stopDrawing);
    }
    
    function drawDottedLetter() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        // Draw dotted guide
        ctx.font = '200px Arial';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.setLineDash([5, 10]);
        ctx.strokeStyle = '#FFB6C1';
        ctx.lineWidth = 3;
        
        const letter = materiPembelajarans[currentIndex]?.moduls[0]?.teks_latin || 'A';
        ctx.strokeText(letter, canvas.width / 2, canvas.height / 2);
        ctx.setLineDash([]);
    }
    
    function startDrawing(e) {
        isDrawing = true;
        const rect = canvas.getBoundingClientRect();
        ctx.beginPath();
        ctx.moveTo(e.clientX - rect.left, e.clientY - rect.top);
    }
    
    function draw(e) {
        if (!isDrawing) return;
        
        const rect = canvas.getBoundingClientRect();
        ctx.lineTo(e.clientX - rect.left, e.clientY - rect.top);
        ctx.strokeStyle = '#E85A8B';
        ctx.lineWidth = 5;
        ctx.lineCap = 'round';
        ctx.stroke();
    }
    
    function stopDrawing() {
        isDrawing = false;
    }
    
    function handleTouch(e) {
        e.preventDefault();
        const touch = e.touches[0];
        const mouseEvent = new MouseEvent(e.type === 'touchstart' ? 'mousedown' : 'mousemove', {
            clientX: touch.clientX,
            clientY: touch.clientY
        });
        canvas.dispatchEvent(mouseEvent);
    }
    
    function clearCanvas() {
        drawDottedLetter();
    }
    
    function nextLetter() {
        score += 100;
        currentIndex++;
        
        if (currentIndex >= materiPembelajarans.length) {
            // Game complete
            showToast('Hebat! Semua huruf selesai! 🎉', 'success');
            saveScore();
            setTimeout(() => {
                window.location.href = '{{ route('murid.games.index', $tingkatan->tingkatan_id) }}';
            }, 2000);
            return;
        }
        
        document.getElementById('currentLetter').textContent = currentIndex + 1;
        document.getElementById('hurufName').textContent = materiPembelajarans[currentIndex].judul_materi;
        drawDottedLetter();
        showToast('Bagus! Lanjut ke huruf berikutnya! 👍', 'success');
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
        initCanvas();
        document.getElementById('hurufName').textContent = materiPembelajarans[0]?.judul_materi || 'Alif';
        document.getElementById('currentLetter').textContent = '1';
    });
</script>
@endpush

@endsection