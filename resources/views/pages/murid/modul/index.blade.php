@extends('layouts.murid')

@section('title', 'Modul Pembelajaran - Iqra ' . $tingkatan->level)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        
        <!-- Tab Toggle (Video / Materi Modul) -->
        <div class="flex justify-center items-center mb-8">
            <!-- Stars decoration -->
            <div class="text-5xl mr-4 animate-pulse">⭐</div>
            
            <div class="bg-white rounded-full p-1 shadow-lg inline-flex">
                <button onclick="switchTab('video')" 
                        id="tab-video" 
                        class="tab-button px-8 py-3 rounded-full font-bold text-lg transition-all duration-300">
                    Video
                </button>
                <button onclick="switchTab('materi')" 
                        id="tab-materi" 
                        class="tab-button px-8 py-3 rounded-full font-bold text-lg transition-all duration-300">
                    Materi Modul
                </button>
            </div>
            
            <div class="text-5xl ml-4 animate-pulse" style="animation-delay: 0.5s;">⭐</div>
        </div>
        
        <!-- Video Tab Content -->
        <div id="content-video" class="tab-content">
            <div class="bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-3xl p-8 shadow-2xl border-4 border-white">
                <div class="flex gap-6">
                    <!-- Video Player -->
                    <div class="flex-1 bg-pink-200 rounded-2xl overflow-hidden" style="aspect-ratio: 16/9;">
                        @if($videos && $videos->count() > 0)
                            <video id="video-player" class="w-full h-full" controls>
                                <source src="{{ asset('storage/' . $videos->first()->video_path) }}" type="video/mp4">
                                @if($videos->first()->subtitle_path)
                                    <track kind="subtitles" src="{{ asset('storage/' . $videos->first()->subtitle_path) }}" srclang="id" label="Indonesia" default>
                                @endif
                                Browser kamu tidak mendukung video player.
                            </video>
                        @else
                            <div class="w-full h-full flex items-center justify-center text-pink-400">
                                <div class="text-center">
                                    <div class="text-6xl mb-4">🎬</div>
                                    <p class="text-xl">Video akan segera hadir!</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Video List -->
                    <div class="w-48 space-y-3">
                        @forelse($videos as $index => $video)
                            <button onclick="loadVideo({{ $index }})" 
                                    class="video-item w-full bg-pink-400 hover:bg-pink-500 text-white rounded-2xl p-4 text-center font-semibold transition-all duration-300 hover:scale-105"
                                    data-video-src="{{ asset('storage/' . $video->video_path) }}"
                                    data-subtitle-src="{{ $video->subtitle_path ? asset('storage/' . $video->subtitle_path) : '' }}">
                                Video {{ $index + 1 }}
                            </button>
                        @empty
                            <div class="text-center text-gray-500 text-sm">
                                Belum ada video
                            </div>
                        @endforelse
                    </div>
                </div>
                
                <div class="mt-6 text-center">
                    <p class="text-blue-900 text-xl font-semibold italic">
                        {{ $tingkatan->nama_tingkatan }}: {{ $videos->first()->judul_video ?? 'Video Pembelajaran' }}
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Materi Tab Content -->
        <div id="content-materi" class="tab-content hidden">
            <div class="bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-3xl p-12 shadow-2xl border-4 border-white">
                <div class="flex items-center justify-center gap-8">
                    <!-- Previous Button -->
                    <button onclick="navigateMateri('prev')" 
                            id="btn-prev" 
                            class="bg-blue-400 hover:bg-blue-500 text-white rounded-full w-16 h-16 flex items-center justify-center text-3xl font-bold transition-all duration-300 hover:scale-110 disabled:opacity-30 disabled:cursor-not-allowed">
                        ⬅️
                    </button>
                    
                    <!-- Small Preview Left -->
                    <div id="preview-prev" class="w-24 h-32 bg-pink-200 rounded-xl flex items-center justify-center opacity-50">
                        <span class="text-3xl" id="preview-prev-text"></span>
                    </div>
                    
                    <!-- Main Card -->
                    <div class="flex-1 max-w-md">
                        <div class="bg-white rounded-3xl overflow-hidden shadow-xl">
                            <!-- Huruf Display -->
                            <div class="bg-gradient-to-br from-pink-200 to-pink-100 p-16 flex items-center justify-center" style="min-height: 300px;">
                                <div class="text-center">
                                    <div class="text-9xl mb-4" id="huruf-hijaiyah">
                                        @if($firstMateri && $firstMateri->moduls->first())
                                            {{ $firstMateri->moduls->first()->teks_latin ?? 'ا' }}
                                        @else
                                            ا
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Name Label -->
                            <div class="bg-gradient-to-r from-pink-400 to-pink-500 text-white text-center py-4">
                                <p class="text-3xl font-bold" id="nama-huruf">
                                    @if($firstMateri)
                                        {{ $firstMateri->judul_materi }}
                                    @else
                                        Alif
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Small Preview Right -->
                    <div id="preview-next" class="w-24 h-32 bg-pink-200 rounded-xl flex items-center justify-center opacity-50">
                        <span class="text-3xl" id="preview-next-text"></span>
                    </div>
                    
                    <!-- Next Button -->
                    <button onclick="navigateMateri('next')" 
                            id="btn-next" 
                            class="bg-blue-400 hover:bg-blue-500 text-white rounded-full w-16 h-16 flex items-center justify-center text-3xl font-bold transition-all duration-300 hover:scale-110 disabled:opacity-30 disabled:cursor-not-allowed">
                        ➡️
                    </button>
                </div>
                
                <!-- Progress Counter -->
                <div class="mt-8 text-center">
                    <div class="bg-pink-300 inline-block px-6 py-2 rounded-full">
                        <span class="text-2xl font-bold text-pink-700" id="progress-counter">
                            1/{{ $tingkatan->materiPembelajarans->count() ?? 28 }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

@push('scripts')
<script>
    const tingkatanId = {{ $tingkatan->tingkatan_id }};
    let currentMateriIndex = 0;
    let materis = [];
    
    // Load initial materis data
    async function loadMateris() {
        try {
            const response = await fetch(`/murid/modul/${tingkatanId}/materi/{{ $firstMateri->materi_id ?? 1 }}`);
            const data = await response.json();
            
            // Store data for navigation
            window.currentMateriData = data;
            updateMateriDisplay(data);
        } catch (error) {
            console.error('Error loading materis:', error);
        }
    }
    
    function updateMateriDisplay(data) {
        // Update main card
        document.getElementById('huruf-hijaiyah').textContent = data.materi.moduls[0]?.teks_latin || 'ا';
        document.getElementById('nama-huruf').textContent = data.materi.judul_materi;
        
        // Update progress
        document.getElementById('progress-counter').textContent = `${data.current}/${data.total}`;
        
        // Update previews
        if (data.prev) {
            document.getElementById('preview-prev-text').textContent = data.prev.moduls[0]?.teks_latin || '';
            document.getElementById('btn-prev').disabled = false;
        } else {
            document.getElementById('preview-prev-text').textContent = '';
            document.getElementById('btn-prev').disabled = true;
        }
        
        if (data.next) {
            document.getElementById('preview-next-text').textContent = data.next.moduls[0]?.teks_latin || '';
            document.getElementById('btn-next').disabled = false;
        } else {
            document.getElementById('preview-next-text').textContent = '';
            document.getElementById('btn-next').disabled = true;
        }
    }
    
    async function navigateMateri(direction) {
        const data = window.currentMateriData;
        let targetMateriId;
        
        if (direction === 'prev' && data.prev) {
            targetMateriId = data.prev.materi_id;
        } else if (direction === 'next' && data.next) {
            targetMateriId = data.next.materi_id;
        } else {
            return;
        }
        
        try {
            const response = await fetch(`/murid/modul/${tingkatanId}/materi/${targetMateriId}`);
            const newData = await response.json();
            window.currentMateriData = newData;
            updateMateriDisplay(newData);
            
            // Save progress
            if (newData.materi.moduls[0]) {
                saveProgress(newData.materi.moduls[0].modul_id);
            }
        } catch (error) {
            console.error('Error navigating materi:', error);
        }
    }
    
    async function saveProgress(modulId) {
        try {
            await fetchAPI('/murid/modul/progress', {
                method: 'POST',
                body: JSON.stringify({ modul_id: modulId })
            });
        } catch (error) {
            console.error('Error saving progress:', error);
        }
    }
    
    function switchTab(tab) {
        const videoTab = document.getElementById('tab-video');
        const materiTab = document.getElementById('tab-materi');
        const videoContent = document.getElementById('content-video');
        const materiContent = document.getElementById('content-materi');
        
        if (tab === 'video') {
            videoTab.classList.add('bg-pink-400', 'text-white');
            videoTab.classList.remove('text-pink-400');
            materiTab.classList.remove('bg-yellow-200', 'text-pink-700');
            materiTab.classList.add('text-pink-400');
            
            videoContent.classList.remove('hidden');
            materiContent.classList.add('hidden');
        } else {
            materiTab.classList.add('bg-yellow-200', 'text-pink-700');
            materiTab.classList.remove('text-pink-400');
            videoTab.classList.remove('bg-pink-400', 'text-white');
            videoTab.classList.add('text-pink-400');
            
            materiContent.classList.remove('hidden');
            videoContent.classList.add('hidden');
            
            // Load materis if not loaded yet
            if (!window.currentMateriData) {
                loadMateris();
            }
        }
    }
    
    function loadVideo(index) {
        const videoItems = document.querySelectorAll('.video-item');
        const videoPlayer = document.getElementById('video-player');
        
        if (videoItems[index]) {
            const videoSrc = videoItems[index].getAttribute('data-video-src');
            const subtitleSrc = videoItems[index].getAttribute('data-subtitle-src');
            
            videoPlayer.src = videoSrc;
            if (subtitleSrc) {
                videoPlayer.querySelector('track').src = subtitleSrc;
            }
            videoPlayer.load();
            videoPlayer.play();
        }
    }
    
    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        switchTab('video'); // Default to video tab
        sessionStorage.setItem('current_tingkatan_id', tingkatanId);
    });
</script>

<style>
    .tab-button {
        transition: all 0.3s ease;
    }
    
    #tab-video.bg-pink-400 {
        background: linear-gradient(135deg, #FF6B9D 0%, #E85A8B 100%);
    }
    
    #tab-materi.bg-yellow-200 {
        background: linear-gradient(135deg, #FDE68A 0%, #FCD34D 100%);
        font-weight: 700;
    }
</style>
@endpush

@endsection