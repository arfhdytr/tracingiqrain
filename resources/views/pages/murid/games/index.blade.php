@extends('layouts.murid')

@section('title', 'Games - Iqra ' . $tingkatan->level)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="text-5xl">🎮</div>
                <h1 class="text-5xl font-bold text-blue-900">Siap untuk<br>Berpetualang?</h1>
                <div class="w-48">
                    <img src="{{ asset('images/qira-reading.png') }}" alt="Qira" class="w-full"
                         onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Ctext y=%22.9em%22 font-size=%2290%22%3E🐘📚%3C/text%3E%3C/svg%3E'">
                </div>
            </div>
            <p class="text-2xl text-blue-800 italic font-light">Mainkan dan Raih Skormu</p>
        </div>
        
        <!-- Game Grid -->
        <div class="grid grid-cols-2 gap-6">
            
            <!-- Memory Card Game -->
            <div class="bg-gradient-to-br from-blue-300 to-blue-400 rounded-3xl p-8 shadow-xl hover:scale-105 transition-transform duration-300 cursor-pointer"
                 onclick="showGameModal('memory-card')">
                <div class="text-center">
                    <div class="text-7xl mb-4">🎴</div>
                    <h3 class="text-3xl font-bold text-white mb-3">Kartu Memori</h3>
                    <p class="text-white text-lg font-light leading-relaxed">
                        Uji ingatan huruf yang sama.<br>
                        Buka kartunya dan ingat di<br>
                        mana hurufnya bersembunyi!
                    </p>
                </div>
            </div>
            
            <!-- Labirin Game -->
            <div class="bg-gradient-to-br from-yellow-300 to-yellow-400 rounded-3xl p-8 shadow-xl hover:scale-105 transition-transform duration-300 cursor-pointer"
                 onclick="showGameModal('labirin')">
                <div class="text-center">
                    <div class="text-7xl mb-4">🎯</div>
                    <h3 class="text-3xl font-bold text-white mb-3">Labirin Hijaiyah</h3>
                    <p class="text-white text-lg font-light leading-relaxed">
                        Temukan jalan menuju huruf<br>
                        hijaiyahmu yang dicari! Hati-hati<br>
                        jangan tersesat di labirin
                    </p>
                </div>
            </div>
            
            <!-- Drag & Drop Game -->
            <div class="bg-gradient-to-br from-pink-300 to-pink-400 rounded-3xl p-8 shadow-xl hover:scale-105 transition-transform duration-300 cursor-pointer"
                 onclick="showGameModal('drag-drop')">
                <div class="text-center">
                    <div class="text-7xl mb-4">🧩</div>
                    <h3 class="text-3xl font-bold text-white mb-3">Seret & Lepas</h3>
                    <p class="text-white text-lg font-light leading-relaxed">
                        Seret huruf hijaiyah ke tempat<br>
                        huruf latinnya yang cocok.<br>
                        Yuk pasangkan dengan benar!
                    </p>
                </div>
            </div>
            
            <!-- Tracing Game -->
            <div class="bg-gradient-to-br from-green-300 to-green-400 rounded-3xl p-8 shadow-xl hover:scale-105 transition-transform duration-300 cursor-pointer"
                 onclick="showGameModal('tracing')">
                <div class="text-center">
                    <div class="text-7xl mb-4">✏️</div>
                    <h3 class="text-3xl font-bold text-white mb-3">Tulis Huruf</h3>
                    <p class="text-white text-lg font-light leading-relaxed">
                        Ikuti garis titik-titik dan tulis<br>
                        huruf hijaiyahnya dengan rapi.<br>
                        Yuk belajar menulis sambil bermain!
                    </p>
                </div>
            </div>
            
        </div>
        
    </div>
</div>

