{{-- resources/views/pages/mentor/dashboard.blade.php --}}
<x-layouts.dashboard title="Dashboard Mentor">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        
        {{-- Welcome Header --}}
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl text-white dark:text-white font-bold mb-2">
                Selamat datang, <span class="text-iqrain-yellow"> {{ Auth::user()->mentor->nama_lengkap ?? 'Mentor' }}!</span>
            </h1>
            <p class="text-white dark:text-gray-400">Kelola dan pantau progres murid Anda</p>
        </div>

        {{-- Stats Cards Row - Clean Design --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            {{-- Total Murid (Pink) --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6 transform transition-all duration-300 hover:shadow-xl relative overflow-hidden">
                <div class="absolute top-4 right-4">
                    <div class="bg-iqrain-pink/10 rounded-full p-3 w-14 h-14 flex items-center justify-center">
                        <i class="fas fa-users text-xl text-iqrain-pink"></i>
                    </div>
                </div>
                
                <div class="mt-2 pr-16">
                    <h3 class="text-4xl font-bold text-gray-800 dark:text-white mb-2 leading-none">
                        {{ number_format($totalMurids) }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-medium mb-3">Total Murid</p>
                    
                    <div class="flex items-center text-xs">
                        <span class="text-gray-500 dark:text-gray-400">Murid yang Anda bimbing</span>
                    </div>
                </div>
            </div>

            {{-- Permintaan Pending (Blue) --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6 transform transition-all duration-300 hover:shadow-xl relative overflow-hidden">
                <div class="absolute top-4 right-4">
                    <div class="bg-iqrain-blue/10 rounded-full p-3 w-14 h-14 flex items-center justify-center">
                        <i class="fas fa-bell text-xl text-iqrain-blue"></i>
                    </div>
                </div>
                
                <div class="mt-2 pr-16">
                    <h3 class="text-4xl font-bold text-gray-800 dark:text-white mb-2 leading-none">
                        {{ number_format($totalPendingRequests) }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-medium mb-3">Permintaan Baru</p>
                    
                    @if($totalPendingRequests > 0)
                        <a href="{{ route('mentor.permintaan.index') }}" class="flex items-center text-xs text-iqrain-blue hover:underline">
                            <span>Lihat permintaan</span>
                            <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    @else
                        <p class="text-gray-400 text-xs">Tidak ada permintaan baru</p>
                    @endif
                </div>
            </div>

            {{-- Aktivitas Minggu Ini (Pink) --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6 transform transition-all duration-300 hover:shadow-xl relative overflow-hidden">
                <div class="absolute top-4 right-4">
                    <div class="bg-iqrain-pink/10 rounded-full p-3 w-14 h-14 flex items-center justify-center">
                        <i class="fas fa-gamepad text-xl text-iqrain-pink"></i>
                    </div>
                </div>
                
                <div class="mt-2 pr-16">
                    <h3 class="text-4xl font-bold text-gray-800 dark:text-white mb-2 leading-none">
                        {{ number_format($totalGamesWeek) }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-medium mb-3">Game Minggu Ini</p>
                    
                    <div class="flex items-center text-xs">
                        @if($growthPercentage > 0)
                            <i class="fas fa-arrow-up text-green-500 mr-1"></i>
                            <span class="text-green-500 font-semibold">+{{ $growthPercentage }}%</span>
                        @elseif($growthPercentage < 0)
                            <i class="fas fa-arrow-down text-red-500 mr-1"></i>
                            <span class="text-red-500 font-semibold">{{ $growthPercentage }}%</span>
                        @else
                            <i class="fas fa-minus text-gray-500 mr-1"></i>
                            <span class="text-gray-500 font-semibold">0%</span>
                        @endif
                        <span class="text-gray-500 dark:text-gray-400 ml-1">dari minggu lalu</span>
                    </div>
                </div>
            </div>

            {{-- Rata-rata Progress (Blue) --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6 transform transition-all duration-300 hover:shadow-xl relative overflow-hidden">
                <div class="absolute top-4 right-4">
                    <div class="bg-iqrain-blue/10 rounded-full p-3 w-14 h-14 flex items-center justify-center">
                        <i class="fas fa-chart-line text-xl text-iqrain-blue"></i>
                    </div>
                </div>
                
                <div class="mt-2 pr-16">
                    <h3 class="text-4xl font-bold text-gray-800 dark:text-white mb-2 leading-none">
                        {{ $avgProgress }}%
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-medium mb-3">Rata-rata Progress</p>
                    
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-iqrain-blue h-2 rounded-full transition-all duration-300" style="width: {{ $avgProgress }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <a href="{{ route('mentor.murid.create') }}" class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6 hover:shadow-xl transition-all duration-300 group">
                <div class="flex items-center gap-4">
                    <div class="bg-iqrain-pink/10 rounded-xl p-4 group-hover:bg-iqrain-pink transition-colors duration-200">
                        <i class="fas fa-user-plus text-2xl text-iqrain-pink group-hover:text-white transition-colors duration-200"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 dark:text-white">Tambah Murid</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Daftarkan murid baru</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('mentor.laporan-murid.index') }}" class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6 hover:shadow-xl transition-all duration-300 group">
                <div class="flex items-center gap-4">
                    <div class="bg-iqrain-blue/10 rounded-xl p-4 group-hover:bg-iqrain-blue transition-colors duration-200">
                        <i class="fas fa-chart-bar text-2xl text-iqrain-blue group-hover:text-white transition-colors duration-200"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 dark:text-white">Lihat Laporan</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Progres murid</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('mentor.laporan-kelas.index') }}" class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6 hover:shadow-xl transition-all duration-300 group">
                <div class="flex items-center gap-4">
                    <div class="bg-iqrain-pink/10 rounded-xl p-4 group-hover:bg-iqrain-pink transition-colors duration-200">
                        <i class="fas fa-users text-2xl text-iqrain-pink group-hover:text-white transition-colors duration-200"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 dark:text-white">Statistik Kelas</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Analisis kelas</p>
                    </div>
                </div>
            </a>
        </div>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            {{-- Aktivitas Harian Chart (2 columns) --}}
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                        <i class="fas fa-chart-bar text-iqrain-pink mr-2"></i>
                        Aktivitas 7 Hari Terakhir
                    </h3>
                    <div class="text-xs text-gray-500 dark:text-gray-400">
                        <i class="fas fa-calendar mr-1"></i>
                        {{ Carbon\Carbon::now()->format('d M Y') }}
                    </div>
                </div>
                <div style="height: 300px;">
                    <canvas id="dailyActivityChart"></canvas>
                </div>
            </div>

            {{-- Top 3 Murid --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6 flex items-center">
                    <i class="fas fa-trophy text-iqrain-pink mr-2"></i>
                    Top 3 Murid
                </h3>
                <div class="space-y-3">
                    @forelse($topMurids as $index => $top)
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 hover:bg-iqrain-pink/5 dark:hover:bg-gray-700 transition">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0">
                                    @if($index === 0)
                                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-full flex items-center justify-center text-white font-bold shadow-lg">
                                            <i class="fas fa-crown"></i>
                                        </div>
                                    @elseif($index === 1)
                                        <div class="w-12 h-12 bg-gray-400 rounded-full flex items-center justify-center text-white font-bold">
                                            <i class="fas fa-medal"></i>
                                        </div>
                                    @else
                                        <div class="w-12 h-12 bg-orange-400 rounded-full flex items-center justify-center text-white font-bold">
                                            <i class="fas fa-medal"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-gray-900 dark:text-white truncate">{{ $top['murid']->user->username ?? 'Murid' }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        <i class="fas fa-star text-iqrain-pink text-xs mr-1"></i>
                                        {{ number_format($top['poin']) }} poin
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <i class="fas fa-users text-4xl text-gray-300 dark:text-gray-600 mb-2"></i>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Belum ada murid</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Second Row Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            {{-- Game Populer --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6 flex items-center">
                    <i class="fas fa-gamepad text-iqrain-pink mr-2"></i>
                    Game Paling Populer
                </h3>
                <div class="space-y-3">
                    @php
                        $gameIcons = [
                            'Tracking' => ['icon' => 'fa-pencil-alt', 'color' => 'iqrain-pink'],
                            'Labirin' => ['icon' => 'fa-map-signs', 'color' => 'iqrain-blue'],
                            'Memory Card' => ['icon' => 'fa-th', 'color' => 'iqrain-pink'],
                            'Kuis Drag & Drop' => ['icon' => 'fa-puzzle-piece', 'color' => 'iqrain-blue'],
                        ];
                    @endphp
                    
                    @forelse($popularGames as $game)
                        @php
                            $gameInfo = $gameIcons[$game['name']] ?? ['icon' => 'fa-gamepad', 'color' => 'iqrain-pink'];
                        @endphp
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl hover:bg-iqrain-pink/5 dark:hover:bg-gray-700 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-{{ $gameInfo['color'] }}/10 rounded-xl flex items-center justify-center">
                                    <i class="fas {{ $gameInfo['icon'] }} text-xl text-{{ $gameInfo['color'] }}"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $game['name'] }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $game['total'] }} kali dimainkan</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-iqrain-pink">{{ $game['total'] }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <i class="fas fa-gamepad text-4xl text-gray-300 dark:text-gray-600 mb-2"></i>
                            <p class="text-gray-500 dark:text-gray-400">Belum ada game dimainkan</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Murid Terbaru --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6 flex items-center">
                    <i class="fas fa-user-plus text-iqrain-blue mr-2"></i>
                    Murid Terbaru
                </h3>
                <div class="space-y-3">
                    @forelse($recentMurids as $murid)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl hover:bg-iqrain-blue/5 dark:hover:bg-gray-700 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-iqrain-pink to-iqrain-blue rounded-full flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr($murid->user->username ?? 'M', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $murid->user->username ?? 'Murid' }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Bergabung {{ $murid->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <a href="{{ route('mentor.laporan-murid.detail', $murid->murid_id) }}" class="text-iqrain-blue hover:text-iqrain-pink transition">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <i class="fas fa-user-plus text-4xl text-gray-300 dark:text-gray-600 mb-2"></i>
                            <p class="text-gray-500 dark:text-gray-400">Belum ada murid</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Aktivitas Terbaru --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6 flex items-center">
                <i class="fas fa-history text-iqrain-pink mr-2"></i>
                Aktivitas Terbaru
            </h3>
            <div class="space-y-3 max-h-[500px] overflow-y-auto custom-scrollbar">
                @forelse($recentActivities as $activity)
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl hover:bg-iqrain-pink/5 dark:hover:bg-gray-700 transition">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-iqrain-pink/10 rounded-xl flex items-center justify-center">
                                <i class="fas fa-gamepad text-xl text-iqrain-pink"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">
                                    {{ $activity->murid->user->username ?? 'Murid' }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Bermain {{ $activity->jenisGame->nama_game ?? 'Game' }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-iqrain-pink">+{{ $activity->total_poin }} poin</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $activity->dimainkan_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <i class="fas fa-history text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                        <p class="text-gray-500 dark:text-gray-400 text-lg">Belum ada aktivitas</p>
                        <p class="text-gray-400 dark:text-gray-500 text-sm mt-2">Aktivitas murid akan muncul di sini</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Chart.js Script --}}
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Daily Activity Chart
        const dailyCtx = document.getElementById('dailyActivityChart');
        const dailyData = @json($dailyActivity);
        
        new Chart(dailyCtx, {
            type: 'bar',
            data: {
                labels: dailyData.map(d => d.date),
                datasets: [{
                    label: 'Aktivitas',
                    data: dailyData.map(d => d.count),
                    backgroundColor: 'rgba(236, 72, 153, 0.8)',
                    borderColor: '#ec4899',
                    borderWidth: 2,
                    borderRadius: 8,
                    hoverBackgroundColor: '#ec4899',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                return 'Aktivitas: ' + context.parsed.y + ' kali';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            color: '#9ca3af',
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            color: 'rgba(156, 163, 175, 0.1)',
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: {
                            color: '#9ca3af',
                            font: {
                                size: 12,
                                weight: 'bold'
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
    @endpush
</x-layouts.dashboard>