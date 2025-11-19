{{-- resources/views/pages/mentor/laporan-kelas/index.blade.php --}}
<x-layouts.dashboard title="Laporan Kelas">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        
        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-3xl text-white font-black">Progres Kelas</h1>
            <p class="text-gray-400 mt-1">Lihat perkembangan kelas yang dibimbing</p>
        </div>

        {{-- Stats Cards Row --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            {{-- Total Murid --}}
            <div class="bg-iqrain-pink-cerah rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white/90 text-sm font-medium">Total Murid</p>
                        <h3 class="text-3xl font-black mt-2">{{ $totalMurids }}</h3>
                    </div>
                    <div class="bg-white/20 rounded-full p-4">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                </div>
            </div>

            {{-- Rata-rata Progress --}}
            <div class="bg-iqrain-pink-cerah rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white/90 text-sm font-medium">Rata-rata Progress</p>
                        <h3 class="text-3xl font-black mt-2">{{ $avgProgress }}%</h3>
                    </div>
                    <div class="bg-white/20 rounded-full p-4">
                        <i class="fas fa-chart-line text-2xl"></i>
                    </div>
                </div>
            </div>

            {{-- Total Game Dimainkan --}}
            <div class="bg-iqrain-pink-cerah rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white/90 text-sm font-medium">Game Dimainkan</p>
                        <h3 class="text-3xl font-black mt-2">{{ $totalGamesPlayed }}</h3>
                    </div>
                    <div class="bg-white/20 rounded-full p-4">
                        <i class="fas fa-gamepad text-2xl"></i>
                    </div>
                </div>
            </div>

            {{-- Total Waktu Belajar --}}
            <div class="bg-iqrain-pink-cerah rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white/90 text-sm font-medium">Waktu Belajar</p>
                        <h3 class="text-3xl font-black mt-2">{{ $totalHours }}</h3>
                        <p class="text-white/90 text-xs mt-1">jam</p>
                    </div>
                    <div class="bg-white/20 rounded-full p-4">
                        <i class="fas fa-clock text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts Row --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            {{-- Game Paling Sering Dimainkan --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Game yang paling sering dimainkan</h3>
                <div class="flex items-center justify-center" style="height: 300px;">
                    <canvas id="gameChart"></canvas>
                </div>
                
                {{-- Legend --}}
                <div class="mt-6 grid grid-cols-2 gap-3">
                    @php
                        $colors = [
                            'Tracking' => ['bg' => 'bg-blue-500', 'text' => 'text-blue-700'],
                            'Labirin' => ['bg' => 'bg-yellow-500', 'text' => 'text-yellow-700'],
                            'Memory Card' => ['bg' => 'bg-iqrain-pink-cerah', 'text' => 'text-pink-700'],
                            'Kuis Drag & Drop' => ['bg' => 'bg-purple-500', 'text' => 'text-purple-700'],
                        ];
                    @endphp
                    
                    @foreach($gameStats as $game)
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 rounded-full {{ $colors[$game['name']]['bg'] ?? 'bg-gray-400' }}"></div>
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $game['name'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Progress Harian --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Progres harian bulan ini</h3>
                <div style="height: 300px;">
                    <canvas id="dailyChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Info Cards Row --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Murid Paling Aktif --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-2">
                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Murid Paling Aktif</h4>
                    <i class="fas fa-star text-yellow-500 text-xl"></i>
                </div>
                <p class="text-2xl font-black text-gray-900 dark:text-white">{{ $mostActiveMuridName }}</p>
            </div>

            {{-- Level Populer --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-2">
                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Level Populer</h4>
                    <i class="fas fa-fire text-orange-500 text-xl"></i>
                </div>
                <p class="text-2xl font-black text-gray-900 dark:text-white">{{ $popularLevelName }}</p>
            </div>

            {{-- Rata-rata Progress --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-2">
                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Rata-rata Progress</h4>
                    <i class="fas fa-chart-pie text-blue-500 text-xl"></i>
                </div>
                <p class="text-2xl font-black" style="color: #E91E63;">{{ $avgProgress }}%</p>
            </div>
        </div>
    </div>

    {{-- Chart.js Scripts --}}
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Game Donut Chart
        const gameCtx = document.getElementById('gameChart');
        const gameData = @json($gameStats);
        
        const gameColors = {
            'Tracking': '#3b82f6',      // blue-500 - more contrast
            'Labirin': '#eab308',        // yellow-500 - more contrast
            'Memory Card': '#E91E63',    // vibrant pink - Material Design
            'Kuis Drag & Drop': '#a855f7', // purple-500 - more contrast
        };
        
        new Chart(gameCtx, {
            type: 'doughnut',
            data: {
                labels: gameData.map(g => g.name),
                datasets: [{
                    data: gameData.map(g => g.total),
                    backgroundColor: gameData.map(g => gameColors[g.name] || '#9ca3af'),
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.parsed + ' kali';
                            }
                        }
                    }
                },
                cutout: '70%'
            }
        });

        // Daily Progress Line Chart
        const dailyCtx = document.getElementById('dailyChart');
        const dailyData = @json($dailyProgress);
        
        new Chart(dailyCtx, {
            type: 'line',
            data: {
                labels: dailyData.map(d => d.date),
                datasets: [{
                    label: 'Aktivitas Harian',
                    data: dailyData.map(d => d.count),
                    borderColor: '#E91E63',           // vibrant pink - Material Design
                    backgroundColor: 'rgba(233, 30, 99, 0.15)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#E91E63',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
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
                        mode: 'index',
                        intersect: false,
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
                            color: '#9ca3af'
                        },
                        grid: {
                            color: 'rgba(156, 163, 175, 0.1)'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#9ca3af',
                            maxRotation: 45,
                            minRotation: 45
                        },
                        grid: {
                            display: false
                        }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });
    </script>
    @endpush
</x-layouts.dashboard>