<!-- Modal Instruksi -->
<div id="gameModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" style="display: none;">
    <div class="bg-gradient-to-br from-pink-200 to-pink-300 rounded-3xl p-8 max-w-md mx-4 shadow-2xl relative">
        <button onclick="closeGameModal()" class="absolute top-4 right-4 text-pink-600 hover:text-pink-800 text-3xl font-bold">
            ×
        </button>
        
        <h3 class="text-3xl font-bold text-pink-700 text-center mb-6">Cara Bermain</h3>
        
        <div class="space-y-3 mb-8">
            <div class="flex items-center gap-3">
                <div class="bg-pink-500 text-white rounded-full w-10 h-10 flex items-center justify-center font-bold text-lg flex-shrink-0">1</div>
                <p class="text-pink-900 font-medium" id="step1">Klik tombol mulai untuk memulai permainan</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-pink-500 text-white rounded-full w-10 h-10 flex items-center justify-center font-bold text-lg flex-shrink-0">2</div>
                <p class="text-pink-900 font-medium" id="step2">Ikuti instruksi yang ada di layar</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-pink-500 text-white rounded-full w-10 h-10 flex items-center justify-center font-bold text-lg flex-shrink-0">3</div>
                <p class="text-pink-900 font-medium" id="step3">Selesaikan tantangan untuk mendapat poin</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-pink-500 text-white rounded-full w-10 h-10 flex items-center justify-center font-bold text-lg flex-shrink-0">4</div>
                <p class="text-pink-900 font-medium" id="step4">Lihat skormu di halaman evaluasi</p>
            </div>
        </div>
        
        <button onclick="startGame()" class="btn-primary w-full text-2xl py-4 bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600">
            Mainkan! 🎮
        </button>
    </div>
</div>

@push('scripts')
<script>
    let selectedGame = '';
    const tingkatanId = {{ $tingkatan->tingkatan_id }};
    
    const gameInstructions = {
        'memory-card': {
            step1: 'Klik kartu untuk membuka dan lihat hurufnya',
            step2: 'Cari pasangan huruf yang sama',
            step3: 'Cocokkan semua pasangan untuk menang',
            step4: 'Semakin cepat, semakin tinggi skormu!'
        },
        'labirin': {
            step1: 'Gunakan tombol panah untuk bergerak',
            step2: 'Cari huruf yang diminta di labirin',
            step3: 'Hindari jalan buntu dan temukan jalan keluar',
            step4: 'Kumpulkan semua huruf untuk menyelesaikan level'
        },
        'drag-drop': {
            step1: 'Lihat huruf hijaiyah di layar',
            step2: 'Seret huruf ke huruf latin yang cocok',
            step3: 'Lepaskan di tempat yang benar',
            step4: 'Jawab semua soal dengan benar!'
        },
        'tracing': {
            step1: 'Lihat huruf yang akan kamu tulis',
            step2: 'Ikuti garis titik-titik dengan jarimu',
            step3: 'Tulis dengan rapi mengikuti panduan',
            step4: 'Selesaikan semua huruf untuk lanjut!'
        }
    };
    
    function showGameModal(gameType) {
        selectedGame = gameType;
        const modal = document.getElementById('gameModal');
        const instructions = gameInstructions[gameType];
        
        // Update instructions
        document.getElementById('step1').textContent = instructions.step1;
        document.getElementById('step2').textContent = instructions.step2;
        document.getElementById('step3').textContent = instructions.step3;
        document.getElementById('step4').textContent = instructions.step4;
        
        modal.style.display = 'flex';
    }
    
    function closeGameModal() {
        document.getElementById('gameModal').style.display = 'none';
    }
    
    function startGame() {
        const gameUrls = {
            'memory-card': `/murid/games/${tingkatanId}/memory-card`,
            'labirin': `/murid/games/${tingkatanId}/labirin`,
            'drag-drop': `/murid/games/${tingkatanId}/drag-drop`,
            'tracing': `/murid/games/${tingkatanId}/tracing`
        };
        
        window.location.href = gameUrls[selectedGame];
    }
    
    // Close modal on outside click
    document.getElementById('gameModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeGameModal();
        }
    });
    
    // Initialize
    sessionStorage.setItem('current_tingkatan_id', tingkatanId);
</script>
@endpush

@endsection