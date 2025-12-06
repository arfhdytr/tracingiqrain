@extends('layouts.murid')

{{-- Judul halaman diambil dari $tingkatan --}}
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

        /* Background Pattern */
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
            background-image: url("{{ asset('images/games/game-pattern.webp') }}");
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

        /* Animasi Goyang */
        @keyframes wiggle {
            0%, 100% { transform: rotate(-3deg); }
            50% { transform: rotate(3deg); }
        }

        .btn-goyang {
            background-color: #AC3F61;
            animation: wiggle 0.8s ease-in-out infinite;
        }

        .btn-goyang:hover {
            background-color: #963653;
            animation: none;
            transform: scale(1.05);
        }
    </style>
    
@endpush

{{-- 2. Konten Utama --}}
@section('content')

    {{-- ========================================= --}}
    {{-- MODAL POP-UP (VIDEO + LANGKAH) --}}
    {{-- ========================================= --}}
    <div id="gameModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" style="display: none;">

        {{-- Container Modal --}}
        <div class="bg-gradient-to-br from-pink-100 to-white rounded-[30px] p-1 w-full max-w-5xl mx-4 shadow-2xl relative">

            {{-- Tombol Close --}}
            <button onclick="closeGameModal()"
                class="absolute -top-4 -right-4 bg-pink-500 text-white w-10 h-10 rounded-full hover:bg-pink-600 text-2xl font-bold shadow-lg flex items-center justify-center z-10 transition-transform hover:scale-110">
                &times;
            </button>

            {{-- Konten Modal (Putih) --}}
            <div class="bg-white rounded-[26px] p-6 md:p-8 overflow-y-auto max-h-[90vh]">
                
                {{-- Judul Game --}}
                <h3 class="text-3xl md:text-4xl font-titan text-[#234275] text-center mb-6" id="modalGameTitle">
                    Panduan Bermain
                </h3>

                {{-- Layout Grid: Kiri Video, Kanan Teks --}}
                <div class="flex flex-col lg:flex-row gap-8 mb-8">

                    {{-- BAGIAN KIRI: VIDEO --}}
                    <div class="w-full lg:w-1/2 flex flex-col justify-center">
                        <div class="relative w-full pt-[56.25%] rounded-2xl overflow-hidden shadow-lg border-2 border-gray-100 bg-black">
                            <iframe id="gameVideoIframe" class="absolute top-0 left-0 w-full h-full" src=""
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen>
                            </iframe>
                        </div>
                        <p class="text-center text-gray-500 mt-3 font-cursive-iwk text-lg">
                            Tonton video untuk panduan lengkap
                        </p>
                    </div>

                    {{-- BAGIAN KANAN: LANGKAH-LANGKAH --}}
                    <div class="w-full lg:w-1/2 flex flex-col justify-center">
                        <div class="space-y-4">
                            {{-- Step 1 --}}
                            <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-pink-50 transition-colors">
                                <div class="bg-pink-500 text-white rounded-full w-12 h-12 flex items-center justify-center font-nanum text-2xl flex-shrink-0 shadow-md">1</div>
                                <p class="text-pink-900 font-cursive-iwk text-2xl leading-snug pt-1" id="step1"></p>
                            </div>

                            {{-- Step 2 --}}
                            <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-pink-50 transition-colors">
                                <div class="bg-pink-500 text-white rounded-full w-12 h-12 flex items-center justify-center font-nanum text-2xl flex-shrink-0 shadow-md">2</div>
                                <p class="text-pink-900 font-cursive-iwk text-2xl leading-snug pt-1" id="step2"></p>
                            </div>

                            {{-- Step 3 --}}
                            <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-pink-50 transition-colors">
                                <div class="bg-pink-500 text-white rounded-full w-12 h-12 flex items-center justify-center font-nanum text-2xl flex-shrink-0 shadow-md">3</div>
                                <p class="text-pink-900 font-cursive-iwk text-2xl leading-snug pt-1" id="step3"></p>
                            </div>

                            {{-- Step 4 --}}
                            <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-pink-50 transition-colors">
                                <div class="bg-pink-500 text-white rounded-full w-12 h-12 flex items-center justify-center font-nanum text-2xl flex-shrink-0 shadow-md">4</div>
                                <p class="text-pink-900 font-cursive-iwk text-2xl leading-snug pt-1" id="step4"></p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol Main --}}
                <div class="flex justify-center">
                    <button onclick="startGame()"
                        class="btn-goyang w-full md:w-1/2 lg:w-1/3 text-2xl md:text-3xl py-4 text-white font-cursive-iwk rounded-2xl shadow-lg transition-transform duration-200 hover:shadow-xl cursor-pointer">
                        Mainkan Sekarang!
                    </button>
                </div>

            </div> {{-- End Inner White Box --}}
        </div> {{-- End Modal Container --}}
    </div>

    {{-- ========================================= --}}
    {{-- HEADER HALAMAN --}}
    {{-- ========================================= --}}
    <div class="container mx-auto px-4 pt-8 pb-12">
        <div class="flex flex-col md:flex-row items-center justify-center gap-4 md:gap-12 max-w-6xl mx-auto">

            {{-- Maskot Qira Game (KIRI) --}}
            <div class="w-[180px] md:w-[280px] transform hover:rotate-3 transition-transform duration-500">
                <img src="{{ asset('images/games/qira-game.webp') }}" alt="Qira Game" class="w-full h-auto drop-shadow-2xl">
            </div>

            {{-- Text Header (KANAN) --}}
            <div class="text-center md:text-left">
                <h1 class="font-titan text-[40px] md:text-[55px] text-[#234275] leading-tight mb-2 text-shadow-header">
                    Siap untuk Berpetualang?
                </h1>
                <p class="text-[35px] md:text-[40px] text-[#234275] my-5 leading-none text-shadow-header">
                    <span class="font-cursive-iwk phrase-biru-tua">Mainkan</span>
                    <span class="font-cursive-iwk phrase-biru-tua">dan</span>
                    <span class="font-cursive-iwk phrase-biru-tua">Raih</span>
                    <span class="font-cursive-iwk phrase-biru-tua">Skormu!</span>
                </p>
            </div>
        </div>
    </div>

    {{-- ========================================= --}}
    {{-- GRID PILIHAN GAME --}}
    {{-- ========================================= --}}
    <div class="container mx-auto px-6 pb-20">
        
        {{-- ✨ CONTAINER PUTIH (Untuk wrap semua game cards) ✨ --}}
        <div class="bg-white rounded-[40px] shadow-2xl p-5 md:p-10 max-w-7xl mx-auto">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Kartu 1: Kartu Memori (Biru) --}}
                <div class="block p-5 md:p-6 rounded-[20px] shadow-lg bg-[#6DC2FF] text-[#234275] transition-transform hover:scale-105 cursor-pointer"
                    onclick="showGameModal('memory-card')">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-4 h-full">
                        <div class="md:w-1/2 text-center md:text-left">
                            <h3 class="font-titan text-2xl md:text-3xl mb-2">Kartu Memori</h3>
                            <p class="leading-tight">
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">Yuk</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">cocokin</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">huruf</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">yang</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">sama.</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">Buka</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">kartunya</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">dan</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">ingat</span>
                                <span class="font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">letaknya</span>
                                <span class="font-nanum text-xl md:text-3xl">!</span>
                            </p>
                        </div>
                        <div class="md:w-1/2 flex justify-center">
                            <img src="{{ asset('images/games/KartuMemori.webp') }}" alt="Kartu Memori" class="max-w-[140px] md:max-w-[160px]">
                        </div>
                    </div>
                </div>

                {{-- Kartu 2: Labirin Hijaiyah (Kuning) --}}
                <div class="block p-5 md:p-6 rounded-[20px] shadow-lg bg-[#FFCE6B] text-[#234275] transition-transform hover:scale-105 cursor-pointer"
                    onclick="showGameModal('labirin')">
                    <div class="flex flex-col md:flex-row-reverse items-center justify-between gap-4 h-full">
                        <div class="md:w-1/2 text-center md:text-left">
                            <h3 class="font-titan text-2xl md:text-3xl mb-2">Labirin Hijaiyah</h3>
                            <p class="leading-tight">
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">Temukan</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">jalan</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">menuju</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">huruf</span>
                                <span class="font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">hijaiyah</span>
                                <span class="mr-2 font-nanum text-xl md:text-3xl">!</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">Hati</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl">-</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">hati</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">jangan</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">tersesat.</span>
                            </p>
                        </div>
                        <div class="md:w-1/2 flex justify-center">
                            <img src="{{ asset('images/games/LabirinHijaiyah.webp') }}" alt="Labirin Hijaiyah" class="max-w-[140px] md:max-w-[160px]">
                        </div>
                    </div>
                </div>

                {{-- Kartu 3: Seret & Lepas (Pink) --}}
                <div class="block p-5 md:p-6 rounded-[20px] shadow-lg bg-[#F387A9] text-[#234275] transition-transform hover:scale-105 cursor-pointer"
                    onclick="showGameModal('drag-drop')">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-4 h-full">
                        <div class="md:w-1/2 text-center md:text-left">
                            <h3 class="font-titan text-2xl md:text-3xl mb-2">Seret & Lepas</h3>
                            <p class="leading-tight">
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">Seret</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">huruf</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">hijaiyah</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">ke</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">tempat</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">yang</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">cocok.</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">Pasangkan</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">dengan</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">benar</span>
                                <span class="font-nanum text-xl md:text-3xl">!</span>
                            </p>
                        </div>
                        <div class="md:w-1/2 flex justify-center">
                            <img src="{{ asset('images/games/SeretLepas.webp') }}" alt="Seret & Lepas" class="max-w-[140px] md:max-w-[160px]">
                        </div>
                    </div>
                </div>

                {{-- Kartu 4: Tulis Huruf (Hijau) --}}
                <div class="block p-5 md:p-6 rounded-[20px] shadow-lg bg-[#BEFA70] text-[#234275] transition-transform hover:scale-105 cursor-pointer"
                    onclick="showGameModal('tracing')">
                    <div class="flex flex-col md:flex-row-reverse items-center justify-between gap-4 h-full">
                        <div class="md:w-1/2 text-center md:text-left">
                            <h3 class="font-titan text-2xl md:text-3xl mb-2">Tulis Huruf</h3>
                            <p class="leading-tight">
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">Ikuti</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">garis</span>
                                <span class="font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">titik</span>
                                <span class="font-cursive-iwk text-xl md:text-3xl">-</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">titik</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">dan</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">tulis</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">huruf</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">hijaiyah</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">dengan</span>
                                <span class="mr-1 font-cursive-iwk text-xl md:text-3xl phrase-biru-tua">rapi.</span>
                            </p>
                        </div>
                        <div class="md:w-1/2 flex justify-center">
                            <img src="{{ asset('images/games/TulisHuruf.webp') }}" alt="Tulis Huruf" class="max-w-[140px] md:max-w-[160px]">
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
        // Pastikan variabel PHP dirender dengan aman
        const tingkatanId = "{{ $tingkatan->tingkatan_id }}";

        const gameData = {
            'memory-card': {
                title: 'Panduan Kartu Memori',
                videoId: 'dQw4w9WgXcQ', // GANTI DENGAN ID YOUTUBE ASLI
                steps: [
                    'Klik kartu untuk membuka dan lihat hurufnya',
                    'Cari pasangan huruf yang sama',
                    'Cocokkan semua pasangan untuk menang',
                    'Tekan restart jika dirasa susah'
                ]
            },
            'labirin': {
                title: 'Panduan Labirin Hijaiyah',
                videoId: 'dQw4w9WgXcQ', // GANTI DENGAN ID YOUTUBE ASLI
                steps: [
                    'Gunakan tombol panah untuk bergerak',
                    'Cari huruf yang diminta di labirin',
                    'Hindari jalan buntu dan temukan jalan keluar',
                    'Kumpulkan semua huruf untuk menyelesaikan level'
                ]
            },
            'drag-drop': {
                title: 'Panduan Seret & Lepas',
                videoId: 'dQw4w9WgXcQ', // GANTI DENGAN ID YOUTUBE ASLI
                steps: [
                    'Lihat huruf hijaiyah di layar',
                    'Seret huruf ke huruf latin yang cocok',
                    'Lepaskan di tempat yang benar',
                    'Jawab semua soal dengan benar!'
                ]
            },
            'tracing': {
                title: 'Panduan Tulis Huruf',
                videoId: 'dQw4w9WgXcQ', // GANTI DENGAN ID YOUTUBE ASLI
                steps: [
                    'Lihat huruf yang akan kamu tulis',
                    'Ikuti garis titik-titik dengan jarimu',
                    'Tulis dengan rapi mengikuti panduan',
                    'Selesaikan semua huruf untuk lanjut!'
                ]
            }
        };

        function showGameModal(gameType) {
            selectedGame = gameType;
            const modal = document.getElementById('gameModal');
            const data = gameData[gameType];

            // 1. Update Judul
            document.getElementById('modalGameTitle').textContent = data.title;

            // 2. Update Video Youtube (Mencegah error jika ID kosong)
            const embedUrl = `https://www.youtube.com/embed/${data.videoId}?rel=0&autoplay=1`;
            document.getElementById('gameVideoIframe').src = embedUrl;

            // 3. Update Langkah-langkah
            document.getElementById('step1').textContent = data.steps[0];
            document.getElementById('step2').textContent = data.steps[1];
            document.getElementById('step3').textContent = data.steps[2];
            document.getElementById('step4').textContent = data.steps[3];

            // 4. Tampilkan Modal (Flex agar centered)
            modal.style.display = 'flex';
            modal.classList.remove('hidden');
        }

        function closeGameModal() {
            const modal = document.getElementById('gameModal');
            modal.style.display = 'none';
            modal.classList.add('hidden');

            // Reset video
            document.getElementById('gameVideoIframe').src = '';
        }

        function startGame() {
            // URL Routing Laravel
            const gameUrls = {
                'memory-card': "{{ route('murid.games.memory-card', ['tingkatan_id' => $tingkatan->tingkatan_id]) }}",
                'labirin': "{{ route('murid.games.labirin', ['tingkatan_id' => $tingkatan->tingkatan_id]) }}",
                'drag-drop': "{{ route('murid.games.drag-drop', ['tingkatan_id' => $tingkatan->tingkatan_id]) }}",
                'tracing': "{{ route('murid.games.tracing', ['tingkatan_id' => $tingkatan->tingkatan_id]) }}"
            };

            if(gameUrls[selectedGame]) {
                window.location.href = gameUrls[selectedGame];
            } else {
                console.error("Game URL not found");
            }
        }

        // Tutup modal jika klik di luar (overlay hitam)
        document.getElementById('gameModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeGameModal();
            }
        });

        sessionStorage.setItem('current_tingkatan_id', tingkatanId);
    </script>
@endpush