<x-layouts.dashboard>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        {{-- Welcome Banner --}}
        <div class="relative bg-gradient-to-r from-pink-400 via-pink-500 to-pink-600 rounded-3xl shadow-xl mb-8 overflow-hidden">
            <div class="absolute inset-0 bg-white/10 backdrop-blur-sm"></div>
            <div class="relative px-8 py-10 sm:px-12 sm:py-8">
                <div class="flex flex-col sm:flex-row items-center justify-between">
                    <div class="text-white mb-6 sm:mb-0">
                        <h1 class="text-3xl sm:text-4xl font-bold mb-2">Selamat Datang Admin</h1>
                        <p class="text-lg sm:text-xl text-white/90">Kelola sistem dan pantau semua aktivitas IQRAIN</p>
                    </div>
                    {{-- Qira Mascot --}}
                    <div class="flex-shrink-0">
                        <img src="{{ asset('images/maskot/maskot_1.webp') }}" 
                             alt="Qira" 
                             class="w-32 h-32 sm:w-40 sm:h-40 object-contain drop-shadow-2xl"
                             onerror="this.style.display='none'">
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Stats Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            {{-- Total Murids --}}
            <div class="bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-2xl shadow-lg p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-100 text-sm font-medium mb-1">Total Murid</p>
                        <h3 class="text-4xl font-bold">{{ $stats['total_murids'] }}</h3>
                        <p class="text-yellow-100 text-xs mt-2">
                            <span class="font-semibold">{{ $stats['active_murids'] }}</span> aktif minggu ini
                        </p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4">
                        <i class="fas fa-users text-4xl"></i>
                    </div>
                </div>
            </div>

            {{-- Active Mentors --}}
            <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl shadow-lg p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium mb-1">Mentor Aktif</p>
                        <h3 class="text-4xl font-bold">{{ $stats['approved_mentors'] }}</h3>
                        <p class="text-blue-100 text-xs mt-2">
                            <span class="font-semibold">{{ $stats['pending_mentors'] }}</span> menunggu persetujuan
                        </p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4">
                        <i class="fas fa-chalkboard-teacher text-4xl"></i>
                    </div>
                </div>
            </div>

            {{-- Pending Requests --}}
            <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-2xl shadow-lg p-6 text-white transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm font-medium mb-1">Permintaan</p>
                        <h3 class="text-4xl font-bold">{{ $stats['pending_requests'] }}</h3>
                        <p class="text-red-100 text-xs mt-2">
                            Bimbingan menunggu
                        </p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4">
                        <i class="fas fa-clock text-4xl"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Secondary Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            
            {{-- Videos Available --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border-l-4 border-blue-400 transform transition-all hover:shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm font-medium mb-1">Video Tersedia</p>
                        <h4 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $stats['total_videos'] }}</h4>
                    </div>
                    <div class="bg-blue-100 dark:bg-blue-900/30 rounded-lg p-3">
                        <i class="fas fa-video text-3xl text-blue-600 dark:text-blue-400"></i>
                    </div>
                </div>
            </div>

            {{-- Games Played Today --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border-l-4 border-green-400 transform transition-all hover:shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm font-medium mb-1">Game Hari Ini</p>
                        <h4 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $stats['games_today'] }}</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $stats['games_this_week'] }} minggu ini</p>
                    </div>
                    <div class="bg-green-100 dark:bg-green-900/30 rounded-lg p-3">
                        <i class="fas fa-gamepad text-3xl text-green-600 dark:text-green-400"></i>
                    </div>
                </div>
            </div>

            {{-- Total Users --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border-l-4 border-purple-400 transform transition-all hover:shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm font-medium mb-1">Total Pengguna</p>
                        <h4 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $stats['total_users'] }}</h4>
                    </div>
                    <div class="bg-purple-100 dark:bg-purple-900/30 rounded-lg p-3">
                        <i class="fas fa-user-friends text-3xl text-purple-600 dark:text-purple-400"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            
            {{-- Recent Activities --}}
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-md">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-history text-gray-600 dark:text-gray-400"></i>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Aktivitas Terbaru</h3>
                    </div>
                    <span class="text-xs text-gray-500 dark:text-gray-400">10 terakhir</span>
                </div>
                <div class="p-6 max-h-[500px] overflow-y-auto custom-scrollbar">
                    <div class="space-y-4">
                        @forelse($recent_activities as $activity)
                        <div class="flex items-center space-x-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            <div class="flex-shrink-0">
                                <img src="{{ $activity->murid->user->avatar_url ?? asset('images/default-avatar.png') }}" 
                                     alt="Avatar" 
                                     class="w-12 h-12 rounded-full object-cover border-2 border-white dark:border-gray-600"
                                     onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 100 100%27%3E%3Ccircle cx=%2750%27 cy=%2750%27 r=%2740%27 fill=%27%23E5E7EB%27/%3E%3C/svg%3E';">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                    {{ $activity->murid->user->username }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Bermain <span class="font-semibold">{{ $activity->jenisGame->nama_game }}</span>
                                </p>
                            </div>
                            <div class="flex flex-col items-end">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                    <i class="fas fa-star mr-1"></i>
                                    {{ $activity->skor }}
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    {{ $activity->dimainkan_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-12">
                            <i class="fas fa-inbox text-5xl text-gray-400 mb-3"></i>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Belum ada aktivitas</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Pending Mentor Approvals --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-user-clock text-gray-600 dark:text-gray-400"></i>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Menunggu Persetujuan</h3>
                    </div>
                    @if($stats['pending_mentors'] > 0)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                        {{ $stats['pending_mentors'] }}
                    </span>
                    @endif
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($pending_mentors as $mentor)
                        <div class="flex items-center space-x-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <img src="{{ $mentor->user->avatar_url ?? asset('images/default-avatar.png') }}" 
                                 alt="Avatar" 
                                 class="w-10 h-10 rounded-full object-cover"
                                 onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 100 100%27%3E%3Ccircle cx=%2750%27 cy=%2750%27 r=%2740%27 fill=%27%23E5E7EB%27/%3E%3C/svg%3E';">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                    {{ $mentor->nama_lengkap }}
                                </p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                    {{ $mentor->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <i class="fas fa-check-circle text-4xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Semua sudah disetujui</p>
                        </div>
                        @endforelse
                    </div>
                    @if($stats['pending_mentors'] > 0)
                    <div class="mt-4">
                        <a href="{{ route('admin.approval') }}" class="block w-full text-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                            <i class="fas fa-list mr-2"></i>Lihat Semua
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Game Statistics & Top Performers --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            {{-- Game Statistics --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center space-x-2">
                    <i class="fas fa-chart-bar text-gray-600 dark:text-gray-400"></i>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Statistik Game</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-5">
                        @foreach($game_stats as $game)
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-gamepad text-xs mr-1"></i>
                                        {{ $game->nama_game }}
                                    </span>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $game->total_plays }}x</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2.5 rounded-full transition-all duration-300" 
                                         style="width: {{ min($game->avg_score, 100) }}%"></div>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Rata-rata: {{ number_format($game->avg_score, 1) }}%</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Top Performers --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center space-x-2">
                    <i class="fas fa-trophy text-yellow-500"></i>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Top Performers</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        @forelse($top_murids as $index => $murid)
                        <div class="flex items-center space-x-4 p-3 bg-gradient-to-r {{ $index === 0 ? 'from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20' : ($index === 1 ? 'from-gray-100 to-gray-200 dark:from-gray-700/50 dark:to-gray-600/50' : 'from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20') }} rounded-lg">
                            <div class="flex-shrink-0">
                                @if($index === 0)
                                    <div class="w-8 h-8 flex items-center justify-center rounded-full bg-yellow-500 text-white font-bold">
                                        <i class="fas fa-crown"></i>
                                    </div>
                                @elseif($index === 1)
                                    <div class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-400 text-white font-bold">
                                        <i class="fas fa-medal"></i>
                                    </div>
                                @elseif($index === 2)
                                    <div class="w-8 h-8 flex items-center justify-center rounded-full bg-orange-500 text-white font-bold">
                                        <i class="fas fa-medal"></i>
                                    </div>
                                @else
                                    <div class="w-8 h-8 flex items-center justify-center text-2xl font-bold text-gray-400">
                                        #{{ $index + 1 }}
                                    </div>
                                @endif
                            </div>
                            <img src="{{ $murid->user->avatar_url ?? asset('images/default-avatar.png') }}" 
                                 alt="Avatar" 
                                 class="w-12 h-12 rounded-full object-cover border-2 {{ $index === 0 ? 'border-yellow-400' : 'border-gray-300' }}"
                                 onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 100 100%27%3E%3Ccircle cx=%2750%27 cy=%2750%27 r=%2740%27 fill=%27%23E5E7EB%27/%3E%3C/svg%3E';">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $murid->user->username }}
                                </p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                    <i class="fas fa-star text-yellow-500 text-xs mr-1"></i>
                                    {{ number_format($murid->hasil_games_sum_total_poin ?? 0) }} poin
                                </p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <i class="fas fa-chart-line text-4xl text-gray-400 mb-2"></i>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Belum ada data performa</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('styles')
    <style>
        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        .dark .custom-scrollbar::-webkit-scrollbar-track {
            background: #2d3748;
        }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #4a5568;
        }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #718096;
        }
    </style>
    @endpush
</x-layouts.dashboard>