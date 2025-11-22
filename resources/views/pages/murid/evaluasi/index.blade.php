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
{{-- FIXED BACKGROUND LAYER --}}
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
    <div class="max-w-5xl mx-auto">
                
        {{-- HEADER SECTION --}}
            <div class="container mx-auto px-4 pt-8 pb-12">
            <div class="flex flex-col md:flex-row items-center justify-center gap-4 md:gap-12 max-w-6xl mx-auto">
                
                {{-- Maskot Gajah (KIRI) --}}
                <div class="w-[180px] md:w-[280px] transform hover:rotate-3 transition-transform duration-500">
                    <img src="{{ asset('images/maskot/ceria.webp') }}" alt="Qira Happy"
                        class="w-full h-auto drop-shadow-2xl">
                </div>

                {{-- Teks Header (KANAN) --}}
                <div class="text-center md:text-left">
                    <h1 class="font-titan text-[40px] md:text-[55px] text-[#234275] leading-tight mb-2 text-shadow-header">
                        Bagaimana Permainannya?
                    </h1>
                    <p class="font-cursive-iwk text-[35px] md:text-[60px] text-[#234275] leading-none text-shadow-header">
                        Lihat kemajuan dan bersiap<br>untuk tantangan berikutnya
                    </p>
                </div>
            </div>
        </div>
        
    
        <!-- Tab Toggle -->
        <div class="flex justify-center mb-4">
            <div class="bg-white rounded-full p-1 shadow-lg inline-flex">
                <button onclick="switchTab('leaderboard')" 
                        id="tab-leaderboard" 
                        class="font-cursive-iwk tab-button px-8 py-3 rounded-full font-bold text-3xl transition-all duration-300 bg-pink-500 text-white transition-all duration-300 cursor-pointer">
                    Leaderboard
                </button>
                <button onclick="switchTab('evaluasi')" 
                        id="tab-evaluasi" 
                        class="font-cursive-iwk tab-button px-8 py-3 rounded-full font-bold text-3xl transition-all duration-300 text-pink-500 transition-all duration-300 cursor-pointer">
                    Evaluasi
                </button>
            </div>
        </div>
        
        <!-- Leaderboard Content -->
        <div id="content-leaderboard" class="tab-content flex justify-center items-center">
            <div class="bg-white rounded-3xl shadow-2xl" style="width: 800px; height: 900px; overflow: hidden; display: flex; flex-direction: column;">
                   
                {{-- Tombol lokal dan global --}}
                <div class="flex justify-end mb-4 px-6 pt-6 flex-shrink-0">
                    <div class="relative inline-block text-left">
                        
                        <select onchange="changeLeaderboardType(this.value)" 
                                class="appearance-none w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 pl-6 pr-12 rounded-full shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition-all duration-300 cursor-pointer border border-blue-500">
                            
                            <option value="global" class="bg-white text-gray-800 py-2" {{ $leaderboardType === 'global' ? 'selected' : '' }}>
                                Global Rank
                            </option>
                            
                            <option value="mentor" class="bg-white text-gray-800 py-2" {{ $leaderboardType === 'mentor' ? 'selected' : '' }}>
                                Mentor Rank
                            </option>

                        </select>

                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-white">
                            <svg class="h-5 w-5 transform group-hover:rotate-180 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
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
                            
                            <p class="font-cursive-iwk text-3xl text-gray-700 truncate px-1 lowercase">{{ $rank2->murid->user->username ?? 'Murid 2' }}</p>
                            <p class="font-cursive-iwk text-xl text-gray-500">Skor <span>{{ $rank2->total_poin_semua_game }}</span></p>
                            <div class="bg-gray-300 rounded-t-3xl shadow-lg flex items-center justify-center" style="height: 130px;">
                                <div class="text-3xl font-bold text-gray-600">2</div>
                            </div>
                        </div>

                        {{-- Rank 1 --}}
                        <div class="text-center pb-0" style="width: 180px;">
                            <div class="relative inline-block">                            
                                <div class="absolute -top-12 left-1/2 -translate-x-1/2 z-20 animate-bounce">
                                    <span class="text-7xl drop-shadow-md">👑</span>
                                </div>

                                <img src="{{ asset('images/maskot/ceria.webp') }}"
                                    alt="{{ $rank1->murid->user->username ?? 'Murid 1' }}"
                                    class="bg-yellow-400 rounded-full w-36 h-36 object-cover border-4 border-yellow-500 mx-auto shadow-lg relative z-10">
                            </div>
                            <p class="font-cursive-iwk text-3xl text-gray-700 truncate px-1 lowercase mt-2">
                                {{ $rank1->murid->user->username ?? 'Murid 1' }}
                            </p>                    
                            <p class="font-cursive-iwk text-xl text-gray-600 mb-1">
                                Skor <span>{{ $rank1->total_poin_semua_game }}</span>
                            </p>                            
                            <div class="bg-gradient-to-b from-yellow-300 to-yellow-400 rounded-t-3xl shadow-xl flex flex-col items-center justify-center" style="height: 200px;">
                                <div class="text-6xl font-bold text-yellow-700">1</div>
                            </div>
                        </div>

                        {{-- Rank 3 --}}
                        <div class="text-center pb-0" style="width: 160px;">
                            <img src="{{ asset('images/maskot/ceria.webp') }}"
                                alt="{{ $rank3->murid->user->username ?? 'Murid 3' }}"
                                class="bg-orange-200 rounded-full w-26 h-26 object-cover border-4 border-orange-300 mx-auto ">

                            <p class="font-cursive-iwk text-3xl text-gray-700 truncate px-1 lowercase">{{ $rank3->murid->user->username ?? 'Murid 3' }}</p>
                            <p class="font-cursive-iwk text-xl text-gray-500">Skor <span>{{ $rank3->total_poin_semua_game }}</span></p>
                            <div class="bg-orange-300 rounded-t-3xl shadow-lg flex items-center justify-center" style="height: 60px;">
                                <div class="text-2xl font-bold text-orange-600">3</div>
                            </div>
                        </div>
                    </div>
                @endif
                
                <div class="flex-1 min-h-0 overflow-y-auto space-y-2 px-6">
                    @php
                        // Kalau podium tampil, list mulai dari orang ke-4 (skip 3).
                        // Kalau podium TIDAK tampil (cuma 1-2 orang), list tampilkan SEMUA (skip 0).
                        $listItems = $cukupBuatPodium ? $leaderboards->skip(3) : $leaderboards;
                    @endphp

                    @forelse($listItems as $leaderboard)

                        <div class="flex items-center justify-between bg-gray-50 rounded-2xl p-3 hover:bg-gray-100 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="text-xl font-bold text-gray-400 w-10 text-center">
                                    
                                    {{ sprintf('%02d', $leaderboard->ranking_display) }}
                                </div>
                                                        
                                <img src="{{ asset('images/maskot/ceria.webp') }}"
                                    alt="{{ $leaderboard->murid->user->username ?? 'Murid' }}"
                                    class="bg-blue-100 rounded-full w-10 h-10 object-cover border-2 border-blue-200">

                                <p class="font-cursive-iwk text-gray-700 truncate text-2xl lowercase">{{ $leaderboard->murid->user->username ?? 'Murid' }}</p>
                            </div>
                            <p class="text-lg font-bold text-pink-500">{{ $leaderboard->total_poin_semua_game }}</p>
                        </div>
                        @empty
                        <div class="font-cursive-iwk text-lg text-center text-gray-500 py-8">
                            Belum ada peringkat lainnya
                        </div>
                    @endforelse
                </div>
                
                @if($myRanking)
                <div class="mt-4 mb-4 mx-6 rounded-2xl p-4 border-4 border-pink-300 flex-shrink-0">
                    <p class="font-cursive-iwk text-2xl text-center font-bold text-gray-700">
                        Peringkatmu: 
                        <span class="text-2xl text-pink-500">
                            #{{ $myRanking->ranking_display }}
                        </span>
                        dengan skor <span class="text-pink-500">{{ $myRanking->total_poin_semua_game }}</span> poin
                    </p>
                </div>
                @endif
                
            </div>
        </div>
            
        <!-- Evaluasi Content -->       
        <div id="content-evaluasi" class="tab-content hidden flex justify-center items-start">
            <div class="bg-white rounded-3xl shadow-2xl flex flex-col h-auto w-[800px]">                          
                <!-- Scrollable Content -->
                <div class="flex-1 min-h-0 overflow-y-auto py-10 px-6 space-y-4">
                    @forelse($evaluasiData as $data)
                    <div class="bg-[#f387a9] rounded-2xl p-4 m-4 shadow-lg hover:scale-105 transition-transform">
                        <div class="flex items-center gap-4">
                            <!-- Icon -->
                            <div class="bg-white rounded-xl p-3 w-40 h-40 flex items-center justify-center flex-shrink-0">
                                @if($data['game']->nama_game === 'Tracking')
                                    <img src="{{ asset('images/icon/tracing.webp') }}" 
                                        alt="Tracking"
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
                                <h3 class="font-cursive-iwk text-5xl font-bold mb-3">{{ $data['game']->nama_game }}</h3>
                                
                                <div class="space-y-1">
                                    <p class="font-cursive-iwk text-xl font-bold">
                                        Score : <span class="text-3xl">{{ $data['result'] ? $data['result']->total_poin : '0' }}</span>
                                    </p>
                                    
                                    @if($data['result'])
                                        <p class="font-cursive-iwk text-3xl font-light">
                                            Ulasan: {{ $data['ulasan'] ?? 'Hebat, pertahankan!' }}
                                        </p>
                                    @else
                                        <p class="font-cursive-iwk text-3xl font-light italic">
                                            Ulasan: Belum pernah dimainkan
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
        leaderboardTab.classList.add('bg-pink-500', 'text-white');
        leaderboardTab.classList.remove('text-pink-500', 'bg-transparent');
        
        // Nonaktifkan Evaluasi
        evaluasiTab.classList.remove('bg-pink-500', 'text-white');
        evaluasiTab.classList.add('text-pink-500', 'bg-transparent');
        
        // Toggle content
        leaderboardContent.classList.remove('hidden');
        evaluasiContent.classList.add('hidden');
    } else {
        // Aktifkan Evaluasi
        evaluasiTab.classList.add('bg-pink-500', 'text-white');
        evaluasiTab.classList.remove('text-pink-500', 'bg-transparent');
        
        // Nonaktifkan Leaderboard
        leaderboardTab.classList.remove('bg-pink-500', 'text-white');
        leaderboardTab.classList.add('text-pink-500', 'bg-transparent');
        
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
</script>
@endpush

@endsection