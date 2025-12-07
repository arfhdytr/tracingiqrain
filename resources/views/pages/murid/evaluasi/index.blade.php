@extends('layouts.murid')

@section('title', 'Evaluasi & Leaderboard')

{{-- STYLES --}}
@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mooli&family=Titan+One&display=swap" rel="stylesheet">

    <style>
        /* Font Import */
        @import url('https://fonts.googleapis.com/css2?family=Titan+One&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&display=swap');

        .font-fredoka { font-family: 'Fredoka', sans-serif; }
        
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
    </style>

@endpush

@section('content')
<div class="fixed inset-0 w-full h-full pointer-events-none"
    style="background: linear-gradient(180deg, #56B1F3 0%, #D3F2FF 100%); z-index: -1;">
    
    {{-- Pattern Overlay --}}
    <div class="absolute inset-0 w-full h-full"
        style="background-image: url('{{ asset('images/games/game-pattern.webp') }}'); 
                background-size: 500px;
                background-repeat: repeat;
                background-position: center; 
                opacity: 0.3;">
    </div>
</div>

<div class="w-full relative overflow-x-hidden" style="z-index: 10;">
    <div class="">
                
        <!--  -->
        <div class="container mx-auto px-4 pt-8 pb-12">
            <div class="flex flex-col md:flex-row items-center justify-center gap-4 md:gap-12 max-w-6xl mx-auto">

                {{-- Maskot Qira Bingung (KIRI) --}}
                <div class="w-[180px] md:w-[280px] transform hover:rotate-3 transition-transform duration-500">
                    <img src="{{ asset('images/maskot/qira-bingung.webp') }}" alt="Qira Bingung" class="w-full h-auto drop-shadow-2xl">
                </div>

                {{-- Text Header (KANAN) --}}
                <div class="text-center md:text-left">
                    <h1 class="font-titan text-[40px] md:text-[55px] text-[#234275] leading-tight mb-2 text-shadow-header">
                        Bagaimana Permainannya?
                    </h1>
                    <p class="text-[35px] md:text-[40px] text-[#234275] my-5 leading-none text-shadow-header">
                        <span class="font-cursive-iwk phrase-biru-tua">Lihat</span>
                        <span class="font-cursive-iwk phrase-biru-tua">kemajuan</span>
                        <span class="font-cursive-iwk phrase-biru-tua">dan</span>
                        <span class="font-cursive-iwk phrase-biru-tua">bersiap</span>
                        <span class="font-cursive-iwk phrase-biru-tua">untuk</span>
                        <span class="font-cursive-iwk phrase-biru-tua">tantangan</span>
                        <span class="font-cursive-iwk phrase-biru-tua">berikutnya!</span>
                    </p>
                </div>
            </div>
        </div>
        
    
        <!-- Tab Toggle -->
        <div class="flex justify-center mb-4">
            <div class="bg-white rounded-full p-1 shadow-lg inline-flex">
                <button onclick="switchTab('leaderboard')" 
                        id="tab-leaderboard" 
                        class="font-fredoka tab-button px-8 py-3 rounded-full font-bold text-2xl transition-all duration-300 bg-[var(--color-iqrain-pink)] text-white transition-all duration-300 cursor-pointer">
                    Leaderboard
                </button>
                <button onclick="switchTab('evaluasi')" 
                        id="tab-evaluasi" 
                        class="font-fredoka tab-button px-8 py-3 rounded-full font-bold text-2xl transition-all duration-300 transition-all duration-300 cursor-pointer text-[#D75C82]">
                    Evaluasi
                </button>
            </div>
        </div>
        
        <!-- Leaderboard Content -->
        <div id="content-leaderboard" class="tab-content flex justify-center items-center">
            <div class="bg-[#FFFFEB] border-[4px] border-[#F387A9] rounded-3xl shadow-2xl" style="width: 800px; height: 900px; overflow: hidden; display: flex; flex-direction: column;">
                   
                {{-- Custom Dropdown Filter --}}
                <div class="flex justify-end mb-4 px-6 pt-6 flex-shrink-0 relative z-20">
                    
                    {{-- Tombol Pemicu (Trigger) --}}
                    <div class="relative">
                        <button onclick="toggleDropdown()" 
                                id="dropdownButton"
                                class="flex items-center gap-3 hover:bg-blue-700 text-white px-6 py-3 rounded-full shadow-lg hover:shadow-blue-500/30 transition-all duration-300 transform active:scale-95 border-2 border-blue-500" style="background-color: var(--color-iqrain-blue) !important;">
                            
                            {{-- Teks Berubah Sesuai Pilihan --}}
                            <span class="font-fredoka text-2xl tracking-wide text-base font-semibold">
                                {{ $leaderboardType === 'mentor' ? 'Lingkup Mentor' : 'Lingkup Global' }}
                            </span>

                            {{-- Icon Panah (Akan berputar nanti) --}}
                            <svg id="dropdownArrow" class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        {{-- Isi Menu (Awalnya Sembunyi) --}}
                        <div id="dropdownMenu" 
                            class="hidden absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden origin-top-right transition-all duration-200 transform scale-95 opacity-0">
                            
                            <div class="p-1.5">
                                {{-- Pilihan Global --}}
                                <div onclick="selectOption('global')" 
                                    class="flex items-center gap-3 px-4 py-3 rounded-xl cursor-pointer transition-colors {{ $leaderboardType === 'global' ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }}">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div class="flex flex-col ">
                                        <span class="font-mooli text-base">Global Rank</span>
                                        <span class="font-mooli text-sm opacity-70">Semua Murid</span>
                                    </div>
                                    @if($leaderboardType === 'global')
                                        <svg class="w-5 h-5 ml-auto text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    @endif
                                </div>

                                {{-- Pilihan Mentor --}}
                                <div onclick="selectOption('mentor')" 
                                    class="flex items-center gap-3 px-4 py-3 rounded-xl cursor-pointer transition-colors {{ $leaderboardType === 'mentor' ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50' }}">
                                    <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-mooli text-base">Mentor Rank</span>
                                        <span class="font-mooli text-sm opacity-70">Teman Sekelas</span>
                                    </div>
                                    @if($leaderboardType === 'mentor')
                                        <svg class="w-5 h-5 ml-auto text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    $cukupBuatPodium = $leaderboards->count() >= 3;
                @endphp
                                
                @if($cukupBuatPodium)                     
                    @php
                        $rank1 = $leaderboards[0];
                        $rank2 = $leaderboards[1];
                        $rank3 = $leaderboards[2];
                    @endphp

                    <div class="flex items-end justify-center gap-4 mb-6 px-4 flex-shrink-0">
                        
                        {{-- Bagian Podium --}}
                        {{-- Rank 2 --}}
                        <div class="text-center pb-0" style="width: 160px;">                    
                            <img src="{{ asset('images/maskot/ceria.webp') }}"
                                alt="{{ $rank2->murid->user->username ?? 'Murid 2' }}"
                                class="bg-gray-200 rounded-full w-26 h-26 object-cover border-4 border-gray-300 mx-auto ">
                            
                            <p class="font-cursive-iwk phrase-kuning font-bold text-3xl text-gray-700 truncate px-1 lowercase">{{ $rank2->murid->user->username ?? 'Murid 2' }}</p>
                            <p class="font-mooli text-base text-gray-500 pb-2">Skor <span>{{ $rank2->total_poin_semua_game }}</span></p>
                            <div class="bg-gray-300 rounded-t-3xl shadow-lg flex items-center justify-center" style="height: 130px;">
                                <div class="font-titan text-3xl font-bold text-gray-600">2</div>
                            </div>
                        </div>

                        {{-- Rank 1 --}}
                        <div class="text-center pb-0" style="width: 180px;">
                            <div class="relative inline-block">                            
                                <div class="absolute -top-14 left-1/2 -translate-x-1/2 z-20 animate-bounce">
                                    <img src="{{ asset('images/icon/mahkota.webp') }}" 
                                         alt="Mahkota" 
                                         class="w-180 h-auto drop-shadow-lg">
                                </div>

                                <img src="{{ asset('images/maskot/ceria.webp') }}"
                                    alt="{{ $rank1->murid->user->username ?? 'Murid 1' }}"
                                    class="bg-yellow-400 rounded-full w-36 h-36 object-cover border-4 border-yellow-500 mx-auto shadow-lg relative z-10">
                            </div>
                            <p class="font-cursive-iwk phrase-kuning text-4xl font-bold text-gray-700 truncate px-1 lowercase mt-2">
                                {{ $rank1->murid->user->username ?? 'Murid 1' }}
                            </p>                    
                            <p class="font-mooli text-xl text-gray-600 mb-1 pb-2">
                                Skor <span>{{ $rank1->total_poin_semua_game }}</span>
                            </p>                            
                            <div class="bg-gradient-to-b from-yellow-300 to-yellow-400 rounded-t-3xl shadow-xl flex flex-col items-center justify-center" style="height: 200px;">
                                <div class="font-titan text-6xl font-bold text-yellow-700">1</div>
                            </div>
                        </div>

                        {{-- Rank 3 --}}
                        <div class="text-center pb-0" style="width: 160px;">
                            <img src="{{ asset('images/maskot/ceria.webp') }}"
                                alt="{{ $rank3->murid->user->username ?? 'Murid 3' }}"
                                class="bg-orange-200 rounded-full w-26 h-26 object-cover border-4 border-orange-300 mx-auto ">

                            <p class="font-cursive-iwk font-bold phrase-kuning text-3xl text-gray-700 truncate px-1 lowercase">{{ $rank3->murid->user->username ?? 'Murid 3' }}</p>
                            <p class="font-mooli text-base text-gray-500 pb-2">Skor <span>{{ $rank3->total_poin_semua_game }}</span></p>
                            <div class="bg-orange-300 rounded-t-3xl shadow-lg flex items-center justify-center" style="height: 60px;">
                                <div class="font-titan text-2xl font-bold text-orange-600">3</div>
                            </div>
                        </div>
                    </div>
                @endif
                
                <div class="flex-1 min-h-0 overflow-y-auto space-y-2 px-6">
                    @php                        
                        $listItems = $cukupBuatPodium ? $leaderboards->skip(3) : $leaderboards;
                    @endphp

                    @forelse($listItems as $leaderboard)

                        <div class="flex items-center justify-between bg-[#F9DAE4] rounded-2xl p-3 hover:bg-gray-200 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="font-titan text-xl text-gray-500 w-10 text-center">
                                    
                                    {{ sprintf('%02d', $leaderboard->ranking_display) }}
                                </div>
                                                        
                                <img src="{{ asset('images/maskot/ceria.webp') }}"
                                    alt="{{ $leaderboard->murid->user->username ?? 'Murid' }}"
                                    class="bg-blue-100 rounded-full w-10 h-10 object-cover border-2 border-blue-200">

                                <p class="font-cursive-iwk phrase-pink text-gray-700 truncate text-3xl lowercase">{{ $leaderboard->murid->user->username ?? 'Murid' }}</p>
                            </div>
                            <p class="font-titan text-xl text-pink-500 pr-2">{{ $leaderboard->total_poin_semua_game }}</p>
                        </div>
                        @empty
                            <div class="flex flex-col items-center justify-center py-10">
                                {{-- Gambar Qira Bingung --}}
                                <img src="{{ asset('images/maskot/qira-bingung.webp') }}" 
                                    alt="Belum ada data" 
                                    class="w-40 h-auto mb-4 drop-shadow-md opacity-90 hover:scale-110 transition-transform duration-300">
                                
                                {{-- Teks Keterangan --}}
                                <p class="font-cursive-iwk text-xl text-gray-500">
                                    Belum ada peringkat lainnya
                                </p>
                                <p class="font-cursive-iwk text-xl text-gray-400 mt-1">
                                    Pilih mentor mu
                                </p>
                            </div>
                    @endforelse
                </div>
                
                @if($myRanking)
                <div class="mt-4 mb-4 mx-6 rounded-2xl p-4 bg-[#CAEDFE] flex-shrink-0">
                    <p class="text-center font-bold text-gray-600">
                        <span class="font-cursive-iwk phrase-pink text-3xl">Peringkatmu</span>
                        <span>:</span>
                        <span class="text-2xl text-pink-500 font-nanum">
                            #{{ $myRanking->ranking_display }}
                        </span>
                            <span class="mr-2 font-cursive-iwk phrase-pink text-3xl">dengan</span>
                            <span class="font-cursive-iwk phrase-pink text-3xl">skor</span>  
                        <span class="font-nanum text-2xl text-pink-500">{{ $myRanking->total_poin_semua_game }}</span>
                            <span class="font-cursive-iwk phrase-pink text-3xl">poin</span>
                    </p>
                </div>
                @endif
                
            </div>
        </div>
            
        <!-- Evaluasi Content -->       
        <div id="content-evaluasi" class="tab-content hidden flex justify-center items-start">
            <div class="bg-[#FFFFEB] border-[4px] border-[#F387A9] rounded-3xl shadow-2xl flex flex-col h-auto w-[800px] scale-[0.9]">                          
                <!-- Scrollable Content -->
                <div class="flex-1 min-h-0 overflow-y-auto py-10 px-6 space-y-4">
                    @forelse($evaluasiData as $data)
                    <div class="bg-[#f387a9] rounded-2xl p-4 m-4 shadow-lg hover:scale-105 transition-transform">
                        <div class="flex items-center gap-4">
                            <!-- Icon -->
                            <div class="bg-white rounded-xl p-3 w-40 h-40 flex items-center justify-center flex-shrink-0">
                                @if($data['game']->nama_game === 'Tracing')
                                    <img src="{{ asset('images/icon/tracing.webp') }}" 
                                        alt="Tracing"
                                        class="w-full h-full object-cover rounded-xl">
                                @elseif($data['game']->nama_game === 'Labirin')
                                    <img src="{{ asset('images/icon/maze.webp') }}" 
                                        alt="Labirin"
                                        class="w-full h-full object-cover rounded-xl">
                                @elseif($data['game']->nama_game === 'Memory Card')
                                    <img src="{{ asset('images/icon/memory-card.webp') }}" 
                                        alt="Memory Card"
                                        class="w-full h-full object-cover rounded-xl">
                                @else
                                    <img src="{{ asset('images/icon/drag-drop.webp') }}" 
                                        alt="{{ $data['game']->nama_game }}"
                                        class="w-full h-full object-cover rounded-xl">
                                @endif
                            </div>
                            
                            <!-- Game Info -->
                            <div class="flex-1 text-white">
                                <h3 class="font-fredoka text-3xl font-bold mb-3">{{ $data['game']->nama_game }}</h3>
                                
                                <div class="space-y-1">
                                    <p class="font-cursive-iwk text-3xl font-bold">
                                        <span class="font-cursive-iwk text-3xl phrase-putih">Skor</span>
                                        <span class="font-nanum">:</span> 
                                        <span class="text-3xl">{{ $data['result'] ? $data['result']->total_poin : '0' }}</span>
                                    </p>
                                    
                                    @if($data['result'])
                                        <p class="font-light">
                                            <span class="font-cursive-iwk text-3xl phrase-putih">Ulasan</span>
                                            <span class="font-nanum">:</span> 
                                            {{ $data['ulasan'] ?? 'Hebat, pertahankan!' }}
                                        </p>
                                    @else
                                        <p>
                                            <span class="font-cursive-iwk text-3xl phrase-putih">Ulasan</span>
                                            <span class="font-nanum">:</span> 
                                            <span class="font-cursive-iwk text-3xl phrase-putih">Belum</span>
                                            <span class="font-cursive-iwk text-3xl phrase-putih">pernah</span>
                                            <span class="font-cursive-iwk text-3xl phrase-putih">dimainkan.</span>
                                        </p>
                                    @endif
                                </div>
                            </div>                                        
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-gray-500 py-12">
                        <p class="font-cursive-iwk text-lg">Belum ada data evaluasi</p>
                        <p class="font-cursive-iwk text-sm">Yuk mainkan game untuk melihat hasilnya!</p>
                    </div>
                    @endforelse
                </div>                    
            </div>
        </div>        
    </div>
