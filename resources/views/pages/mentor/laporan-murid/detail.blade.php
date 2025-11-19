{{-- resources/views/pages/mentor/laporan-murid/detail.blade.php --}}
<x-layouts.dashboard title="Detail Progres Murid">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        
        {{-- Header --}}
        <div class="mb-6">
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('mentor.laporan-murid.index') }}" 
                   class="text-gray-400 hover:text-white transition-colors">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="text-3xl text-white font-bold">Progres {{ $murid->user->username ?? 'Murid' }}</h1>
            </div>
            <p class="text-gray-400">Detail perkembangan murid bimbingan Anda</p>
        </div>

        @php
            // Calculate stats
            $leaderboard = $murid->leaderboards->where('mentor_id', $murid->mentor_id)->first();
            $totalPoin = $leaderboard ? $leaderboard->total_poin_semua_game : 0;
            
            // Poin per game
            $hasilGames = $murid->hasilGames;
            $poinPerGame = [
                'tracking' => $hasilGames->where('jenis_game_id', 1)->sum('total_poin'),
                'labirin' => $hasilGames->where('jenis_game_id', 3)->sum('total_poin'),
                'memory' => $hasilGames->where('jenis_game_id', 4)->sum('total_poin'),
                'drag_drop' => $hasilGames->where('jenis_game_id', 2)->sum('total_poin'),
            ];
            
            // Progress modul
            $totalModul = $murid->progressModuls->count();
            $modulSelesai = $murid->progressModuls->where('status', 'selesai')->count();
            $progressModul = $totalModul > 0 ? round(($modulSelesai / $totalModul) * 100) : 0;
            
            // Game per type count
            $gameCount = [
                'tracking' => $hasilGames->where('jenis_game_id', 1)->count(),
                'labirin' => $hasilGames->where('jenis_game_id', 3)->count(),
                'memory' => $hasilGames->where('jenis_game_id', 4)->count(),
                'drag_drop' => $hasilGames->where('jenis_game_id', 2)->count(),
            ];
            
            // Total waktu belajar (estimasi: setiap game = 5 menit, setiap modul = 10 menit)
            $totalGames = $hasilGames->count();
            $totalMinutes = ($totalGames * 5) + ($modulSelesai * 10);
            $totalHours = round($totalMinutes / 60, 1);
            
            // Level terakhir dipelajari
            $lastProgress = $murid->progressModuls()
                ->with('modul.materiPembelajaran.tingkatanIqra')
                ->latest('updated_at')
                ->first();
            
            $currentLevel = 'Belum mulai';
            if ($lastProgress && $lastProgress->modul && $lastProgress->modul->materiPembelajaran && $lastProgress->modul->materiPembelajaran->tingkatanIqra) {
                $currentLevel = $lastProgress->modul->materiPembelajaran->tingkatanIqra->nama_tingkatan;
            }
        @endphp

        {{-- Info Card Murid --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden mb-6">
            <div class="p-6">
                <div class="flex items-start gap-4">
                    {{-- Avatar --}}
                    <div class="flex-shrink-0">
                        <div class="w-20 h-20 bg-gradient-to-br from-pink-400 to-purple-500 rounded-full flex items-center justify-center text-white text-3xl font-bold shadow-lg">
                            {{ strtoupper(substr($murid->user->username ?? 'M', 0, 1)) }}
                        </div>
                    </div>
                    
                    {{-- Info --}}
                    <div class="flex-1">
                        <h2 class="text-2xl font-black text-gray-900 dark:text-white mb-3">
                            {{ $murid->user->username ?? 'Murid' }}
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            {{-- Email --}}
                            <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                <i class="fas fa-envelope w-5 text-pink-500"></i>
                                <span>{{ ($murid->user->username ?? 'murid') . '@gmail.com' }}</span>
                            </div>
                            
                            {{-- Sekolah --}}
                            @if($murid->sekolah)
                                <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                    <i class="fas fa-school w-5 text-pink-500"></i>
                                    <span>{{ $murid->sekolah }}</span>
                                </div>
                            @endif
                            
                            {{-- Bergabung --}}
                            <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                <i class="fas fa-calendar w-5 text-pink-500"></i>
                                <span>Bergabung {{ $murid->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Total Poin Badge --}}
                    <div class="flex-shrink-0">
                        <div class="bg-gradient-to-r bg-iqrain-pink-cerah text-white px-6 py-3 rounded-xl shadow-lg text-center">
                            <div class="text-3xl font-black">{{ number_format($totalPoin) }}</div>
                            <div class="text-xs mt-1 opacity-90">Total Poin</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            {{-- Progress Modul --}}
            <div class="bg-gradient-to-br bg-iqrain-pink-cerah rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-medium opacity-90">Progress Modul</h3>
                    <i class="fas fa-book-open text-2xl opacity-75"></i>
                </div>
                <div class="text-3xl font-black mb-1">{{ $progressModul }}%</div>
                <p class="text-xs opacity-75">{{ $modulSelesai }}/{{ $totalModul }} modul selesai</p>
            </div>

            {{-- Level Terakhir --}}
            <div class="bg-gradient-to-br bg-iqrain-pink-cerah rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-medium opacity-90">Level Saat Ini</h3>
                    <i class="fas fa-layer-group text-2xl opacity-75"></i>
                </div>
                <div class="text-xl font-black">{{ $currentLevel }}</div>
            </div>

            {{-- Total Game --}}
            <div class="bg-gradient-to-br bg-iqrain-pink-cerah rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-medium opacity-90">Game Dimainkan</h3>
                    <i class="fas fa-gamepad text-2xl opacity-75"></i>
                </div>
                <div class="text-3xl font-black">{{ $totalGames }}</div>
                <p class="text-xs opacity-75">kali bermain</p>
            </div>

            {{-- Waktu Belajar --}}
            <div class="bg-gradient-to-br bg-iqrain-pink-cerah rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-medium opacity-90">Waktu Belajar</h3>
                    <i class="fas fa-clock text-2xl opacity-75"></i>
                </div>
                <div class="text-3xl font-black">{{ $totalHours }}</div>
                <p class="text-xs opacity-75">jam (estimasi)</p>
            </div>
        </div>

        {{-- Charts & Details Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            {{-- Poin Per Game --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Poin Per Game</h3>
                <div class="space-y-4">
                    {{-- Tracking --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full bg-purple-500"></div>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Tracking</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">{{ number_format($poinPerGame['tracking']) }} poin</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-purple-500 h-2 rounded-full" style="width: {{ $totalPoin > 0 ? ($poinPerGame['tracking'] / $totalPoin * 100) : 0 }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $gameCount['tracking'] }} kali dimainkan</p>
                    </div>

                    {{-- Labirin --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full bg-cyan-400"></div>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Labirin</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">{{ number_format($poinPerGame['labirin']) }} poin</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-cyan-400 h-2 rounded-full" style="width: {{ $totalPoin > 0 ? ($poinPerGame['labirin'] / $totalPoin * 100) : 0 }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $gameCount['labirin'] }} kali dimainkan</p>
                    </div>

                    {{-- Memory Card --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full bg-pink-500"></div>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Memory Card</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">{{ number_format($poinPerGame['memory']) }} poin</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-pink-500 h-2 rounded-full" style="width: {{ $totalPoin > 0 ? ($poinPerGame['memory'] / $totalPoin * 100) : 0 }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $gameCount['memory'] }} kali dimainkan</p>
                    </div>

                    {{-- Kuis Drag & Drop --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full bg-orange-400"></div>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Kuis Drag & Drop</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">{{ number_format($poinPerGame['drag_drop']) }} poin</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-orange-400 h-2 rounded-full" style="width: {{ $totalPoin > 0 ? ($poinPerGame['drag_drop'] / $totalPoin * 100) : 0 }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $gameCount['drag_drop'] }} kali dimainkan</p>
                    </div>
                </div>
            </div>

            {{-- Progress Modul Chart --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Progress Pembelajaran</h3>
                
                <div class="flex items-center justify-center mb-6">
                    <div class="relative inline-flex items-center justify-center">
                        <svg class="transform -rotate-90 w-40 h-40">
                            <circle cx="80" cy="80" r="70" stroke="currentColor" stroke-width="12" fill="transparent" class="text-gray-200 dark:text-gray-700" />
                            <circle cx="80" cy="80" r="70" stroke="currentColor" stroke-width="12" fill="transparent" 
                                    stroke-dasharray="{{ 2 * 3.14159 * 70 }}" 
                                    stroke-dashoffset="{{ 2 * 3.14159 * 70 * (1 - $progressModul / 100) }}" 
                                    class="text-pink-500" 
                                    stroke-linecap="round" />
                        </svg>
                        <span class="absolute text-4xl font-black text-pink-500">{{ $progressModul }}%</span>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Modul Selesai</span>
                        <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $modulSelesai }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Total Modul</span>
                        <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $totalModul }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Level Saat Ini</span>
                        <span class="text-sm font-bold text-pink-500">{{ $currentLevel }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Activity --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Aktivitas Terakhir</h3>
            
            @php
                $recentActivities = $murid->hasilGames()
                    ->with('jenisGame')
                    ->latest('dimainkan_at')
                    ->take(5)
                    ->get();
            @endphp

            @if($recentActivities->count() > 0)
                <div class="space-y-3">
                    @foreach($recentActivities as $activity)
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-pink-100 dark:bg-pink-900/30 rounded-full flex items-center justify-center">
                                    <i class="fas fa-gamepad text-pink-500"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $activity->jenisGame->nama_game ?? 'Game' }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $activity->dimainkan_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-pink-500">+{{ $activity->total_poin }} poin</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Skor: {{ $activity->skor }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-inbox text-4xl text-gray-300 dark:text-gray-600 mb-3"></i>
                    <p class="text-gray-500 dark:text-gray-400">Belum ada aktivitas</p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.dashboard>