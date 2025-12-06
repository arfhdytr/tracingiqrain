@extends('layouts.murid')

@section('title', 'Pilih Mentor')

{{-- CSS --}}
@push('styles')
    <style>
        /* Import Font */
        @import url('https://fonts.googleapis.com/css2?family=Titan+One&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Nanum+Myeongjo&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&display=swap');

        @font-face {
            font-family: 'Tegak Bersambung_IWK';
            src: url("{{ asset('fonts/TegakBersambung_IWK.ttf') }}") format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        /* Utility Classes */
        .font-fredoka { 
            font-family: 'Fredoka', sans-serif; 
        }

        .font-cursive-iwk {
            font-family: 'Tegak Bersambung_IWK', cursive !important;
        }

        .font-titan {
            font-family: 'Titan One', cursive !important;
        }

        .font-nanum {
            font-family: 'Nanum Myeongjo', serif !important;
        }

        .text-shadow-header {
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.25);
        }

        .text-shadow-popup-name {
            text-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);
        }

        .text-shadow-popup-text {
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.25);
        }

        .hover-float:hover {
            transform: translateY(-5px) scale(1.02);
        }

        /* Styles Pop Up */
        .popup-stat-box {
            width: auto;
            min-width: 180px;
            height: auto;
            padding: 15px 25px;

            flex-shrink: 0;
            border-radius: 23px;
            background: #56B1F3;
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .popup-btn {
            width: auto;
            height: auto;
            padding: 10px 40px;

            flex-shrink: 0;
            border-radius: 9px;
            background: #F387A9;
            box-shadow: 0 4px 4px 0 rgba(0, 0, 0, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFF;
            font-family: "Tegak Bersambung_IWK", cursive;
            font-size: 33px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.25);
            transition: transform 0.2s;
            border: none;
        }

        .popup-btn:hover {
            transform: scale(1.05);
        }

        .popup-btn:disabled {
            background: #cccccc;
            cursor: not-allowed;
        }
    </style>
@endpush

@section('content')

    {{--
    PERBAIKAN BACKGROUND:
    Dipisah menjadi layer 'fixed' agar selalu full layar (atas sampai bawah)
    dan tidak terpengaruh scroll atau margin konten.
    --}}
    <div class="fixed inset-0 w-full h-full z-0 pointer-events-none"
        style="background: var(--bg-blue, linear-gradient(180deg, #56B1F3 0%, #D3F2FF 100%));">

        {{-- Pattern Landscape (Cover) --}}
        <div class="absolute inset-0 w-full h-full" style="background-image: url('{{ asset('images/games/game-pattern.webp') }}'); 
                        background-size: 500px;
                        background-repeat: repeat;
                        background-position: center; 
                        opacity: 0.3;">
        </div>
    </div>

    {{-- CONTAINER KONTEN UTAMA --}}
    {{-- Background dihapus dari sini karena sudah dipindah ke div fixed di atas --}}
    <div class="min-h-screen w-full relative z-10 flex flex-col overflow-x-hidden -mt-[120px] pt-[140px]">


        <div class="relative z-10 flex-grow flex flex-col">

            {{-- HEADER SECTION --}}
            <div class="container mx-auto px-4 pt-8 pb-12">
                <div class="flex flex-col-reverse md:flex-row items-center justify-center gap-4 md:gap-12 max-w-6xl mx-auto">

                    {{-- Teks Header (KIRI) --}}
                    <div class="text-center md:text-left">
                        <h1 class="font-titan text-[40px] md:text-[55px] text-[#234275] leading-tight mb-2 text-shadow-header">
                            Kenalan sama Para Mentor!
                        </h1>
                        <p class="text-[35px] md:text-[40px] text-[#234275] my-5 leading-none text-shadow-header">
                            <span class="font-cursive-iwk phrase-biru-tua">Belajar</span>
                            <span class="font-cursive-iwk phrase-biru-tua">lebih</span>
                            <span class="font-cursive-iwk phrase-biru-tua">seru</span>
                            <span class="font-cursive-iwk phrase-biru-tua">dengan</span>
                            <span class="font-cursive-iwk phrase-biru-tua">bimbingan</span>
                            <span class="font-cursive-iwk phrase-biru-tua">para</span>
                            <span class="font-cursive-iwk phrase-biru-tua">mentor!</span>
                        </p>
                    </div>

                    {{-- Maskot Gajah (KANAN) --}}
                    <div class="w-[180px] md:w-[280px] transform hover:rotate-3 transition-transform duration-500">
                        <img src="{{ asset('images/maskot/qira-happy.webp') }}" alt="Qira Happy"
                            class="w-full h-auto drop-shadow-2xl">
                    </div>
                </div>
            </div>

            {{-- ALERT PENDING --}}
            @if ($pendingRequest)
                <div class="container mx-auto px-4 mb-8">
                    <div
                        class="max-w-4xl mx-auto bg-[#FFF9C4] rounded-[35px] p-6 shadow-lg flex flex-col md:flex-row items-center justify-center gap-6 animate-pulse text-center md:text-left">
                        <div class="text-5xl">⏳</div>
                        <div>
                            <p class="font-titan text-2xl text-[#680D2A] mb-1">Permintaan sedang diproses</p>
                            <p class="font-cursive-iwk text-2xl text-[#680D2A]">
                                Kamu sudah meminta <span
                                    class="font-cursive-iwk text-[#680D2A]">{{ $pendingRequest->mentor->nama_lengkap }}</span>.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- MENTOR SECTION --}}
            <div class="container mx-auto px-40 relative z-10 mb-24">
                <div class="w-full bg-[#F387A9] rounded-[50px] py-16 px-4 shadow-xl">
                    <div class="max-w-7xl mx-auto">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-20 gap-x-10 justify-items-center">

                            @forelse($mentors as $index => $mentor)
                                @php
                                    $isMirror = $index % 2 !== 0;
                                    $vectorStyle = $isMirror ? 'transform: scaleX(-1);' : '';
                                    $checkmarkClass = $isMirror ? 'right-4 rotate-12' : 'left-4 -rotate-12';

                                    // Hitung pengalaman
                                    $joinDate = \Carbon\Carbon::parse($mentor->created_at);
                                    $experience = $joinDate->diffInYears(now());
                                    $experienceDisplay = $experience < 1 ? 1 : $experience;
                                @endphp

                                {{-- ITEM MENTOR --}}
                                <div class="relative flex flex-col items-center cursor-pointer group hover-float w-[300px]"
                                    onclick="showMentorDetail(
                                             {{ $mentor->mentor_id }}, 
                                             '{{ $mentor->nama_lengkap }}', 
                                             '{{ $mentor->user->username }}', 
                                             {{ $mentor->murids->count() }}, 
                                             {{ $experienceDisplay }},
                                             '{{ $mentor->user->avatar_url }}'
                                            )">

                                    <div class="relative w-[300px] h-[300px] flex items-center justify-center mb-2">
                                        <img src="{{ asset('images/mentor/Mentor.webp') }}" alt="Frame"
                                            class="absolute w-full h-full object-contain z-0" style="{{ $vectorStyle }}">

                                        <img src="{{ asset('images/mentor/Centang.webp') }}" alt="Verified"
                                            class="absolute top-0 w-20 h-20 z-20 drop-shadow-md {{ $checkmarkClass }}">

                                        <div
                                            class="relative z-10 w-44 h-44 rounded-full overflow-hidden border-[5px] border-white shadow-inner bg-white">
                                            <img src="{{ $mentor->user->avatar_url }}" alt="{{ $mentor->nama_lengkap }}"
                                                class="w-full h-full object-cover">
                                        </div>
                                    </div>

                                    <div class="text-center z-10 -mt-2">
                                        <h3 class="font-fredoka font-bold text-3xl text-white leading-none mb-4 text-shadow-white">
                                            Kak {{ $mentor->user->username }}
                                        </h3>
                                        <p class="font-cursive-iwk text-[27px] text-white leading-tight text-shadow-white">
                                            Kelas {{ $mentor->nama_lengkap }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full text-center py-10">
                                    <p class="font-cursive-iwk text-4xl text-white/80">Belum ada mentor yang tersedia saat
                                        ini.</p>
                                </div>
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ======================= --}}
    {{-- POPUP MODAL DETAIL --}}
    {{-- ======================= --}}
    <div id="mentorModal"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-sm transition-opacity duration-300">

        {{-- Container Modal --}}
        <div class="relative w-[95%] max-w-[1000px] flex items-center justify-center transition-all duration-300 transform scale-95 opacity-0"
            id="modalContent">

            {{-- Background Popup --}}
            <img src="{{ asset('images/mentor/Popup.webp') }}" alt="Popup BG"
                class="w-full h-auto object-contain drop-shadow-2xl relative z-0">

            {{-- Konten Overlay --}}
            <div class="absolute inset-0 z-10 flex flex-col p-6 md:p-12">

                {{-- WRAPPER UTAMA: Split 30% Kiri - 70% Kanan --}}
                <div class="flex flex-col md:flex-row w-full flex-grow items-center justify-center">

                    {{-- KOLOM KIRI (30%) - Hanya Foto --}}
                    <div class="w-full md:w-[30%] flex items-center justify-center h-full mb-4 md:mb-0">
                        {{-- Foto Mentor (Centered di area 30%) --}}
                        <div
                            class="relative z-10 w-32 h-32 md:w-50 md:h-50 rounded-full border-[5px] border-white shadow-lg bg-white overflow-hidden translate-x-15 translate-y-15">
                            <img id="modal-mentor-img" src="" alt="Avatar" class="w-full h-full object-cover">
                        </div>
                    </div>

                    {{-- KOLOM KANAN (70%) - Informasi & Statistik --}}
                    <div class="w-full md:w-[70%] flex flex-col items-center justify-center pl-0 md:pl-6">

                        {{-- Nama Mentor --}}
                        <h2 id="modal-mentor-name"
                            class="font-titan text-[32px] md:text-[45px] text-[#AC3F61] text-center leading-none mb-1 text-shadow-popup-name">
                            Kak Nama
                        </h2>

                        {{-- Kelas --}}
                        <p id="modal-mentor-class"
                            class="font-cursive-iwk text-[28px] md:text-[40px] text-[#AC3F61] text-center leading-tight mb-4 md:mb-6 text-shadow-popup-text">
                            Kelas XXXXX
                        </p>

                        {{-- Statistik (Murid & Tahun) --}}
                        <div class="flex flex-wrap justify-center gap-3 md:gap-6 mb-4 md:mb-6 w-full">
                            {{-- Kotak Murid --}}
                            <div class="popup-stat-box scale-90 md:scale-100">
                                <svg width="35" height="35" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z"
                                        fill="#FFFCFC" />
                                    <path
                                        d="M12.0002 14.5C6.99016 14.5 2.91016 17.86 2.91016 22C2.91016 22.28 3.13016 22.5 3.41016 22.5H20.5902C20.8702 22.5 21.0902 22.28 21.0902 22C21.0902 17.86 17.0102 14.5 12.0002 14.5Z"
                                        fill="#FFFCFC" />
                                </svg>
                                <div class="flex flex-col items-start justify-center leading-none pt-1">
                                    <span id="modal-mentor-students"
                                        class="font-nanum text-[24px] md:text-[28px] text-[#FFFCFC] text-shadow-popup-text block">0</span>
                                    <span
                                        class="font-cursive-iwk text-[20px] md:text-[24px] text-[#FFFCFC] block -mt-1">murid</span>
                                </div>
                            </div>

                            {{-- Kotak Tahun --}}
                            <div class="popup-stat-box scale-90 md:scale-100">
                                <svg width="30" height="30" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12" r="10" stroke="#FFFCFC" stroke-width="2" fill="none" />
                                    <path d="M12 6V12L16 14" stroke="#FFFCFC" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                <div class="flex flex-col items-start justify-center leading-none pt-1">
                                    <span id="modal-mentor-experience"
                                        class="font-nanum text-[24px] md:text-[28px] text-[#FFFCFC] text-shadow-popup-text block">0</span>
                                    <span
                                        class="font-cursive-iwk text-[20px] md:text-[24px] text-[#FFFCFC] block -mt-1">tahun</span>
                                </div>
                            </div>
                        </div>

                        {{-- Kalimat Ajakan --}}
                        <p
                            class="font-cursive-iwk text-[24px] md:text-[35px] text-[#AC3F61] text-center leading-tight text-shadow-popup-text px-2 w-full">
                            Ajukan <span id="modal-mentor-name-2" class="font-cursive-iwk">...</span> menjadi mentormu
                        </p>
                    </div>
                </div>

                {{-- SECTION TOMBOL (Centered di Bawah) --}}
                <div class="w-full flex justify-center gap-4 md:gap-8 mt-4 md:mt-2">
                    <button onclick="closeMentorModal()" class="popup-btn">
                        Kembali
                    </button>
                    <button id="btn-request-mentor" onclick="requestMentor()" class="popup-btn">
                        Ajukan
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- CUSTOM ALERT MODAL --}}
    <div id="customAlertModal"
        class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/60 backdrop-blur-sm transition-opacity duration-300">
        <div class="relative bg-white rounded-3xl p-8 max-w-sm w-full mx-4 shadow-2xl transform scale-95 opacity-0 transition-all duration-300 border-4 border-pink-300 text-center"
            id="customAlertContent">
            <div class="mb-4 animate-bounce">
                <img id="customAlertIcon" src="{{ asset('images/icon/checklist.webp') }}" alt="Icon"
                    class="w-24 h-auto mx-auto">
            </div>
            <h2 id="customAlertTitle" class="font-titan text-3xl text-pink-500 mb-2">
                Berhasil!
            </h2>
            <p id="customAlertMessage" class="font-cursive-iwk text-gray-600 mb-6 text-xl">
                Pesan disini...
            </p>
            <button onclick="closeCustomAlert()"
                class="w-full py-3 bg-gradient-to-r from-pink-400 to-pink-500 text-white rounded-xl font-bold text-xl shadow-lg hover:scale-105 transition-transform font-cursive-iwk">
                Oke
            </button>
        </div>
    </div>

    @push('scripts')
        <script>
            let selectedMentorId = null;
            const hasPendingRequest = {{ $pendingRequest ? 'true' : 'false' }};
            const currentMentorId = {{ auth()->user()->murid->mentor_id ?? 'null' }};

            // --- Custom Alert Functions ---
            function showCustomAlert(title, message, isSuccess = true, callback = null) {
                const modal = document.getElementById('customAlertModal');
                const content = document.getElementById('customAlertContent');
                const titleEl = document.getElementById('customAlertTitle');
                const msgEl = document.getElementById('customAlertMessage');
                const iconEl = document.getElementById('customAlertIcon');

                titleEl.textContent = title;
                msgEl.textContent = message;

                if (isSuccess) {
                    iconEl.src = "{{ asset('images/icon/checklist.webp') }}";
                    titleEl.className = "font-titan text-3xl text-pink-500 mb-2";
                } else {
                    iconEl.src = "{{ asset('images/icon/tanda-tanya.webp') }}"; // Icon tanda tanya untuk error/info
                    titleEl.className = "font-titan text-3xl text-red-500 mb-2";
                }

                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => {
                    content.classList.remove('scale-95', 'opacity-0');
                    content.classList.add('scale-100', 'opacity-100');
                }, 10);

                window.currentAlertCallback = callback;
            }

            function closeCustomAlert() {
                const modal = document.getElementById('customAlertModal');
                const content = document.getElementById('customAlertContent');

                content.classList.remove('scale-100', 'opacity-100');
                content.classList.add('scale-95', 'opacity-0');

                setTimeout(() => {
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                    if (window.currentAlertCallback) {
                        window.currentAlertCallback();
                        window.currentAlertCallback = null;
                    }
                }, 300);
            }
            // -----------------------------

            function showMentorDetail(mentorId, namaLengkap, username, studentCount, experience, avatarUrl) {
                selectedMentorId = mentorId;

                document.getElementById('modal-mentor-name').textContent = 'Kak ' + username;
                document.getElementById('modal-mentor-name-2').textContent = 'Kak ' + username;
                document.getElementById('modal-mentor-class').textContent = 'Kelas: ' + namaLengkap;
                document.getElementById('modal-mentor-students').textContent = studentCount;
                document.getElementById('modal-mentor-experience').textContent = experience;
                document.getElementById('modal-mentor-img').src = avatarUrl;

                const btnRequest = document.getElementById('btn-request-mentor');
                btnRequest.disabled = false;
                btnRequest.textContent = 'Ajukan';

                if (hasPendingRequest) {
                    btnRequest.disabled = true;
                    btnRequest.textContent = 'Menunggu';
                } else if (currentMentorId) {
                    btnRequest.disabled = true;
                    btnRequest.textContent = 'Sudah Punya';
                }

                const modal = document.getElementById('mentorModal');
                const content = document.getElementById('modalContent');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => {
                    content.classList.remove('scale-95', 'opacity-0');
                    content.classList.add('scale-100', 'opacity-100');
                }, 10);
            }

            function closeMentorModal() {
                const modal = document.getElementById('mentorModal');
                const content = document.getElementById('modalContent');
                content.classList.remove('scale-100', 'opacity-100');
                content.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                }, 300);
            }

            async function requestMentor() {
                if (!selectedMentorId || hasPendingRequest || currentMentorId) return;

                const btnRequest = document.getElementById('btn-request-mentor');
                const originalText = btnRequest.textContent;
                btnRequest.disabled = true;
                btnRequest.textContent = '...';

                try {
                    const url = `{{ url('/murid/mentor/request') }}/${selectedMentorId}`;
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    });
                    const data = await response.json();
                    if (data.success || response.ok) {
                        // GANTI ALERT DENGAN CUSTOM POPUP
                        showCustomAlert('Berhasil!', 'Permintaan berhasil dikirim!', true, () => {
                            window.location.reload();
                        });
                    } else {
                        showCustomAlert('Gagal!', data.message || 'Gagal mengirim permintaan.', false);
                        btnRequest.disabled = false;
                        btnRequest.textContent = originalText;
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showCustomAlert('Error!', 'Terjadi kesalahan sistem.', false);
                    btnRequest.disabled = false;
                    btnRequest.textContent = originalText;
                }
            }

            document.getElementById('mentorModal').addEventListener('click', function (e) {
                if (e.target === this) {
                    closeMentorModal();
                }
            });
        </script>
    @endpush
@endsection