</div>

@push('scripts')
<script>
    const tingkatanId = {{ $tingkatan->tingkatan_id }};
    
    function switchTab(tab) {
    const leaderboardTab = document.getElementById('tab-leaderboard');
    const evaluasiTab = document.getElementById('tab-evaluasi');
    const leaderboardContent = document.getElementById('content-leaderboard');
    const evaluasiContent = document.getElementById('content-evaluasi');
    
    if (tab === 'leaderboard') {
        // Aktifkan Leaderboard
        leaderboardTab.classList.add('bg-[var(--color-iqrain-pink)]', 'text-white');
        leaderboardTab.classList.remove('text-[#D75C82]', 'bg-transparent');
        
        // Nonaktifkan Evaluasi
        evaluasiTab.classList.remove('bg-[var(--color-iqrain-pink)]', 'text-white');
        evaluasiTab.classList.add('text-[#D75C82]', 'bg-transparent');
        
        // Toggle content
        leaderboardContent.classList.remove('hidden');
        evaluasiContent.classList.add('hidden');
    } else {
        // Aktifkan Evaluasi
        evaluasiTab.classList.add('bg-[var(--color-iqrain-pink)]', 'text-white');
        evaluasiTab.classList.remove('text-[#D75C82]', 'bg-transparent');
        
        // Nonaktifkan Leaderboard
        leaderboardTab.classList.remove('bg-[var(--color-iqrain-pink)]', 'text-white');
        leaderboardTab.classList.add('text-[#D75C82]', 'bg-transparent');
        
        // Toggle content
        evaluasiContent.classList.remove('hidden');
        leaderboardContent.classList.add('hidden');
    }
}
    
    function changeLeaderboardType(type) {
        window.location.href = `{{ route('murid.evaluasi.index', $tingkatan->tingkatan_id) }}?type=${type}`;
    }
    
    // Initialize
    sessionStorage.setItem('current_tingkatan_id', tingkatanId);


    // --- LOGIKA CUSTOM DROPDOWN ---
    function toggleDropdown() {
        const menu = document.getElementById('dropdownMenu');
        const arrow = document.getElementById('dropdownArrow');
        
        // Cek apakah sedang tersembunyi
        if (menu.classList.contains('hidden')) {
            // Buka Menu
            menu.classList.remove('hidden');
            // Animasi Masuk (sedikit delay biar smooth)
            setTimeout(() => {
                menu.classList.remove('scale-95', 'opacity-0');
                menu.classList.add('scale-100', 'opacity-100');
            }, 10);
            // Putar Panah
            arrow.classList.add('rotate-180');
        } else {
            // Tutup Menu
            menu.classList.remove('scale-100', 'opacity-100');
            menu.classList.add('scale-95', 'opacity-0');
            // Putar Panah Balik
            arrow.classList.remove('rotate-180');
            // Sembunyikan div setelah animasi selesai
            setTimeout(() => {
                menu.classList.add('hidden');
            }, 200);
        }
    }

    // Fungsi saat pilihan diklik
    function selectOption(type) {
        // Panggil fungsi ganti leaderboard yang lama
        changeLeaderboardType(type);
    }

    // Tutup dropdown kalau klik di luar
    window.addEventListener('click', function(e) {
        const btn = document.getElementById('dropdownButton');
        const menu = document.getElementById('dropdownMenu');
        if (!btn.contains(e.target) && !menu.contains(e.target)) {
            if (!menu.classList.contains('hidden')) {
                toggleDropdown(); // Tutup paksa
            }
        }
    });
</script>
@endpush

@endsection