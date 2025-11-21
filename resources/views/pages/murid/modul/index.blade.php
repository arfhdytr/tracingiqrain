@extends('layouts.murid')

@section('title', 'Modul Pembelajaran - Iqra ' . $tingkatan->level)

@section('content')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mooli&family=Titan+One&display=swap" rel="stylesheet">
    <style>
        body {
            background-image: 
                url('{{ asset('images/pattern/pattern1-darker.webp') }}'),
                linear-gradient(135deg, #56b1f3, #d3f2ff);

            background-size: 
                500px,       /* pattern */
                cover;       /* gradient */

            background-repeat: 
                repeat,      /* pattern */
                no-repeat;   /* gradient */

            background-attachment: fixed;
            background-position: center;
            background-blend-mode: normal, overlay;
        }
    </style>

{{-- OUTER BACKGROUND: BIRU --}}
<div class="pt-15 sm:pt-25 pb-15 px-4 flex items-start justify-center relative overflow-hidden">
    
    <!-- {{-- Pattern Background --}}
    <img src="{{ asset('images/pattern/pattern1.webp') }}" class="absolute top-0 left-0 w-full h-full object-cover opacity-10 pointer-events-none mix-blend-overlay" alt="pattern"> -->

    {{-- KONTEN UTAMA: BLOK KREM BESAR --}}
    <div class="w-full max-w-6xl bg-[#FDF6E9] rounded-[3rem] shadow-2xl border-[6px] border-white/30 relative z-10 overflow-hidden flex flex-col min-h-[75vh] mb-0">
        
        {{-- HEADER --}}
        <div class="bg-white/50 backdrop-blur-sm p-6 border-b border-orange-100/50 text-center">
            <h1 class="text-3xl font-titan text-indigo-900 inline-flex items-center gap-3">
                <!-- <img src="{{ asset('images/icon/bintang.webp') }}" class="w-8 h-8 animate-spin-slow" alt="star"> -->
                Modul Pembelajaran Iqra Jilid {{ $tingkatan->level }}
                <!-- <img src="{{ asset('images/icon/bintang.webp') }}" class="w-8 h-8 animate-spin-slow" alt="star"> -->
            </h1>
        </div>

        {{-- CONTENT AREA: TERINTEGRASI (VIDEO KIRI, MATERI KANAN) --}}
        <div class="flex-1 p-6 md:p-10 overflow-y-auto relative flex flex-col justify-between">
            
            {{-- Navigation and Integrated View --}}
            <div class="flex items-center justify-between w-full">
                
                {{-- Tombol PREV --}}
                <button onclick="prevMateri()" class="group relative z-20 p-4 transition-transform hover:scale-110 focus:outline-none">
                    <div class="absolute inset-0 bg-white rounded-full shadow-lg opacity-70 group-hover:opacity-100 transition-opacity"></div>
                    <img src="{{ asset('images/icon/next.webp') }}" 
                         class="w-12 h-12 relative z-10 transform rotate-180 opacity-80 filter drop-shadow-sm" 
                         alt="Previous">
                </button>

                {{-- KONTEN UTAMA SPLIT (VIDEO KIRI, HURUF KANAN) --}}
                <div class="flex flex-col lg:flex-row gap-6 w-full max-w-5xl mx-auto">
                    
                    {{-- KIRI: Main Player & Info (Sesuai Video Prototype) --}}
                    <div class="w-full lg:w-2/3 flex flex-col gap-4">
                        <div class="bg-black rounded-3xl overflow-hidden shadow-lg aspect-video border-4 border-white ring-1 ring-gray-200 relative">
                            {{-- Video Player (Placeholder) --}}
                            <iframe id="main-video-player" class="w-full h-full" src="" title="Video Player" frameborder="0" allowfullscreen></iframe>
                        </div>
                        
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-indigo-50">
                            <h2 id="main-video-title" class="text-xl font-titan text-gray-800">Video Pembelajaran</h2>
                            <p id="main-video-desc" class="text-white-600 font-cursive-iwk text-sm mt-1">Materi Video</p>
                        </div>
                    </div>

                    {{-- KANAN: Kartu Materi Aktif (Sesuai Materi Prototype) --}}
                    <div class="w-full lg:w-1/3 flex justify-center items-center">
                        <div id="materi-card" class="relative bg-white rounded-3xl shadow-2xl border-4 border-white p-6 text-center transform transition-all duration-500 w-full aspect-square flex flex-col justify-center items-center">
                            
                            {{-- Image Container --}}
                            <div class="relative h-32 w-32 flex items-center justify-center mb-4">
                                <img id="materi-image" src="" class="h-full w-auto object-contain drop-shadow-lg relative z-10" alt="Huruf">
                                <div id="materi-fallback" class="hidden text-6xl font-arabic text-indigo-600 font-bold">?</div>
                            </div>

                            {{-- Text Info --}}
                            <h3 id="materi-title" class="text-3xl font-bold text-indigo-900 font-cursive-iwk tracking-wide mb-1">...</h3>
                            <p id="materi-desc-short" class="text-white-600 font-cursive-iwk text-sm"></p>
                            
                            {{-- Progress Badge --}}
                            <div class="absolute top-3 right-3 bg-white-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                <!-- Huruf <span id="materi-counter">1/1</span> -->
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol NEXT --}}
                <button onclick="nextMateri()" class="group relative z-20 p-4 transition-transform hover:scale-110 focus:outline-none">
                    <div class="absolute inset-0 bg-white rounded-full shadow-lg opacity-70 group-hover:opacity-100 transition-opacity"></div>
                    <img src="{{ asset('images/icon/next.webp') }}" 
                         class="w-12 h-12 relative z-10 opacity-80 group-hover:opacity-100 filter drop-shadow-sm" 
                         alt="Next">
                </button>
            </div>

            {{-- FOOTER KONTEN UTAMA: PROGRESS BAR --}}
            <div class="w-full mt-8 pt-4 border-t border-gray-100">
                <h3 class="text-lg font-titan text-gray-800 mb-2">
                    Progres Tingkatan {{ $tingkatan->level }}
                </h3>
                <div class="bg-gray-200 rounded-full h-4 relative overflow-hidden">
                    {{-- Progress Fill --}}
                    <div class="bg-indigo-500 h-full rounded-full transition-all duration-500" style="width: {{ $progressPercentage }}%;"></div>
                    
                    {{-- Progress Text --}}
                    <span class="absolute inset-0 text-center text-xs font-titan text-white leading-4 tracking-wider" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.2);">
                        {{ $completedModulsCount }} / {{ $totalModuls }} Materi Selesai ({{ $progressPercentage }}%)
                    </span>
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
    console.log('staticMateriData:', staticMateriData);

    let completedModuls = new Set();
    const initialCompletedCount = {{ $completedModulsCount }};
    const totalModulsCount = {{ $totalModuls }};

    let currentIndex = 0;

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

    function nextMateri() {
        // ✅ Ambil data huruf saat ini
        const currentHuruf = staticMateriData[currentIndex];
        
        // ✅ Debug: Log ke console
        console.log('Current huruf:', currentHuruf);
        console.log('modul_id:', currentHuruf?.modul_id);
        
        // ✅ Simpan progress jika modul_id ada
        if (currentHuruf && currentHuruf.modul_id) {
            saveProgressAsync(currentHuruf.modul_id);
        } else {
            console.error('❌ modul_id tidak ditemukan!', currentHuruf);
        }
        
        currentIndex = (currentIndex + 1) % staticMateriData.length;
        updateMateriDisplay();
    }

    function prevMateri() {
        // ✅ HARUS ADA: Simpan progress modul saat ini
        const currentHuruf = staticMateriData[currentIndex];
        if (currentHuruf && currentHuruf.modul_id) {
            saveProgressAsync(currentHuruf.modul_id);  // ← INI HARUS ADA!
        }
        
        currentIndex = (currentIndex - 1 + staticMateriData.length) % staticMateriData.length;
        updateMateriDisplay();
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
            console.error('❌ Invalid modulId:', modulId);
            return;
        }

        try {   
            console.log('📤 Sending progress for modul_id:', realModulId);
            
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
                console.log(`✅ Progress saved for Modul ID: ${realModulId}`);
                
                // ✅ Tambahkan ke Set completed moduls
                completedModuls.add(realModulId);
                
                // ✅ Update progress bar TANPA reload
                updateProgressBar();
            } else {
                console.error('❌ Server returned error:', result);
            }

        } catch (error) {
            console.error('❌ Failed to save progress:', error);
        }
    }

    function updateProgressBar() {
        // ✅ Hitung progress baru
        const completedCount = completedModuls.size;
        const totalCount = totalModulsCount;
        const newPercentage = totalCount > 0 ? Math.round((completedCount / totalCount) * 100) : 0;
        
        // ✅ Cari elemen progress bar (sesuaikan selector dengan HTML kamu)
        const progressBar = document.querySelector('.bg-indigo-500');
        const progressText = document.querySelector('.absolute.inset-0.text-center');
        
        if (progressBar && progressText) {
            // ✅ Update width progress bar dengan animasi smooth
            progressBar.style.width = `${newPercentage}%`;
            progressBar.style.transition = 'width 0.5s ease-in-out';
            
            // ✅ Update text progress
            progressText.textContent = `${completedCount} / ${totalCount} Materi Selesai (${newPercentage}%)`;
            
            console.log(`🎯 Progress bar updated: ${completedCount}/${totalCount} (${newPercentage}%)`);
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
                
                console.log('✅ Loaded completed moduls:', completedModuls);
            }
        } catch (error) {
            console.error('❌ Failed to load completed moduls:', error);
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