@extends('layouts.murid')

@section('title', 'Modul Pembelajaran - Iqra ' . $tingkatan->level)

@section('content')
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

{{-- FIXED BACKGROUND LAYER (z-index: -1 di belakang semua) --}}
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

    {{-- WELCOMING SECTION (BARU!) --}}
    <div class="container mx-auto px-4 pt-8 pb-12">
        <div class="flex flex-col md:flex-row items-center justify-center gap-4 md:gap-12 max-w-6xl mx-auto">
            
            {{-- Maskot Mengaji (KIRI) --}}
            <div class="w-[180px] md:w-[280px] transform hover:rotate-3 transition-transform duration-500">
                <img src="{{ asset('images/maskot/mengaji.webp') }}" alt="Mengaji"
                    class="w-full h-auto drop-shadow-2xl">
            </div>

            {{-- Teks Header (KANAN) --}}
            <div class="text-center md:text-left">
                <h1 class="font-titan text-[40px] md:text-[55px] text-[#234275] leading-tight mb-2 text-shadow-header">
                    Selamat Belajar!
                </h1>
                <p class="text-[35px] md:text-[40px] text-[#234275] my-5 leading-none text-shadow-header">
                    <span class="font-cursive-iwk phrase-biru-tua">Ayo</span> 
                    <span class="font-cursive-iwk phrase-biru-tua">belajar</span> 
                    <span class="font-cursive-iwk phrase-biru-tua">Huruf</span> 
                    <span class="font-cursive-iwk phrase-biru-tua">Hijaiyah</span> 
                    <span class="font-cursive-iwk phrase-biru-tua">dengan</span><br>
                    <span class="font-cursive-iwk phrase-biru-tua">semangat</span> 
                    <span class="font-cursive-iwk phrase-biru-tua">dan</span> 
                    <span class="font-cursive-iwk phrase-biru-tua">penuh</span> 
                    <span class="font-cursive-iwk phrase-biru-tua">kegembiraan!</span>
                </p>
            </div>
        </div>
    </div>

    {{-- BLOK KREM (Konten Utama) --}}
    <div class="container mx-auto px-4 pb-24">
        <div class="w-full max-w-6xl mx-auto bg-[#FFD0DF] rounded-[3rem] shadow-2xl border-[6px] border-white/30 overflow-hidden flex flex-col min-h-[75vh]">
            
            {{-- HEADER --}}
            <div class="bg-white/50 backdrop-blur-sm p-6 border-b border-orange-100/50 text-center">
                <h1 class="text-3xl font-titan text-[#D75C82] inline-flex items-center gap-3">
                    Modul Belajar Huruf Hijaiyah - Iqra {{ $tingkatan->level }}
                </h1>
            </div>

            {{-- CONTENT AREA: TERINTEGRASI (VIDEO KIRI, MATERI KANAN) --}}
            <div class="flex-1 p-6 md:p-10 overflow-y-auto relative flex flex-col justify-between">
                
                {{-- Container Utama (Hapus justify-between lama karena tombol pindah ke dalam) --}}
                <div class="w-full max-w-5xl mx-auto">
                    
                    <div class="flex flex-col lg:flex-row gap-8 w-full items-center justify-center">
                        
                        {{-- KIRI: Main Player & Info (Lebar disesuaikan) --}}
                        <div class="w-full lg:w-7/12 xl:w-2/3 flex flex-col gap-4">
                            <div class="bg-black rounded-3xl overflow-hidden shadow-lg aspect-video border-4 border-white ring-1 ring-gray-200 relative">
                                <iframe id="main-video-player" class="w-full h-full" src="" title="Video Player" frameborder="0" allowfullscreen></iframe>
                            </div>
                            
                            <div class="bg-white p-4 rounded-xl shadow-sm border border-indigo-50">
                                <h2 id="main-video-title" class="text-3xl font-cursive-iwk font-semibold text-[#D75C82]">Video Pembelajaran</h2>
                                <p id="main-video-desc" class="text-[#D75C82] font-cursive-iwk text-xl mt-1 hidden">Materi Video</p>
                                <p class="text-[#D75C82] mt-1 hidden">
                                    <span class="text-2xl font-cursive-iwk phrase-pink">Pengenalan</span>
                                    <span class="text-2xl font-cursive-iwk phrase-pink">Huruf</span>
                                    <span class="text-2xl font-cursive-iwk phrase-pink">Hijaiyah</span>
                                </p>
                            </div>
                        </div>

                        {{-- KANAN: Navigasi Vertikal & Kartu --}}
                        <div class="w-full lg:w-5/12 xl:w-1/3 flex flex-col justify-center items-center gap-4">
                            
                            {{-- Tombol PREV (Panah Atas) --}}
                            <button onclick="prevMateri()" class="group relative z-20 p-2 transition-transform hover:scale-110 focus:outline-none hover:-translate-y-1">
                                <div class="absolute inset-0 bg-white rounded-full shadow-lg opacity-70 group-hover:opacity-100 transition-opacity"></div>
                                {{-- Rotate -90deg untuk panah ke atas --}}
                                <img src="{{ asset('images/icon/next.webp') }}" 
                                     class="w-12 h-12 relative z-10 transform -rotate-90 opacity-80 filter drop-shadow-sm" 
                                     alt="Previous">
                            </button>

                            {{-- Kartu Materi --}}
                            <div id="materi-card" 
                                 class="relative bg-white rounded-[2.5rem] shadow-[0_10px_30px_rgba(215,92,130,0.3)] border-[6px] border-[#D75C82] text-center transform transition-all duration-500 w-full aspect-square flex flex-col overflow-hidden">
                                
                                {{-- SECTION ATAS (70%): Area Gambar Hijaiyah --}}
                                <div class="relative w-full h-[70%] flex items-center justify-center bg-white">
                                    {{-- Pattern Background --}}
                                    <div class="absolute inset-0 opacity-10 pointer-events-none" 
                                         style="background-image: radial-gradient(#D75C82 1.5px, transparent 1.5px); background-size: 24px 24px;">
                                    </div>

                                    {{-- Image Container --}}
                                    <div class="relative h-4/5 w-4/5 flex items-center justify-center z-10 transition-transform duration-300 hover:scale-110">
                                        <img id="materi-image" src="" class="h-full w-auto object-contain drop-shadow-xl relative z-10" alt="Huruf">
                                        <div id="materi-fallback" class="hidden text-8xl font-arabic text-[#234275] font-bold">?</div>
                                    </div>
                                </div>

                                {{-- SECTION BAWAH (30%): Area Teks Latin --}}
                                <div class="relative w-full h-[30%] bg-[#D75C82] flex flex-col items-center justify-center px-2">
                                    <h3 id="materi-title" class="text-4xl lg:text-5xl font-bold text-white font-cursive-iwk phrase-putih tracking-wide mb-0 leading-tight" 
                                        style="text-shadow: 2px 2px 0px rgba(0,0,0,0.1);">
                                    </h3>
                                    <p id="materi-desc-short" class="text-white/90 font-cursive-iwk text-lg hidden mt-1"></p>
                                </div>

                                {{-- Loading Overlay --}}
                                <div id="loading-overlay" class="absolute inset-0 bg-white/90 backdrop-blur-sm z-50 flex items-center justify-center hidden transition-opacity duration-300">
                                    <div class="flex flex-col items-center">
                                        <div class="w-14 h-14 border-[6px] border-[#FFD0DF] border-t-[#D75C82] rounded-full animate-spin mb-3"></div>
                                        <span class="text-[#D75C82] font-bold font-titan text-lg tracking-widest">MEMUAT...</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Tombol NEXT (Panah Bawah) --}}
                            <button onclick="nextMateri()" class="group relative z-20 p-2 transition-transform hover:scale-110 focus:outline-none hover:translate-y-1">
                                <div class="absolute inset-0 bg-white rounded-full shadow-lg opacity-70 group-hover:opacity-100 transition-opacity"></div>
                                {{-- Rotate 90deg untuk panah ke bawah --}}
                                <img src="{{ asset('images/icon/next.webp') }}" 
                                     class="w-12 h-12 relative z-10 transform rotate-90 opacity-80 group-hover:opacity-100 filter drop-shadow-sm" 
                                     alt="Next">
                            </button>

                        </div>
                    </div>
                </div>

                {{-- FOOTER KONTEN UTAMA: PROGRESS BAR --}}
                <div class="w-full mt-8 pt-4 border-t border-gray-100">
                    <h3 class="text-lg font-titan text-[#D75C82] mb-2">
                        Capaian Belajar
                    </h3>
                    <div class="bg-gray-200 rounded-full h-4 relative overflow-hidden">
                        {{-- Progress Fill --}}
                        <div class="bg-[#FFBA2E] h-full rounded-full transition-all duration-500" style="width: {{ $progressPercentage }}%;"></div>
                        
                        {{-- Progress Text --}}
                        <span class="absolute inset-0 text-center text-xs font-titan text-white leading-4 tracking-wider" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.2);">
                            {{ $completedModulsCount }} / {{ $totalModuls }} Materi Selesai ({{ $progressPercentage }}%)
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>


