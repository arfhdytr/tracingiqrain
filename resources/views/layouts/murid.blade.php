<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'IQRAIN - Belajar Iqra Menyenangkan')</title>

    {{-- Tailwind CSS & Custom CSS via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Font Tegak Bersambung IWK (Pastikan path benar) */
        @font-face {
            font-family: 'Tegak Bersambung IWK';
            src: url("{{ asset('fonts/TegakBersambung_IWK.ttf') }}") format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        /* Font Mooli untuk Skor */
        .font-mooli {
            font-family: 'Mooli', sans-serif !important;
        }

        /* Import Font Titan One dari Google Fonts secara global */
        @import url('https://fonts.googleapis.com/css2?family=Titan+One&display=swap');
        /* Import Font Nanum Myeongjo dari Google Fonts secara global */
        @import url('https://fonts.googleapis.com/css2?family=Nanum+Myeongjo&display=swap');
        /* Import Font Fredoka dari Google Fonts secara global */
        @import url('https://fonts.googleapis.com/css2?family=Fredoka&display=swap');
        /* Import Font Mooli dari Google Fonts secara global */
        @import url('https://fonts.googleapis.com/css2?family=Mooli&display=swap');


        /* Default Font for everything */
        * {
            font-family: 'Fredoka', sans-serif;
        }

        /* --- Body --- */
        body {
            background: linear-gradient(180deg, #87CEEB 0%, #B0E0E6 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Style Container Navbar */
        .navbar-murid {
            background: #F387A9;
            border-radius: 74px;
            box-shadow: 0 4px 4px 0 rgba(0, 0, 0, 0.25);
        }

        /* Navbar Link Items */
        .nav-item {
            font-family: 'Mooli', sans-serif;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .nav-item:hover {
            transform: translateY(-2px);
        }

        .nav-item.active {
            background: white;
            color: #FF6B9D;
            font-weight: 600;
        }

        .nav-item:not(.active) {
            color: white;
        }

        /* Mobile Menu Container - Separate box */
        .mobile-menu-container {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-in-out, opacity 0.3s ease-in-out;
            opacity: 0;
            background: #F387A9;
            border-radius: 24px;
            box-shadow: 0 4px 4px 0 rgba(0, 0, 0, 0.25);
        }

        .mobile-menu-container.active {
            max-height: 400px;
            opacity: 1;
        }

        /* Mobile Menu Inner */
        .mobile-menu {
            width: 100%;
        }

        /* --- Padding Content --- */
        .content-wrapper {
            padding-top: 80px;
            padding-bottom: 50px;
        }

        /* Bee Animation */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(-5deg);
            }

            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }

        .bee-float {
            animation: float 3s ease-in-out infinite;
        }

        /* Card styles */
        .card-rounded {
            border-radius: 30px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        /* Button styles */
        .btn-primary {
            background: linear-gradient(135deg, #FF6B9D 0%, #E85A8B 100%);
            color: white;
            padding: 12px 32px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 107, 157, 0.4);
        }

        .btn-secondary {
            background: white;
            color: #FF6B9D;
            padding: 12px 32px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid #FF6B9D;
            cursor: pointer;
        }

        .btn-secondary:hover {
            background: #FF6B9D;
            color: white;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #FF6B9D;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #E85A8B;
        }

        /* Menambahkan font-family kustom (di sini kita bisa menambahkan !important) */
        .font-titan {
            font-family: 'Titan One', sans-serif !important;
        }

        .font-mooli { 
            font-family: 'Mooli', sans-serif !important;
        }

        .font-cursive-iwk {
            font-family: 'Tegak Bersambung IWK', cursive !important;
        }

        .font-nanum {
            font-family: 'Nanum Myeongjo', serif !important;
        }

        .phrase {
            display: inline-block;
            text-wrap: nowrap;
            font-family: 'Tegak Bersambung IWK', cursive;
        }

        .phrase::after {
            content: "";
            display: block;
            width: 100%;
            height: 16px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 50' preserveAspectRatio='none'%3E%3Cpath fill='none' stroke='%23ffffff' stroke-width='4' d='M5,5 C30,35 70,35 95,5' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-size: 100% 100%;
        }

        /* Mobile responsive adjustments */
        @media (max-width: 768px) {
            .nav-item {
                font-size: 20px;
            }

            .content-wrapper {
                padding-top: 100px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    @if (!isset($hideNavbar) || !$hideNavbar)
        <nav
            class="navbar-murid fixed top-4 left-4 right-4 z-50 mx-auto rounded-full md:w-11/12 md:max-w-5xl md:left-0 md:right-0">
            <div class="container mx-auto px-4 py-3">
                {{-- Desktop Navigation --}}
                <div class="hidden md:flex items-center justify-between max-w-4xl mx-auto">
                    <a href="{{ route('murid.pilih-iqra') }}" class="flex items-center space-x-2">
                        <img src="{{ asset('images/asset/logo.webp') }}" alt="Logo IQRAIN" class="w-12 h-12 object-contain">
                    </a>

                    <div class="flex items-center space-x-2">
                        <a href="{{ route('murid.modul.index', ['tingkatan_id' => session('current_tingkatan_id', 1)]) }}"
                            class="nav-item px-6 py-2 rounded-full text-xs {{ request()->routeIs('murid.modul.*') ? 'active' : '' }}">
                            Modul
                        </a>
                        <a href="{{ route('murid.games.index', ['tingkatan_id' => session('current_tingkatan_id', 1)]) }}"
                            class="nav-item px-6 py-2 rounded-full text-xs {{ request()->routeIs('murid.games.*') ? 'active' : '' }}">
                            Games
                        </a>
                        <a href="{{ route('murid.evaluasi.index', ['tingkatan_id' => session('current_tingkatan_id', 1)]) }}"
                            class="nav-item px-6 py-2 rounded-full text-xs {{ request()->routeIs('murid.evaluasi.*') ? 'active' : '' }}">
                            Evaluasi
                        </a>
                        <a href="{{ route('murid.mentor.index') }}"
                            class="nav-item px-6 py-2 rounded-full text-xs {{ request()->routeIs('murid.mentor.*') ? 'active' : '' }}">
                            Mentor
                        </a>
                    </div>

                    {{-- Profile Dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false"
                            class="bg-white rounded-full w-10 h-10 flex items-center justify-center focus:outline-none cursor-pointer">
                            <svg class="w-6 h-6 text-pink-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                            </svg>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 z-50 border-2 border-pink-100"
                            style="display: none;">

                            {{-- Edit Profil --}}
                            <a href="{{ route('murid.profile') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-600 font-mooli font-medium transition-colors">
                                <i class="fas fa-user-edit mr-2"></i>Edit Profil
                            </a>

                            {{-- Logout --}}
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium font-mooli transition-colors">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Mobile Navigation --}}
                <div class="md:hidden">
                    <div class="flex items-center justify-between h-full">
                        {{-- Logo --}}
                        <a href="{{ route('murid.pilih-iqra') }}" class="flex items-center">
                            <img src="{{ asset('images/asset/logo.webp') }}" alt="Logo IQRAIN" class="w-10 h-10 object-contain">
                        </a>

                        <div class="flex items-center space-x-3">
                            {{-- Profile Icon Mobile --}}
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" @click.away="open = false"
                                    class="bg-white rounded-full w-9 h-9 flex items-center justify-center focus:outline-none cursor-pointer">
                                    <svg class="w-5 h-5 text-pink-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                                    </svg>
                                </button>

                                {{-- Dropdown Menu Mobile --}}
                                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 z-50 border-2 border-pink-100"
                                    style="display: none;">

                                    {{-- Edit Profil --}}
                                    <a href="{{ route('murid.profile') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-50 hover:text-pink-600 font-medium transition-colors">
                                        <i class="fas fa-user-edit mr-2"></i>Edit Profil
                                    </a>

                                    {{-- Logout --}}
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium transition-colors">
                                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                        </button>
                                    </form>
                                </div>
                            </div>

                            {{-- Hamburger Button --}}
                            <button id="mobileMenuToggle" class="text-white focus:outline-none flex items-center justify-center">
                                <i class="fas fa-bars text-2xl"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        {{-- Mobile Menu Container (Outside Navbar) --}}
        <div id="mobileMenuContainer" class="mobile-menu-container fixed top-24 left-4 right-4 z-40 md:hidden">
            <div id="mobileMenu" class="mobile-menu">
                <div class="flex flex-col space-y-2 p-4">
                    <a href="{{ route('murid.modul.index', ['tingkatan_id' => session('current_tingkatan_id', 1)]) }}"
                        class="nav-item px-4 py-2 rounded-full text-center {{ request()->routeIs('murid.modul.*') ? 'active' : '' }}">
                        <i class="fas fa-book mr-2"></i>Modul
                    </a>
                    <a href="{{ route('murid.games.index', ['tingkatan_id' => session('current_tingkatan_id', 1)]) }}"
                        class="nav-item px-4 py-2 rounded-full text-center {{ request()->routeIs('murid.games.*') ? 'active' : '' }}">
                        <i class="fas fa-gamepad mr-2"></i>Games
                    </a>
                    <a href="{{ route('murid.evaluasi.index', ['tingkatan_id' => session('current_tingkatan_id', 1)]) }}"
                        class="nav-item px-4 py-2 rounded-full text-center {{ request()->routeIs('murid.evaluasi.*') ? 'active' : '' }}">
                        <i class="fas fa-clipboard-check mr-2"></i>Evaluasi
                    </a>
                    <a href="{{ route('murid.mentor.index') }}"
                        class="nav-item px-4 py-2 rounded-full text-center {{ request()->routeIs('murid.mentor.*') ? 'active' : '' }}">
                        <i class="fas fa-user-tie mr-2"></i>Mentor
                    </a>
                </div>
            </div>
        </div>
    @endif

    <main class="content-wrapper">
        @yield('content')
    </main>

    {{-- FOOTER GLOBAL --}}
    <div class="w-full relative z-20 -mt-12 pointer-events-none">
        <img src="{{ asset('images/games/game-footer.webp') }}" alt="Footer Decoration"
            class="w-full h-auto object-cover block select-none">
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        async function fetchAPI(url, options = {}) {
            try {
                const response = await fetch(url, {
                    ...options,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        ...(options.headers || {})
                    }
                });
                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || `API request failed with status ${response.status}`);
                }
                return await response.json();
            } catch (error) {
                console.error('API Fetch Error:', error);
                throw error;
            }
        }

        function showToast(message, type = 'success') {
            const toastContainer = document.createElement('div');
            toastContainer.className = 'fixed bottom-4 right-4 z-[9999] flex items-center p-4 rounded-lg shadow-lg text-white ' +
                (type === 'success' ? 'bg-green-500' : 'bg-red-500');
            toastContainer.innerHTML = `
                <div class="mr-2">
                    ${type === 'success' ? '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>' : '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'}
                </div>
                <div>${message}</div>
            `;
            document.body.appendChild(toastContainer);
            setTimeout(() => {
                toastContainer.remove();
            }, 3000);
        }

        // Mobile Menu Toggle
        document.addEventListener('DOMContentLoaded', function () {
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const mobileMenuContainer = document.getElementById('mobileMenuContainer');

            if (mobileMenuToggle && mobileMenuContainer) {
                mobileMenuToggle.addEventListener('click', function () {
                    mobileMenuContainer.classList.toggle('active');

                    // Toggle icon
                    const icon = this.querySelector('i');
                    if (mobileMenuContainer.classList.contains('active')) {
                        icon.classList.remove('fa-bars');
                        icon.classList.add('fa-times');
                    } else {
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    }
                });

                // Close menu when clicking outside
                document.addEventListener('click', function (event) {
                    const isClickInside = mobileMenuToggle.contains(event.target) || mobileMenuContainer.contains(event.target);

                    if (!isClickInside && mobileMenuContainer.classList.contains('active')) {
                        mobileMenuContainer.classList.remove('active');
                        const icon = mobileMenuToggle.querySelector('i');
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    }
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>