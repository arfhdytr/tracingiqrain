{{-- resources/views/livewire/admin/tracking/tracking-detail.blade.php --}}
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-4xl mx-auto">
    
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('admin.tracking.index') }}" 
               class="text-iqrain-yellow hover:text-white transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl text-white font-bold">Progres {{ $murid->user->username ?? 'Murid' }}</h1>
        </div>
        <p class="text-iqrain-yellow">Lihat perkembangan detail murid bimbingan Anda</p>
    </div>

    {{-- Main Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
        <div class="p-6 space-y-8">
            
            {{-- Poin Total --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Poin total</h3>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6 text-center">
                    <span class="text-4xl font-black text-gray-900 dark:text-white">
                        {{ number_format($totalPoin) }} poin
                    </span>
                </div>
            </div>

            <hr class="border-gray-200 dark:border-gray-700">

            {{-- Poin Game --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Poin game</h3>
                <div class="space-y-4">
                    {{-- Tracking Game --}}
                    <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-700 rounded-xl p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                                <i class="fas fa-pencil-alt text-xl text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <span class="font-medium text-gray-900 dark:text-white">Tracking game</span>
                        </div>
                        <span class="text-lg font-bold text-gray-900 dark:text-white">
                            {{ number_format($poinPerGame['tracking']) }} poin
                        </span>
                    </div>

                    {{-- Labirin Game --}}
                    <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-700 rounded-xl p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                                <i class="fas fa-map-signs text-xl text-green-600 dark:text-green-400"></i>
                            </div>
                            <span class="font-medium text-gray-900 dark:text-white">Labirin game</span>
                        </div>
                        <span class="text-lg font-bold text-gray-900 dark:text-white">
                            {{ number_format($poinPerGame['labirin']) }} poin
                        </span>
                    </div>

                    {{-- Memory Card --}}
                    <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-700 rounded-xl p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center">
                                <i class="fas fa-th text-xl text-purple-600 dark:text-purple-400"></i>
                            </div>
                            <span class="font-medium text-gray-900 dark:text-white">Memory card</span>
                        </div>
                        <span class="text-lg font-bold text-gray-900 dark:text-white">
                            {{ number_format($poinPerGame['memory']) }} poin
                        </span>
                    </div>

                    {{-- Drag & Drop --}}
                    <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-700 rounded-xl p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-pink-100 dark:bg-pink-900/30 rounded-full flex items-center justify-center">
                                <i class="fas fa-puzzle-piece text-xl text-pink-600 dark:text-pink-400"></i>
                            </div>
                            <span class="font-medium text-gray-900 dark:text-white">Drag & Drop</span>
                        </div>
                        <span class="text-lg font-bold text-gray-900 dark:text-white">
                            {{ number_format($poinPerGame['drag_drop']) }} poin
                        </span>
                    </div>
                </div>
            </div>

            <hr class="border-gray-200 dark:border-gray-700">

            {{-- Progress Modul --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Progres modul</h3>
                
                {{-- Percentage --}}
                <div class="text-center mb-4">
                    <span class="text-5xl font-black text-pink-500">{{ $progressModul }}%</span>
                </div>

                {{-- Progress Bar --}}
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4 overflow-hidden">
                    <div 
                        class="bg-gradient-to-r from-pink-400 to-pink-500 h-full rounded-full transition-all duration-500"
                        style="width: {{ $progressModul }}%"
                    ></div>
                </div>

                {{-- Stats --}}
                <div class="mt-4 text-center text-sm text-gray-600 dark:text-gray-400">
                    <span>{{ $murid->progressModuls->where('status', 'selesai')->count() }} dari {{ $murid->progressModuls->count() }} modul selesai</span>
                </div>
            </div>

        </div>
    </div>
</div>