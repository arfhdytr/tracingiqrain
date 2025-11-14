@extends('layouts.murid', ['hideNavbar' => true])

@section('title', 'Pilih Level Iqra-mu!')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header dengan Qira -->
    <div class="max-w-4xl mx-auto mb-12">
        <div class="bg-gradient-to-r from-pink-400 to-pink-500 rounded-full px-8 py-6 shadow-lg relative">
            <div class="flex items-center justify-between">
                <!-- Back Button -->
                <a href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="text-white hover:scale-110 transition-transform">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
                
                <!-- Title -->
                <div class="text-center flex-1">
                    <h1 class="text-white text-3xl font-bold mb-2">Pilih Level Iqra-mu!</h1>
                    <p class="text-white text-sm font-light italic">
                        Ayo mulai petualangan belajar kita. Pilih Iqra 1 untuk memulai!
                    </p>
                </div>
                
                <!-- Qira Mascot -->
                <div class="w-24 h-24">
                    <img src="{{ asset('images/qira-wave.png') }}" alt="Qira" class="w-full h-full object-contain"
                         onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Ctext y=%22.9em%22 font-size=%2290%22%3E🐘%3C/text%3E%3C/svg%3E'">
                </div>
            </div>
        </div>
    </div>
    
    <!-- Iqra Levels -->
    <div class="max-w-4xl mx-auto">
        <div class="grid grid-cols-3 gap-8 mb-16">
            @foreach($tingkatans as $index => $tingkatan)
            <div class="flex flex-col items-center">
                @if($tingkatan->level === 1)
                    <!-- Iqra 1 - Unlocked -->
                    <a href="{{ route('murid.modul.index', $tingkatan->tingkatan_id) }}" 
                       onclick="sessionStorage.setItem('current_tingkatan_id', {{ $tingkatan->tingkatan_id }})"
                       class="group">
                        <div class="w-40 h-40 rounded-full bg-gradient-to-br from-yellow-200 to-yellow-300 flex items-center justify-center shadow-xl hover:scale-110 transition-transform duration-300 border-4 border-white">
                            <div class="text-center">
                                <div class="text-5xl mb-2">📖</div>
                            </div>
                        </div>
                        <p class="text-center mt-4 text-2xl font-semibold text-blue-900">{{ $tingkatan->nama_tingkatan }}</p>
                    </a>
                @else
                    <!-- Locked Levels -->
                    <div class="cursor-not-allowed opacity-60">
                        <div class="w-40 h-40 rounded-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center shadow-lg border-4 border-white">
                            <div class="text-6xl">🔒</div>
                        </div>
                        <p class="text-center mt-4 text-2xl font-semibold text-gray-600">{{ $tingkatan->nama_tingkatan }}</p>
                    </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    /* Additional styles for this page */
    .group:hover .text-5xl {
        animation: bounce 0.6s ease-in-out;
    }
    
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
</style>
@endsection