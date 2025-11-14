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
        <div class="flex justify-center mb-8">
            <div class="bg-white rounded-full p-1 shadow-lg inline-flex">
                <button onclick="switchTab('leaderboard')" 
                        id="tab-leaderboard" 
                        class="tab-button px-8 py-3 rounded-full font-bold text-lg transition-all duration-300 bg-pink-500 text-white">
                    Leaderboard
                </button>
                <button onclick="switchTab('evaluasi')" 
                        id="tab-evaluasi" 
                        class="tab-button px-8 py-3 rounded-full font-bold text-lg transition-all duration-300 text-pink-500">
                    Evaluasi
                </button>
            </div>
        </div>
        
        <!-- Leaderboard Content -->
        <div id="content-leaderboard" class="tab-content">
            <div class="bg-white rounded-3xl p-8 shadow-2xl">
                
                <!-- Filter Dropdown -->
                @if(auth()->user()->murid->mentor_id)
                <div class="flex justify-end mb-6">
                    <select onchange="changeLeaderboardType(this.value)" 
                            class="bg-blue-500 text-white px-6 py-2 rounded-full font-semibold cursor-pointer">
                        <option value="global" {{ $leaderboardType === 'global' ? 'selected' : '' }}>
                            Berdasarkan Global
                        </option>
                        <option value="mentor" {{ $leaderboardType === 'mentor' ? 'selected' : '' }}>
                            Berdasarkan Mentor
                        </option>
                    </select>
                </div>
                @endif
                
                <!-- Top 3 Podium -->
                @if($leaderboards->count() >= 3)
                <div class="flex items-end justify-center gap-8 mb-12">
                    <!-- Rank 2 -->
                    <div class="text-center">
                        <div class="bg-gray-200 rounded-full w-20 h-20 flex items-center justify-center mb-2">
                            <svg class="w-12 h-12 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                            </svg>
                        </div>
                        <p class="font-bold text-gray-700">{{ $leaderboards[1]->murid->user->username ?? 'Murid 2' }}</p>
                        <p class="text-sm text-gray-500">Skor {{ $leaderboards[1]->total_poin_semua_game }}</p>
                        <div class="bg-gray-300 rounded-t-3xl px-6 py-8 mt-4 shadow-lg">
                            <div class="text-4xl font-bold text-gray-600">2</div>
                        </div>
                    </div>
                    
                    <!-- Rank 1 -->
                    <div class="text-center -mt-8">
                        <div class="bg-yellow-400 rounded-full w-24 h-24 flex items-center justify-center mb-2 shadow-lg">
                            <svg class="w-14 h-14 text-yellow-700" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                            </svg>
                        </div>
                        <p class="font-bold text-blue-900 text-lg">{{ $leaderboards[0]->murid->user->username ?? 'Murid 1' }}</p>
                        <p class="text-sm text-gray-600">Skor {{ $leaderboards[0]->total_poin_semua_game }}</p>
                        <div class="bg-gradient-to-b from-yellow-300 to-yellow-400 rounded-t-3xl px-6 py-12 mt-4 shadow-xl">
                            <div class="text-5xl font-bold text-yellow-700">1</div>
                            <div class="text-3xl mt-2">👑</div>
                        </div>
                    </div>
                    
                    <!-- Rank 3 -->
                    <div class="text-center">
                        <div class="bg-orange-200 rounded-full w-20 h-20 flex items-center justify-center mb-2">
                            <svg class="w-12 h-12 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                            </svg>
                        </div>
                        <p class="font-bold text-gray-700">{{ $leaderboards[2]->murid->user->username ?? 'Murid 3' }}</p>
                        <p class="text-sm text-gray-500">Skor {{ $leaderboards[2]->total_poin_semua_game }}</p>
                        <div class="bg-orange-300 rounded-t-3xl px-6 py-6 mt-4 shadow-lg">
                            <div class="text-3xl font-bold text-orange-600">3</div>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Leaderboard List -->
                <div class="max-h-96 overflow-y-auto space-y-2">
                    @forelse($leaderboards->skip(3) as $index => $leaderboard)
                    <div class="flex items-center justify-between bg-gray-50 rounded-2xl p-4 hover:bg-gray-100 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="text-2xl font-bold text-gray-400 w-12 text-center">
                                {{ sprintf('%02d', $index + 4) }}
                            </div>
                            <div class="bg-blue-100 rounded-full w-12 h-12 flex items-center justify-center">
                                <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                </svg>
                            </div>
                            <p class="font-semibold text-gray-700">{{ $leaderboard->murid->user->username }}</p>
                        </div>
                        <p class="text-xl font-bold text-pink-500">Skor {{ $leaderboard->total_poin_semua_game }}</p>
                    </div>
                    @empty
                    <div class="text-center text-gray-500 py-8">
                        Belum ada peringkat lainnya
                    </div>
                    @endforelse
                </div>
                
                <!-- My Ranking -->
                @if($myRanking)
                <div class="mt-8 bg-gradient-to-r from-pink-100 to-blue-100 rounded-2xl p-6 border-4 border-pink-300">
                    <p class="text-center text-xl font-bold text-gray-700">
                        Peringkatmu: 
                        <span class="text-3xl text-pink-500">
                            #{{ $leaderboardType === 'mentor' ? $myRanking->ranking_mentor : $myRanking->ranking_global }}
                        </span>
                        dengan skor <span class="text-pink-500">{{ $myRanking->total_poin_semua_game }}</span> poin
                    </p>
                </div>
                @endif
                
            </div>
        </div>
        
        <!-- Evaluasi Content -->
        <div id="content-evaluasi" class="tab-content hidden">
            <div class="space-y-4">
                @forelse($evaluasiData as $data)
                <div class="bg-gradient-to-r from-pink-300 to-pink-400 rounded-3xl p-6 shadow-xl hover:scale-102 transition-transform">
                    <div class="flex items-center gap-6">
                        <!-- Icon -->
                        <div class="bg-white rounded-2xl p-4 w-24 h-24 flex items-center justify-center">
                            <div class="text-5xl">
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
                        </div>
                        
                        <!-- Game Info -->
                        <div class="flex-1 text-white">
                            <h3 class="text-2xl font-bold mb-1">{{ $data['game']->nama_game }}</h3>
                            @if($data['result'])
                                <p class="text-lg">Skor: <span class="font-bold">{{ $data['result']->skor }}</span></p>
                                <p class="text-sm">Waktu: {{ $data['result']->dimainkan_at->format('d/m/Y H:i') }}</p>
                            @else
                                <p class="text-lg font-light italic">Belum pernah dimainkan</p>
                            @endif
                        </div>
                        
                        <!-- Score Badge -->
                        @if($data['result'])
                        <div class="bg-white rounded-2xl px-6 py-3 text-center">
                            <p class="text-sm text-gray-600">Skor</p>
                            <p class="text-4xl font-bold text-pink-500">{{ $data['result']->skor }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center text-gray-500 py-12">
                    Belum ada data evaluasi
                </div>
                @endforelse
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
            leaderboardTab.classList.add('bg-pink-500', 'text-white');
            leaderboardTab.classList.remove('text-pink-500');
            evaluasiTab.classList.remove('bg-pink-200', 'text-pink-700');
            evaluasiTab.classList.add('text-pink-500');
            
            leaderboardContent.classList.remove('hidden');
            evaluasiContent.classList.add('hidden');
        } else {
            evaluasiTab.classList.add('bg-pink-200', 'text-pink-700');
            evaluasiTab.classList.remove('text-pink-500');
            leaderboardTab.classList.remove('bg-pink-500', 'text-white');
            leaderboardTab.classList.add('text-pink-500');
            
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