<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Level Iqra-mu!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Titan+One&display=swap">

    <style>
        /* Reset Default */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        /* Font Utama (Cursive) */
        @font-face {
            font-family: 'Tegak Bersambung_IWK';
            src: url('{{ asset('fonts/TegakBersambung_IWK.ttf') }}') format('truetype');
        }

        /* Font Khusus Angka (Nanum Myeongjo) */
        @font-face {
            font-family: 'NanumMyeongjo';
            src: url('{{ asset('fonts/NanumMyeongjo-Regular.ttf') }}') format('truetype');
        }

        .font-titan-one {
            font-family: 'Titan One', sans-serif;
        }

        .font-tegak-bersambung {
            font-family: 'Tegak Bersambung_IWK', cursive;
        }

        .font-nanum {
            font-family: 'NanumMyeongjo', serif;
            padding-left: 4px;
        }

        .text-shadow-custom {
            text-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);
        }

        .shadow-custom-drop {
            filter: drop-shadow(0 4px 4px rgba(0, 0, 0, 0.25));
        }

        /* Background Pattern */
        .bg-pattern {
            position: relative;
            background: linear-gradient(180deg, #56B1F3 0%, #D3F2FF 100%);
        }

        .bg-pattern::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url('{{ asset('images/games/game-pattern.webp') }}');
            background-size: 500px;
            background-repeat: repeat;
            background-position: center;
            opacity: 0.3;
            z-index: 0;
        }

        /* Animasi Float */
        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-15px);
            }
        }

        /* Animasi Pop-in */
        @keyframes pop-in {
            0% {
                opacity: 0;
                transform: translateX(-50%) scale(0);
            }
            50% {
                transform: translateX(-50%) scale(1.1);
            }
            70% {
                transform: translateX(-50%) scale(0.9);
            }
            100% {
                opacity: 1;
                transform: translateX(-50%) scale(1);
            }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-pop-in {
            animation: pop-in 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
        }

        /* Prevent flash of content before animation */
        .iqra-card {
            opacity: 0;
            transform: translateX(-50%) scale(0);
        }

        /* Animasi Bubble Chat */
        @keyframes bubble-pop {
            0% {
                opacity: 0;
                transform: scale(0);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .bubble-chat {
            animation: bubble-pop 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
            animation-delay: 0.3s;
            opacity: 0;
        }

        /* Bubble tail - Desktop (right) */
        .bubble-chat::after {
            content: '';
            position: absolute;
            bottom: 10px;
            right: -10px;
            width: 0;
            height: 0;
            border-top: 12px solid transparent;
            border-bottom: 12px solid transparent;
            border-left: 15px solid #F387A9;
        }

        /* Bubble tail - Mobile (top) */
        @media (max-width: 767px) {
            .bubble-chat::after {
                bottom: auto;
                top: -10px;
                right: auto;
                left: 50%;
                transform: translateX(-50%);
                border-top: 0;
                border-bottom: 15px solid #F387A9;
                border-left: 12px solid transparent;
                border-right: 12px solid transparent;
            }
        }

        /* Animasi Maskot - Mobile (dari tengah) */
        @keyframes mascot-entrance-mobile {
            0% {
                opacity: 0;
                transform: translateY(-20px) scale(0.8);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Animasi Maskot - Desktop (dari tengah ke kanan) */
        @keyframes mascot-entrance-desktop {
            0% {
                opacity: 0;
                transform: translateX(-100px) translateY(0) scale(0.8);
            }
            100% {
                opacity: 1;
                transform: translateX(0) translateY(0) scale(1);
            }
        }

        .mascot-animate {
            animation: mascot-entrance-mobile 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        @media (min-width: 768px) {
            .mascot-animate {
                animation: mascot-entrance-desktop 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
            }
        }

        /* Tooltip Landing */
        .btn-back {
            position: relative;
        }

        .btn-back .tooltip {
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%) translateX(10px);
            background: white;
            color: #680D2A;
            padding: 8px 16px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            white-space: nowrap;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .btn-back:hover .tooltip {
            opacity: 1;
            transform: translateY(-50%) translateX(15px);
        }

        .btn-back .tooltip::before {
            content: '';
            position: absolute;
            right: 100%;
            top: 50%;
            transform: translateY(-50%);
            border-top: 6px solid transparent;
            border-bottom: 6px solid transparent;
            border-right: 8px solid white;
        }

        /* Animasi Typing Text */
        @keyframes typing {
            from {
                width: 0;
            }
            to {
                width: 100%;
            }
        }

        @keyframes blink-caret {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0;
            }
        }

        .typing-text {
            overflow: hidden;
            white-space: nowrap;
            margin: 0 auto;
            animation: typing 2s steps(30, end) 0.6s forwards;
            width: 0;
            display: inline-block;
            position: relative;
        }

        .typing-text::after {
            content: '|';
            position: absolute;
            right: -5px;
            color: white;
            animation: blink-caret 0.7s step-end 0.6s infinite;
            opacity: 0;
        }

        /* Stop blinking after typing is done */
        @keyframes stop-blink {
            to {
                opacity: 0;
            }
        }

        .typing-text::after {
            animation:
                blink-caret 0.7s step-end 0.6s 4,
                stop-blink 0s 3.4s forwards;
        }

        /* Tulip Corner */
        .tulip-left {
            position: absolute;
            bottom: -10px;
            left: -30px;
            width: 280px;
            height: 180px;
            background-image: url('{{ asset('images/icon/tulip-banyak-crop.png') }}');
            background-repeat: no-repeat;
            background-position: bottom left;
            background-size: contain;
            z-index: 5;
            pointer-events: none;
        }

        .tulip-right {
            position: absolute;
            bottom: -10px;
            right: -60px;
            width: 280px;
            height: 180px;
            background-image: url('{{ asset('images/icon/tulip-banyak-crop.png') }}');
            background-repeat: no-repeat;
            background-position: bottom right;
            background-size: contain;
            z-index: 5;
            pointer-events: none;
            transform: scaleX(-1);
        }

        @media (min-width: 768px) {
            .tulip-left {
                width: 380px;
                height: 240px;
                bottom: -30px;
                left: -40px;
            }

            .tulip-right {
                width: 380px;
                height: 240px;
                bottom: -30px;
                right: -40px;
            }
        }
    </style>
</head>
<body class="bg-pattern relative">

    {{-- Tombol Back di pojok kiri atas --}}
    <a href="{{ route('landing') }}"
        class="btn-back absolute top-6 left-6 md:top-8 md:left-8 text-white hover:scale-110 transition-transform p-2 z-50 bg-[#F387A9] rounded-full shadow-lg">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
        </svg>
        <span class="tooltip">Landing</span>
    </a>

    {{-- Animasi Lebah --}}
    <img src="{{ asset('images/tingkatan/lebah.webp') }}" alt="Lebah"
        class="absolute top-[25%] left-[8%] md:top-[75%] md:left-[10%] w-12 h-12 md:w-16 md:h-16 animate-float z-10"
        style="animation-delay: 0.5s;">
    <img src="{{ asset('images/tingkatan/lebah.webp') }}" alt="Lebah"
        class="absolute top-[28%] right-[8%] md:top-[85%] md:right-[10%] w-12 h-12 md:w-16 md:h-16 animate-float z-10 transform -scale-x-100">

    {{-- Container Utama dengan Header --}}
    <div class="absolute inset-0 flex flex-col items-center justify-center z-20 gap-6 md:gap-8">

        {{-- Header dengan Bubble Chat --}}
        <div class="flex flex-col md:flex-row items-center md:items-end gap-3 md:gap-6 px-4">
            {{-- Maskot Gajah --}}
            <div class="mascot-animate shrink-0 order-1 md:order-2">
                <img src="{{ asset('images/maskot/bawa-hp.webp') }}" alt="Qira"
                    class="w-32 h-32 md:w-40 md:h-40 lg:w-48 lg:h-48 object-contain"
                    style="filter: drop-shadow(0 4px 4px rgba(0,0,0,0.25));">
            </div>

            {{-- Bubble Chat --}}
            <div class="bubble-chat relative bg-[#F387A9] rounded-3xl px-6 py-4 md:px-8 md:py-5 shadow-lg order-2 md:order-1">
                <p class="typing-text font-tegak-bersambung text-white text-2xl md:text-3xl lg:text-4xl text-center leading-tight">
                    Pilih tingkatan Iqra belajar-mu!
                </p>
            </div>
        </div>

        {{-- Grid Level Iqra --}}
        <div class="relative w-full max-w-[900px] h-[400px] md:h-[450px]">

            @foreach ($tingkatans as $index => $tingkatan)
                @php
                    // Posisi custom untuk setiap iqra (3 kolom x 2 baris)
                    $positions = [
                        ['left' => '16.5%', 'top' => '10%'],   // Iqra 1
                        ['left' => '50%', 'top' => '10%'],     // Iqra 2
                        ['left' => '83.5%', 'top' => '10%'],   // Iqra 3
                        ['left' => '16.5%', 'top' => '55%'],   // Iqra 4
                        ['left' => '50%', 'top' => '55%'],     // Iqra 5
                        ['left' => '83.5%', 'top' => '55%'],   // Iqra 6
                    ];
                    $pos = $positions[$index] ?? ['left' => '50%', 'top' => '50%'];
                @endphp

                @if ($tingkatan->level === 1)
                    {{-- CARD AKTIF (IQRA 1) --}}
                    <a href="{{ route('murid.modul.index', $tingkatan->tingkatan_id) }}"
                        onclick="sessionStorage.setItem('current_tingkatan_id', {{ $tingkatan->tingkatan_id }})"
                        class="iqra-card group absolute flex flex-col items-center animate-pop-in"
                        style="left: {{ $pos['left'] }}; top: {{ $pos['top'] }}; animation-delay: {{ $index * 0.15 }}s;">

                        <div class="w-[100px] h-[100px] md:w-[130px] md:h-[130px] rounded-full bg-[#FFEFAE] flex items-center justify-center shadow-custom-drop group-hover:scale-110 transition-transform duration-300">
                            <img src="{{ asset('images/tingkatan/iqra.webp') }}"
                                alt="{{ $tingkatan->nama_tingkatan }}"
                                class="w-14 h-14 md:w-20 md:h-20 object-contain">
                        </div>

                        <p class="text-center mt-2 text-xl md:text-3xl font-tegak-bersambung text-[#680D2A] whitespace-nowrap">
                            {!! preg_replace(
                                '/(\d+)/',
                                '<span class="font-nanum font-bold text-2xl md:text-4xl">$1</span>',
                                $tingkatan->nama_tingkatan,
                            ) !!}
                        </p>
                    </a>
                @else
                    {{-- CARD TERKUNCI --}}
                    <div class="iqra-card absolute flex flex-col items-center cursor-not-allowed opacity-60 animate-pop-in"
                        style="left: {{ $pos['left'] }}; top: {{ $pos['top'] }}; animation-delay: {{ $index * 0.15 }}s;">

                        <div class="w-[100px] h-[100px] md:w-[130px] md:h-[130px] rounded-full bg-[#DFDADA] flex items-center justify-center shadow-custom-drop">
                            <img src="{{ asset('images/tingkatan/gembok.webp') }}"
                                alt="{{ $tingkatan->nama_tingkatan }} (Terkunci)"
                                class="w-14 h-14 md:w-20 md:h-20 object-contain">
                        </div>

                        <p class="text-center mt-2 text-xl md:text-3xl font-tegak-bersambung text-[#680D2A] opacity-70 whitespace-nowrap">
                            {!! preg_replace(
                                '/(\d+)/',
                                '<span class="font-nanum font-bold text-2xl md:text-4xl">$1</span>',
                                $tingkatan->nama_tingkatan,
                            ) !!}
                        </p>
                    </div>
                @endif
            @endforeach

        </div>
    </div>

    {{-- Tulip Corners --}}
    <div class="tulip-left"></div>
    <div class="tulip-right"></div>

</body>
</html>
