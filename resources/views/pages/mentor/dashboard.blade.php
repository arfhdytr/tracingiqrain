{{-- resources/views/pages/mentor/dashboard.blade.php --}}
<x-layouts.dashboard title="Dashboard Mentor">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        
        {{-- Welcome Header --}}
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl text-white font-black mb-2">
                Selamat datang, {{ Auth::user()->mentor->nama_lengkap ?? 'Mentor' }}! 👋
            </h1>
        </div>

        {{-- Stats Cards Row --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            {{-- Total Murid (Pink) --}}
            <div class="bg-gradient-to-br from-pink-400 to-pink-500 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-transform duration-200">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-pink-100 text-sm font-medium mb-1">Total Murid</p>
                        <h3 class="text-4xl font-black">{{ $totalMurids }}</h3>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4">
                        <i class="fas fa-users text-3xl"></i>
                    </div>
                </div>
                <div class="flex items-center text-pink-100 text-xs">
                    <i class="fas fa-arrow-up mr-1"></i>
                    <span>Murid yang Anda bimbing</span>
                </div>
            </div>

            {{-- Permintaan Pending (Putih) --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 border-2 border-pink-200 dark:border-pink-900 transform hover:scale-105 transition-transform duration-200">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-1">Permintaan Baru</p>
                        <h3 class="text-4xl font-black text-pink-500">{{ $totalPendingRequests }}</h3>
                    </div>
                    <div class="bg-pink-100 dark:bg-pink-900/30 rounded-xl p-4">
                        <i class="fas fa-bell text-3xl text-pink-500"></i>
                    </div>
                </div>
                @if($totalPendingRequests > 0)
                    <a href="{{ route('mentor.permintaan.index') }}" class="flex items-center text-pink-600 dark:text-pink-400 text-xs font-medium hover:underline">
                        <span>Lihat permintaan</span>
                        <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                @else
                    <p class="text-gray-400 text-xs">Tidak ada permintaan baru</p>
                @endif
            </div>

            {{-- Aktivitas Minggu Ini (Diubah menjadi Pink) --}}
            <div class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-transform duration-200">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-pink-100 text-sm font-medium mb-1">Game Minggu Ini</p>
                        <h3 class="text-4xl font-black">{{ $totalGamesWeek }}</h3>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4">
                        <i class="fas fa-gamepad text-3xl"></i>
                    </div>
                </div>
                <div class="flex items-center text-pink-100 text-xs">
                    @if($growthPercentage > 0)
                        <i class="fas fa-arrow-up mr-1"></i>
                        <span>+{{ $growthPercentage }}% dari minggu lalu</span>
                    @elseif($growthPercentage < 0)
                        <i class="fas fa-arrow-down mr-1"></i>
                        <span>{{ $growthPercentage }}% dari minggu lalu</span>
                    @else
                        <i class="fas fa-minus mr-1"></i>
                        <span>Sama dengan minggu lalu</span>
                    @endif
                </div>
            </div>

            {{-- Rata-rata Progress (Diubah menjadi Putih) --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 border-2 border-pink-200 dark:border-pink-900 transform hover:scale-105 transition-transform duration-200">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        {{-- Mengubah teks menjadi gelap karena latar belakang putih --}}
                        <p class="text-gray-500 dark:text-gray-400 text-sm font-medium mb-1">Rata-rata Progress</p>
                        <h3 class="text-4xl font-black text-pink-500">{{ $avgProgress }}%</h3>
                    </div>
                    <div class="bg-pink-100 dark:bg-pink-900/30 rounded-xl p-4">
                        {{-- Mengubah ikon menjadi pink agar kontras dengan latar belakang putih --}}
                        <i class="fas fa-chart-line text-3xl text-pink-500"></i>
                    </div>
                </div>
                {{-- Mengubah progress bar menjadi pink --}}
                <div class="w-full bg-pink-100/50 rounded-full h-2 mt-2">
                    <div class="bg-pink-500 h-2 rounded-full" style="width: {{ $avgProgress }}%"></div>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <a href="{{ route('mentor.murid.create') }}" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 hover:shadow-2xl transition-shadow duration-200 group">
                <div class="flex items-center gap-4">
                    <div class="bg-pink-100 dark:bg-pink-900/30 rounded-xl p-4 group-hover:bg-pink-500 transition-colors duration-200">
                        <i class="fas fa-user-plus text-2xl text-pink-500 group-hover:text-white transition-colors duration-200"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 dark:text-white">Tambah Murid</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Daftarkan murid baru</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('mentor.laporan-murid.index') }}" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 hover:shadow-2xl transition-shadow duration-200 group">
                <div class="flex items-center gap-4">
                    <div class="bg-purple-100 dark:bg-purple-900/30 rounded-xl p-4 group-hover:bg-purple-500 transition-colors duration-200">
                        <i class="fas fa-chart-bar text-2xl text-purple-500 group-hover:text-white transition-colors duration-200"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 dark:text-white">Lihat Laporan</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Progres murid</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('mentor.laporan-kelas.index') }}" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 hover:shadow-2xl transition-shadow duration-200 group">
                <div class="flex items-center gap-4">
                    <div class="bg-blue-100 dark:bg-blue-900/30 rounded-xl p-4 group-hover:bg-blue-500 transition-colors duration-200">
                        
                        <i class="fas fa-chart-bar text-2xl text-blue-500 group-hover:text-white transition-colors duration-200"></i>
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
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-black text-gray-900 dark:text-white">Aktivitas 7 Hari Terakhir</h3>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        <i class="fas fa-calendar mr-1"></i>
                        {{ Carbon\Carbon::now()->format('d M Y') }}
                    </div>
                </div>
                <div style="height: 300px;">
                    <canvas id="dailyActivityChart"></canvas>
                </div>
            </div>

            {{-- Top 3 Murid --}}
            <div class="bg-gradient-to-br from-pink-400 to-pink-500 rounded-2xl shadow-xl p-6 text-white">
                <h3 class="text-xl font-black mb-6 flex items-center">
                    <i class="fas fa-trophy mr-2"></i>
                    Top 3 Murid
                </h3>
                <div class="space-y-4">
                    @forelse($topMurids as $index => $top)
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0">
                                    @if($index === 0)
                                        <div class="w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center text-2xl font-black">
                                            🥇
                                        </div>
                                    @elseif($index === 1)
                                        <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center text-2xl font-black">
                                            🥈
                                        </div>
                                    @else
                                        <div class="w-12 h-12 bg-orange-400 rounded-full flex items-center justify-center text-2xl font-black">
                                            🥉
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-bold truncate">{{ $top['murid']->user->username ?? 'Murid' }}</p>
                                    <p class="text-sm text-pink-100">{{ number_format($top['poin']) }} poin</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <i class="fas fa-users text-4xl text-pink-200 mb-2"></i>
                            <p class="text-pink-100 text-sm">Belum ada murid</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Second Row Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            {{-- Game Populer --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6">
                <h3 class="text-xl font-black text-gray-900 dark:text-white mb-6">Game Paling Populer</h3>
                <div class="space-y-4">
                    @php
                        $gameIcons = [
                            'Tracking' => ['icon' => 'fa-pencil-alt', 'color' => 'purple'],
                            'Labirin' => ['icon' => 'fa-map-signs', 'color' => 'cyan'],
                            'Memory Card' => ['icon' => 'fa-th', 'color' => 'pink'],
                            'Kuis Drag & Drop' => ['icon' => 'fa-puzzle-piece', 'color' => 'orange'],
                        ];
                    @endphp
                    
                    @forelse($popularGames as $game)
                        @php
                            $gameInfo = $gameIcons[$game['name']] ?? ['icon' => 'fa-gamepad', 'color' => 'gray'];
                        @endphp
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-{{ $gameInfo['color'] }}-100 dark:bg-{{ $gameInfo['color'] }}-900/30 rounded-xl flex items-center justify-center">
                                    <i class="fas {{ $gameInfo['icon'] }} text-xl text-{{ $gameInfo['color'] }}-500"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 dark:text-white">{{ $game['name'] }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $game['total'] }} kali dimainkan</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-black text-pink-500">{{ $game['total'] }}</div>
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
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6">
                <h3 class="text-xl font-black text-gray-900 dark:text-white mb-6">Murid Terbaru</h3>
                <div class="space-y-3">
                    @forelse($recentMurids as $murid)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-pink-400 to-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr($murid->user->username ?? 'M', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $murid->user->username ?? 'Murid' }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Bergabung {{ $murid->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <a href="{{ route('mentor.laporan-murid.detail', $murid->murid_id) }}" class="text-pink-500 hover:text-pink-600">
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
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6">
            <h3 class="text-xl font-black text-gray-900 dark:text-white mb-6">Aktivitas Terbaru</h3>
            <div class="space-y-3">
                @forelse($recentActivities as $activity)
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-xl hover:shadow-md transition-shadow duration-200">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-pink-100 dark:bg-pink-900/30 rounded-xl flex items-center justify-center">
                                <i class="fas fa-gamepad text-xl text-pink-500"></i>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 dark:text-white">
                                    {{ $activity->murid->user->username ?? 'Murid' }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Bermain {{ $activity->jenisGame->nama_game ?? 'Game' }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-pink-500">+{{ $activity->total_poin }} poin</p>
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