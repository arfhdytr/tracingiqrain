@extends('layouts.murid')

{{-- Judul halaman akan diambil dari $tingkatan --}}
@section('title', 'Games - Iqra ' . $tingkatan->level)

{{-- STYLES --}}
@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mooli&family=Titan+One&display=swap" rel="stylesheet">

    <style>
        /* Font Import */
        @import url('https://fonts.googleapis.com/css2?family=Titan+One&display=swap');
        
        @font-face {
            font-family: 'Tegak Bersambung_IWK';
            src: url("{{ asset('fonts/TegakBersambung_IWK.ttf') }}") format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        /* Utility Classes */
        .font-cursive-iwk {
            font-family: 'Tegak Bersambung_IWK', cursive !important;
        }

        .font-titan {
            font-family: 'Titan One', cursive !important;
        }

        .text-shadow-header {
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.25);
        }

        /* Background Pattern (pakai body aja, lebih aman) */
        body {
            background: linear-gradient(180deg, #56B1F3 0%, #D3F2FF 100%);
            background-attachment: fixed;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('images/games/game-pattern.webp') }}');
            background-size: 500px;
            background-repeat: repeat;
            background-position: center;
            opacity: 0.3;
            z-index: -1;
            pointer-events: none;
        }
        html {
        scroll-behavior: smooth;
        }
    </style>
@endpush