<script>
    // === DATA STATIC MATERI (DI LOAD LANGSUNG DI SINI) ===
    // Nama file disesuaikan persis dengan yang ada di folder public/images/hijaiyah/
    const staticMateriData = [
        @foreach($hurufs as $index => $huruf)
        {
            modul_id: {{ $huruf->modul_id }},  
            judul: '{{ $huruf->judul_modul }}',
            desc: '{{ $huruf->materiPembelajaran->judul_materi ?? "Huruf Hijaiyah" }}',
            file: '{{ $huruf->gambar_path ?? "default.webp" }}',
            latin: '{{ $huruf->teks_latin ?? "" }}',
            konten: '{{ $huruf->konten_teks ?? "" }}',
            video: '{{ $videos->get($index)->video_path ?? "" }}'  // Pairing by index
        }{{ $loop->last ? '' : ',' }}
        @endforeach
    ];
    // console.log('staticMateriData:', staticMateriData);

    let completedModuls = new Set();
    const initialCompletedCount = {{ $completedModulsCount }};
    const totalModulsCount = {{ $totalModuls }};

    let currentIndex = 0;
    let isAnimating = false;

    // === 1. LOGIKA UTAMA DISPLAY ===
    function updateMateriDisplay() {
        if (staticMateriData.length === 0) {
            document.getElementById('materi-card').innerHTML = '<p class="text-gray-400">Belum ada materi statis ditemukan.</p>';
            return;
        }
        
        const materi = staticMateriData[currentIndex];
        const card = document.getElementById('materi-card');
        const imgEl = document.getElementById('materi-image');
        const fallbackEl = document.getElementById('materi-fallback');
        
        // Animasi
        card.classList.add('opacity-50', 'scale-95');

        setTimeout(() => {
            // Update Teks
            document.getElementById('materi-title').innerText = materi.judul;
            document.getElementById('materi-desc-short').innerText = materi.desc;
            // document.getElementById('materi-counter').innerText = `${currentIndex + 1} / ${staticMateriData.length}`;
            
            // Update Gambar
            const imagePath = `{{ asset('images/hijaiyah/') }}/${materi.file}`;
            imgEl.src = imagePath;
            fallbackEl.innerText = materi.judul;
            
            // Update Video Player (Integrated Logic)
            if (materi.video) {
                document.getElementById('main-video-player').src = materi.video;
                document.getElementById('main-video-title').innerText = `Video Pembelajaran: Huruf ${materi.judul}`;
                document.getElementById('main-video-title').innerHTML = `
                    <span class="phrase-pink font-cursive-iwk">Video</span> 
                    <span class="phrase-pink font-cursive-iwk">Pembelajaran</span> 
                    <span class="font-nanum">:</span>
                    <span class="phrase-pink font-cursive-iwk">Huruf</span> 
                    <span class="phrase-pink font-cursive-iwk">${materi.judul}</span>`;

                document.getElementById('main-video-desc').innerText = materi.desc;
            } else {
                document.getElementById('main-video-player').src = ''; // Clear video
                document.getElementById('main-video-title').innerText = 'Video tidak tersedia';
                document.getElementById('main-video-desc').innerText = 'Silakan hubungi mentor Anda.';
            }

            card.classList.remove('opacity-50', 'scale-95');
        }, 200);
    }

    // Handle image error for Materi Card
    function handleImageError(img) {
        img.style.display = 'none';
        document.getElementById('materi-fallback').style.display = 'block';
    }

    function preloadImage(url) {
        return new Promise((resolve, reject) => {
            const img = new Image();
            img.src = url;
            img.onload = resolve;
            img.onerror = resolve; // Tetap resolve agar tidak stuck
        });
    }

    async function nextMateri() {
        if (isAnimating) return;
        isAnimating = true;
        showLoading(true);

        // Hitung index berikutnya
        const nextIndex = (currentIndex + 1) % staticMateriData.length;
        const nextData = staticMateriData[nextIndex];

        // Preload gambar
        const imagePath = `{{ asset('images/hijaiyah/') }}/${nextData.file}`;
        
        // Tunggu gambar load atau timeout 3 detik
        const timeout = new Promise(resolve => setTimeout(resolve, 3000));
        await Promise.race([preloadImage(imagePath), timeout]);

        // Update Index & Display
        currentIndex = nextIndex;
        updateMateriDisplay();

        // Simpan Progress
        if (nextData && nextData.modul_id) {
            saveProgressAsync(nextData.modul_id);
        }

        showLoading(false);
        isAnimating = false;
    }

    async function prevMateri() {
        if (isAnimating) return;
        isAnimating = true;
        showLoading(true);

        // Hitung index sebelumnya
        const prevIndex = (currentIndex - 1 + staticMateriData.length) % staticMateriData.length;
        const prevData = staticMateriData[prevIndex];

        // Preload gambar
        const imagePath = `{{ asset('images/hijaiyah/') }}/${prevData.file}`;
        
        // Tunggu gambar load atau timeout 3 detik
        const timeout = new Promise(resolve => setTimeout(resolve, 3000));
        await Promise.race([preloadImage(imagePath), timeout]);

        // Update Index & Display
        currentIndex = prevIndex;
        updateMateriDisplay();

        // Simpan Progress
        if (prevData && prevData.modul_id) {
            saveProgressAsync(prevData.modul_id);
        }

        showLoading(false);
        isAnimating = false;
    }

    function showLoading(show) {
        const overlay = document.getElementById('loading-overlay');
        const nextBtn = document.querySelector('button[onclick="nextMateri()"]');
        const prevBtn = document.querySelector('button[onclick="prevMateri()"]');
        
        if (show) {
            overlay.classList.remove('hidden');
            if(nextBtn) {
                nextBtn.classList.add('opacity-50', 'cursor-not-allowed', 'pointer-events-none');
                nextBtn.disabled = true;
            }
            if(prevBtn) {
                prevBtn.classList.add('opacity-50', 'cursor-not-allowed', 'pointer-events-none');
                prevBtn.disabled = true;
            }
        } else {
            overlay.classList.add('hidden');
            if(nextBtn) {
                nextBtn.classList.remove('opacity-50', 'cursor-not-allowed', 'pointer-events-none');
                nextBtn.disabled = false;
            }
            if(prevBtn) {
                prevBtn.classList.remove('opacity-50', 'cursor-not-allowed', 'pointer-events-none');
                prevBtn.disabled = false;
            }
        }
    }

    // === 2. LOGIKA VIDEO (Hanya untuk list di kanan, tidak terpakai lagi untuk main player) ===
    function changeVideo(url, title, desc) {
        // Ini adalah logic jika mengklik list video di sidebar (yang sudah dihapus layoutnya, 
        // tapi logikanya bisa dipakai jika nanti ditambahkan lagi)
        // Di layout baru ini, logic ini hanya perlu mengupdate Main Player di kiri.
        
        document.getElementById('main-video-player').src = url;
        document.getElementById('main-video-title').innerText = title;
        document.getElementById('main-video-desc').innerText = desc;
        if(window.innerWidth < 1024) {
            document.getElementById('main-video-player').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    async function saveProgressAsync(modulId) {
        const realModulId = parseInt(modulId);
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        if (isNaN(realModulId) || realModulId < 1) {
            return;
        }

        // ✅ OPTIMISTIC UI: Update state immediately
        const wasAlreadyCompleted = completedModuls.has(realModulId);
        if (!wasAlreadyCompleted) {
            completedModuls.add(realModulId);
            updateProgressBar(); // Update UI immediately
        }

        try {   
            const response = await fetch('{{ route("murid.modul.progress") }}', { 
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ 
                    modul_id: realModulId,
                    status: 'selesai'
                })
            });

            const result = await response.json();
            
            if (result.success) {
                // State is already updated, so no need to do anything else
            } else {
                // ❌ REVERT if server error
                if (!wasAlreadyCompleted) {
                    completedModuls.delete(realModulId);
                    updateProgressBar();
                }
            }

        } catch (error) {
            // ❌ REVERT if network error
            if (!wasAlreadyCompleted) {
                completedModuls.delete(realModulId);
                updateProgressBar();
            }
        }
    }

    function updateProgressBar() {
        // ✅ Hitung progress baru
        const completedCount = completedModuls.size;
        const totalCount = totalModulsCount;
        const newPercentage = totalCount > 0 ? Math.round((completedCount / totalCount) * 100) : 0;
        
        // ✅ Cari elemen progress bar (sesuaikan selector dengan HTML kamu)
        const progressBar = document.querySelector('.bg-\\[\\#FFBA2E\\]'); 
        const progressText = document.querySelector('.absolute.inset-0.text-center');
        
        if (progressBar && progressText) {
            // ✅ Update width progress bar dengan animasi smooth
            progressBar.style.width = `${newPercentage}%`;
            progressBar.style.transition = 'width 0.5s ease-in-out';
            
            // ✅ Update text progress
            progressText.textContent = `${completedCount} / ${totalCount} Materi Selesai (${newPercentage}%)`;
            
            // console.log(`🎯 Progress bar updated: ${completedCount}/${totalCount} (${newPercentage}%)`);
        } else {
            console.warn('⚠️ Progress bar elements not found!');
        }
    }

    async function loadCompletedModuls() {
        try {
            // ✅ Endpoint API untuk ambil list modul yang sudah selesai
            const response = await fetch('{{ route("murid.modul.completed") }}');
            const result = await response.json();
            
            if (result.success && Array.isArray(result.completed_moduls)) {
                // ✅ Masukkan ke Set
                result.completed_moduls.forEach(modulId => {
                    completedModuls.add(parseInt(modulId));
                });
                
                // console.log('✅ Loaded completed moduls:', completedModuls);
            }
        } catch (error) {
            // console.error('❌ Failed to load completed moduls:', error);
        }
    }



    // === INIT ===
    document.addEventListener('DOMContentLoaded', () => {
        // Inisialisasi tampilan pertama
        updateMateriDisplay(); 

        loadCompletedModuls();
        
        // Keyboard Navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowRight') nextMateri();
            if (e.key === 'ArrowLeft') prevMateri();
        });
    });
</script>

<style>
    .font-comic { font-family: 'Comic Sans MS', 'Comic Sans', cursive; }
    .font-arabic { font-family: 'Amiri', serif; }
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin-slow { animation: spin-slow 10s linear infinite; }
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
</style>
@endsection