@extends('layouts.murid')

@section('title', 'Evaluasi & Leaderboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="w-48">
                    <img src="{{ asset('images/qira-trophy.png') }}" alt="Qira" class="w-full"
                         onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Ctext y=%22.9em%22 font-size=%2290%22%3E🐘🏆%3C/text%3E%3C/svg%3E'">
                </div>
                <div>
                    <h1 class="text-5xl font-bold text-pink-500 mb-2">Bagaimana<br>Permainannya?</h1>
                    <p class="text-2xl text-blue-800 font-light italic">
                        Lihat kemajuanmu dan ber-siap<br>untuk tantangan berikutnya!
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Tab Toggle -->
        <div class="flex justify-center mb-4">
            <div class="bg-white rounded-full p-1 shadow-lg inline-flex">
                <button onclick="switchTab('leaderboard')" 
                        id="tab-leaderboard" 
                        class="tab-button px-8 py-3 rounded-full font-bold text-lg transition-all duration-300 bg-pink-500 text-white transition-all duration-300">
                    Leaderboard
                </button>
                <button onclick="switchTab('evaluasi')" 
                        id="tab-evaluasi" 
                        class="tab-button px-8 py-3 rounded-full font-bold text-lg transition-all duration-300 text-pink-500 transition-all duration-300">
                    Evaluasi
                </button>
            </div>
        </div>
        
        <!-- Leaderboard Content -->
        <div id="content-leaderboard" class="tab-content flex justify-center items-center">
            <div class="bg-white rounded-3xl shadow-2xl" style="width: 640px; height: 70px; overflow: hidden; display: flex; flex-direction: column;">
                        
                <div class="flex justify-end mb-4 px-6 pt-6 flex-shrink-0">
                    <select onchange="changeLeaderboardType(this.value)" 
                            class="bg-blue-500 text-white px-6 py-2 rounded-full font-semibold cursor-pointer">
                        <option value="global" {{ $leaderboardType === 'global' ? 'selected' : '' }}>
                            Global
                        </option>
                        <option value="mentor" {{ $leaderboardType === 'mentor' ? 'selected' : '' }}>
                            Mentor
                        </option>
                    </select>
                </div>        
                
                @if($leaderboards->count() >= 3)
                    {{-- 
                    LANGKAH "RAPI":
                    Kita definisikan variabel dulu di sini agar HTML di bawah lebih bersih.
                    --}}
                    @php
                        $rank1 = $leaderboards[0];
                        $rank2 = $leaderboards[1];
                        $rank3 = $leaderboards[2];
                    @endphp

                    <div class="flex items-end justify-center gap-4 mb-6 px-4 flex-shrink-0">
                        
                        <!-- Rank 2 -->
                        <div class="text-center pb-0" style="width: 120px;">                    
                            <img src="{{ asset('images/maskot/ceria.webp') }}"
                                alt="{{ $rank2->murid->user->username ?? 'Murid 2' }}"
                                class="bg-gray-200 rounded-full w-16 h-16 object-cover border-4 border-gray-300 mx-auto ">
                            
                            <p class="font-bold text-gray-700 text-sm truncate px-1">{{ $rank2->murid->user->username ?? 'Murid 2' }}</p>
                            <p class="text-xs text-gray-500">Skor {{ $rank2->total_poin_semua_game }}</p>
                            <div class="bg-gray-300 rounded-t-3xl shadow-lg flex items-center justify-center" style="height: 80px;">
                                <div class="text-3xl font-bold text-gray-600">2</div>
                            </div>
                        </div>
                        
                        <!-- Rank 1 -->
                        <div class="text-center pb-0" style="width: 130px">
                            <img src="{{ asset('images/maskot/ceria.webp') }}"
                                alt="{{ $rank1->murid->user->username ?? 'Murid 1' }}"
                                class="bg-yellow-400 rounded-full w-20 h-20 object-cover border-4 border-yellow-500 mx-auto shadow-lg">

                            <p class="font-bold text-blue-900 text-sm truncate px-1">{{ $rank1->murid->user->username ?? 'Murid 1' }}</p>
                            <p class="text-xs text-gray-600">Skor {{ $rank1->total_poin_semua_game }}</p>
                            <div class="bg-gradient-to-b from-yellow-300 to-yellow-400 rounded-t-3xl  shadow-xl flex flex-col items-center justify-center" style="height: 110px;">
                                <div class="text-4xl font-bold text-yellow-700">1</div>
                                <div class="text-2xl mt-1">👑</div>
                            </div>
                        </div>
                        
                        <!-- Rank 3 -->
                        <div class="text-center pb-0" style="width: 120px;">
                            <img src="{{ asset('images/maskot/ceria.webp') }}"
                                alt="{{ $rank3->murid->user->username ?? 'Murid 3' }}"
                                class="bg-orange-200 rounded-full w-16 h-16 object-cover border-4 border-orange-300 mx-auto ">

                            <p class="font-bold text-gray-700 text-sm truncate px-1">{{ $rank3->murid->user->username ?? 'Murid 3' }}</p>
                            <p class="text-xs text-gray-500">Skor {{ $rank3->total_poin_semua_game }}</p>
                            <div class="bg-orange-300 rounded-t-3xl shadow-lg flex items-center justify-center" style="height: 60px;">
                                <div class="text-2xl font-bold text-orange-600">3</div>
                            </div>
                        </div>
                    </div>
                @endif
                
                <div class="flex-1 min-h-0 overflow-y-auto space-y-2 px-6">
                    @forelse($leaderboards->skip(3) as $index => $leaderboard)
                    <div class="flex items-center justify-between bg-gray-50 rounded-2xl p-3 hover:bg-gray-100 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="text-xl font-bold text-gray-400 w-10 text-center">
                                
                                {{ sprintf('%02d', $leaderboard->ranking_global) }}
                            </div>
                            
                            {{-- REVISI: Ganti SVG dengan <img> --}}
                            <img src="{{ asset('images/maskot/ceria.webp') }}"
                                alt="{{ $leaderboard->murid->user->username ?? 'Murid' }}"
                                class="bg-blue-100 rounded-full w-10 h-10 object-cover border-2 border-blue-200">

                            <p class="font-semibold text-gray-700 truncate text-sm">{{ $leaderboard->murid->user->username ?? 'Murid' }}</p>
                        </div>
                        <p class="text-lg font-bold text-pink-500">{{ $leaderboard->total_poin_semua_game }}</p>
                    </div>
                    @empty
                    <div class="text-center text-gray-500 py-8">
                        Belum ada peringkat lainnya
                    </div>
                    @endforelse
                </div>
                
                @if($myRanking)
                <div class="mt-4 mb-4 mx-6 bg-gradient-to-r from-pink-100 to-blue-100 rounded-2xl p-4 border-4 border-pink-300 flex-shrink-0">
                    <p class="text-center text-sm font-bold text-gray-700">
                        Peringkatmu: 
                        <span class="text-2xl text-pink-500">
                            #{{ $leaderboardType === 'mentor' ? $myRanking->ranking_mentor : $myRanking->ranking_global }}
                        </span>
                        dengan skor <span class="text-pink-500">{{ $myRanking->total_poin_semua_game }}</span> poin
                    </p>
                </div>
                @endif
                
            </div>
        </div>
            
        <!-- Evaluasi Content -->       
<div id="content-evaluasi" class="tab-content hidden flex justify-center items-start pt-8">
    <div class="bg-white rounded-3xl shadow-2xl" style="width: 640px; height: 720px; overflow: hidden; display: flex; flex-direction: column;">        
        
        <!-- Header -->
        <div class="p-6 flex-shrink-0">
            <h2 class="text-2xl font-bold text-gray-800 text-center">Hasil Evaluasi Game</h2>
        </div>
        
        <!-- Scrollable Content -->
        <div class="flex-1 min-h-0 overflow-y-auto px-6 space-y-4">
            @forelse($evaluasiData as $data)
            <div class="bg-gradient-to-r from-pink-300 to-pink-400 rounded-2xl p-4 shadow-lg hover:scale-105 transition-transform">
                <div class="flex items-center gap-4">
                    <!-- Icon -->
                    <div class="bg-white rounded-xl p-3 w-16 h-16 flex items-center justify-center flex-shrink-0">
                        @if($data['game']->icon)
                            <img src="{{ asset('images/icon/') }}" 
                                 alt="{{ $data['game']->nama_game }}"
                                 class="w-12 h-12 object-contain">
                        @else
                            <div class="text-3xl">
                                @if($data['game']->nama_game === 'Tracking')
                                    ✏️
                                @elseif($data['game']->nama_game === 'Labirin')
                                    🎯
                                @elseif($data['game']->nama_game === 'Memory Card')
                                    🎴
                                @else
                                    🧩
                                @endif
                            </div>
                        @endif
                    </div>
                    
                    <!-- Game Info -->
                    <div class="flex-1 text-white min-w-0">
                        <h3 class="text-lg font-bold mb-1 truncate">{{ $data['game']->nama_game }}</h3>
                        @if($data['result'])
                            <p class="text-sm">Waktu: {{ $data['result']->dimainkan_at->format('d/m/Y H:i') }}</p>
                        @else
                            <p class="text-sm font-light italic">Belum dimainkan</p>
                        @endif
                    </div>
                    
                    <!-- Score Badge -->
                    @if($data['result'])
                    <div class="bg-white rounded-xl px-4 py-2 text-center flex-shrink-0">
                        <p class="text-xs text-gray-600">Skor</p>
                        <p class="text-2xl font-bold text-pink-500">{{ $data['result']->skor }}</p>
                    </div>
                    @else
                    <div class="bg-white/50 rounded-xl px-4 py-2 text-center flex-shrink-0">
                        <p class="text-xs text-gray-600">Skor</p>
                        <p class="text-xl font-bold text-gray-400">-</p>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center text-gray-500 py-12">
                <p class="text-lg">Belum ada data evaluasi</p>
                <p class="text-sm">Yuk mainkan game untuk melihat hasilnya!</p>
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