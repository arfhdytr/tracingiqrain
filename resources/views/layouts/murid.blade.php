<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'IQRAIN - Belajar Iqra Menyenangkan')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom CSS -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600;700&display=swap');
        
        * {
            font-family: 'Fredoka', sans-serif;
        }
        
        body {
            background: linear-gradient(180deg, #87CEEB 0%, #B0E0E6 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        
        /* Pink Navbar */
        .navbar-murid {
            background: linear-gradient(135deg, #FF6B9D 0%, #E85A8B 100%);
            box-shadow: 0 4px 20px rgba(255, 107, 157, 0.3);
        }
        
        .nav-item {
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
        
        /* Bottom Decoration */
        .bottom-decoration {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 10;
            pointer-events: none;
        }
        
        /* Content wrapper to avoid overlap */
        .content-wrapper {
            min-height: calc(100vh - 200px);
            padding-bottom: 220px;
        }
        
        /* Bee Animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(-5deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
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
    </style>
    
    @stack('styles')
</head>
<body>
    
    <!-- Navbar -->
    @if(!isset($hideNavbar) || !$hideNavbar)
    <nav class="navbar-murid fixed top-0 left-0 right-0 z-50">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between max-w-4xl mx-auto">
                <!-- Logo -->
                <a href="{{ route('murid.pilih-iqra') }}" class="flex items-center space-x-2">
                    <div class="bg-white rounded-full w-12 h-12 flex items-center justify-center">
                        <span class="text-2xl font-bold text-pink-500">IQ</span>
                    </div>
                </a>
                
                <!-- Nav Items -->
                <div class="flex items-center space-x-2">
                    <a href="{{ route('murid.modul.index', ['tingkatan_id' => session('current_tingkatan_id', 1)]) }}" 
                       class="nav-item px-6 py-2 rounded-full text-sm {{ request()->routeIs('murid.modul.*') ? 'active' : '' }}">
                        Modul
                    </a>
                    <a href="{{ route('murid.games.index', ['tingkatan_id' => session('current_tingkatan_id', 1)]) }}" 
                       class="nav-item px-6 py-2 rounded-full text-sm {{ request()->routeIs('murid.games.*') ? 'active' : '' }}">
                        Games
                    </a>
                    <a href="{{ route('murid.evaluasi.index', ['tingkatan_id' => session('current_tingkatan_id', 1)]) }}" 
                       class="nav-item px-6 py-2 rounded-full text-sm {{ request()->routeIs('murid.evaluasi.*') ? 'active' : '' }}">
                        Evaluasi
                    </a>
                    <a href="{{ route('murid.mentor.index') }}" 
                       class="nav-item px-6 py-2 rounded-full text-sm {{ request()->routeIs('murid.mentor.*') ? 'active' : '' }}">
                        Mentor
                    </a>
                </div>
                
                <!-- Profile -->
                <a href="#" class="bg-white rounded-full w-10 h-10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-pink-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                    </svg>
                </a>
            </div>
        </div>
    </nav>
    @endif
    
    <!-- Main Content -->
    <main class="content-wrapper pt-20">
        @yield('content')
    </main>
    
    <!-- Bottom Decoration (Qira + Fence) -->
    <div class="bottom-decoration">
        <!-- Fence with flowers -->
        <div class="relative h-48">
            <img src="{{ asset('images/fence-decoration.png') }}" alt="" class="w-full h-full object-cover object-top" 
                 onerror="this.style.display='none'">
            
            <!-- Fallback if image not found - CSS fence -->
            <div class="absolute inset-0 flex items-end justify-center" style="background: linear-gradient(to top, #8B4513 50px, transparent 50px);">
                <!-- Qira Mascot in Car -->
                <div class="absolute left-1/2 transform -translate-x-1/2 bottom-8 z-20">
                    <img src="{{ asset('images/qira-mascot.png') }}" alt="Qira" class="h-40" 
                         onerror="this.style.display='none'">
                </div>
            </div>
        </div>
    </div>
    
    <!-- Floating Bees -->
    <div class="fixed top-40 right-20 bee-float z-5">
        <div class="text-6xl">🐝</div>
    </div>
    <div class="fixed top-60 left-20 bee-float z-5" style="animation-delay: 1.5s;">
        <div class="text-5xl">🐝</div>
    </div>
    
    <!-- Scripts -->
    <script>
        // Set CSRF token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Helper function for AJAX
        async function fetchAPI(url, options = {}) {
            const defaultOptions = {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
            };
            
            const response = await fetch(url, { ...defaultOptions, ...options });
            return response.json();
        }
        
        // Show toast notification
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `fixed top-24 right-4 z-50 px-6 py-3 rounded-full text-white font-semibold shadow-lg transition-all duration-300 ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            }`;
            toast.textContent = message;
            toast.style.transform = 'translateX(400px)';
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.transform = 'translateX(0)';
            }, 100);
            
            setTimeout(() => {
                toast.style.transform = 'translateX(400px)';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }
    </script>
    
    @stack('scripts')
</body>
</html>