@section('content')

    {{-- MODAL POPUP (Tetap di atas untuk struktur yang benar) --}}
    <div id="gameModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50"
        style="display: none;">
        <div class="bg-gradient-to-br from-pink-200 to-pink-300 rounded-3xl p-8 max-w-md mx-4 shadow-2xl relative">
            <button onclick="closeGameModal()"
                class="absolute top-4 right-4 text-pink-600 hover:text-pink-800 text-3xl font-bold">
                &times;
            </button>

            <h3 class="text-3xl font-cursive-iwk text-pink-700 text-center mb-6">Cara Bermain</h3>

            <div class="space-y-3 mb-8">
                <div class="flex items-center gap-3">
                    <div class="bg-pink-500 text-white rounded-full w-10 h-10 flex items-center justify-center font-bold text-lg flex-shrink-0">1</div>
                    <p class="text-pink-900 font-cursive-iwk text-xl" id="step1">Klik tombol mulai untuk memulai permainan</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-pink-500 text-white rounded-full w-10 h-10 flex items-center justify-center font-bold text-lg flex-shrink-0">2</div>
                    <p class="text-pink-900 font-cursive-iwk text-xl" id="step2">Ikuti instruksi yang ada di layar</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-pink-500 text-white rounded-full w-10 h-10 flex items-center justify-center font-bold text-lg flex-shrink-0">3</div>
                    <p class="text-pink-900 font-cursive-iwk text-xl" id="step3">Selesaikan tantangan untuk mendapat poin</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-pink-500 text-white rounded-full w-10 h-10 flex items-center justify-center font-bold text-lg flex-shrink-0">4</div>
                    <p class="text-pink-900 font-cursive-iwk text-xl" id="step4">Lihat skormu di halaman evaluasi</p>
                </div>
            </div>

            <button onclick="startGame()"
                class="w-full text-2xl py-4 bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-white font-cursive-iwk rounded-xl shadow-lg">
                Mainkan!
            </button>
        </div>
    </div>

    {{-- HEADER WELCOMING --}}
    <div class="container mx-auto px-6 py-12">
        <div class="flex flex-col md:flex-row items-center justify-between gap-8">
            
            {{-- Text Header (KIRI) --}}
            <div class="md:w-1/2">
                <h1 class="font-titan text-[60px] lg:text-[80px] text-[#234275] leading-none">
                    Siap untuk Berpetualang?
                </h1>
                <h2 class="font-cursive-iwk text-[45px] lg:text-[55px] text-[#234275] leading-tight mt-2">
                    Mainkan dan Raih Skormu
                </h2>
            </div>
            
            {{-- Maskot Qira Game (KANAN) --}}
            <div class="md:w-1/2 flex justify-center md:justify-end">
                <img src="{{ asset('images/games/qira-game.webp') }}" alt="Qira Game" class="max-w-sm md:max-w-md">
            </div>
        </div>
    </div>

    {{-- GAME CARDS SECTION --}}
    <div class="container mx-auto px-6 pb-12">
        
        {{-- ✨ CONTAINER PUTIH (Untuk wrap semua game cards) ✨ --}}
        <div class="bg-white rounded-[40px] shadow-2xl p-8 md:p-12">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                {{-- Kartu 1: Kartu Memori (Biru) --}}
                <div class="block p-8 rounded-[20px] shadow-lg bg-[#6DC2FF] text-[#234275] transition-transform hover:scale-105 cursor-pointer"
                    onclick="showGameModal('memory-card')">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                        <div class="md:w-1/2 text-center md:text-left">
                            <h3 class="font-titan text-3xl mb-3">Kartu Memori</h3>
                            <p class="font-cursive-iwk text-3xl">
                                Yuk cocokin huruf yang sama. Buka kartunya dan ingat di mana hurufnya tersembunyi!
                            </p>
                        </div>
                        <div class="md:w-1/2 flex justify-center">
                            <img src="{{ asset('images/games/KartuMemori.webp') }}" alt="Kartu Memori" class="max-w-[180px]">
                        </div>
                    </div>
                </div>

                {{-- Kartu 2: Labirin Hijaiyah (Kuning) --}}
                <div class="block p-8 rounded-[20px] shadow-lg bg-[#FFCE6B] text-[#234275] transition-transform hover:scale-105 cursor-pointer"
                    onclick="showGameModal('labirin')">
                    <div class="flex flex-col md:flex-row-reverse items-center justify-between gap-6">
                        <div class="md:w-1/2 text-center md:text-left">
                            <h3 class="font-titan text-3xl mb-3">Labirin Hijaiyah</h3>
                            <p class="font-cursive-iwk text-3xl">
                                Temukan jalan menuju huruf hijaiyah yang dicari! Hati-hati jangan tersesat di labirin
                            </p>
                        </div>
                        <div class="md:w-1/2 flex justify-center">
                            <img src="{{ asset('images/games/LabirinHijaiyah.webp') }}" alt="Labirin Hijaiyah" class="max-w-[180px]">
                        </div>
                    </div>
                </div>

                {{-- Kartu 3: Seret & Lepas (Pink) --}}
                <div class="block p-8 rounded-[20px] shadow-lg bg-[#F387A9] text-[#234275] transition-transform hover:scale-105 cursor-pointer"
                    onclick="showGameModal('drag-drop')">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                        <div class="md:w-1/2 text-center md:text-left">
                            <h3 class="font-titan text-3xl mb-3">Seret & Lepas</h3>
                            <p class="font-cursive-iwk text-3xl">
                                Seret huruf hijaiyah ke tempat huruf latinnya yang cocok. Yuk, pasangkan dengan benar!
                            </p>
                        </div>
                        <div class="md:w-1/2 flex justify-center">
                            <img src="{{ asset('images/games/SeretLepas.webp') }}" alt="Seret & Lepas" class="max-w-[180px]">
                        </div>
                    </div>
                </div>

                {{-- Kartu 4: Tulis Huruf (Hijau) --}}
                <div class="block p-8 rounded-[20px] shadow-lg bg-[#BEFA70] text-[#234275] transition-transform hover:scale-105 cursor-pointer"
                    onclick="showGameModal('tracing')">
                    <div class="flex flex-col md:flex-row-reverse items-center justify-between gap-6">
                        <div class="md:w-1/2 text-center md:text-left">
                            <h3 class="font-titan text-3xl mb-3">Tulis Huruf</h3>
                            <p class="font-cursive-iwk text-3xl">
                                Ikuti garis titik-titik dan tulis huruf hijaiyah dengan rapi. Yuk belajar menulis sambil bermain!
                            </p>
                        </div>
                        <div class="md:w-1/2 flex justify-center">
                            <img src="{{ asset('images/games/TulisHuruf.webp') }}" alt="Tulis Huruf" class="max-w-[180px]">
                        </div>
                    </div>
                </div>

            </div> {{-- Tutup grid --}}
            
        </div> {{-- Tutup container putih --}}
        
    </div> {{-- Tutup container mx-auto --}}

@endsection

{{-- SCRIPTS --}}
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
                'memory-card': `{{ route('murid.games.memory-card', ['tingkatan_id' => $tingkatan->tingkatan_id]) }}`,
                'labirin': `{{ route('murid.games.labirin', ['tingkatan_id' => $tingkatan->tingkatan_id]) }}`,
                'drag-drop': `{{ route('murid.games.drag-drop', ['tingkatan_id' => $tingkatan->tingkatan_id]) }}`,
                'tracing': `{{ route('murid.games.tracing', ['tingkatan_id' => $tingkatan->tingkatan_id]) }}`
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
