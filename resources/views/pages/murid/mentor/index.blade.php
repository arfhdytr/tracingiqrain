@extends('layouts.murid')

@section('title', 'Pilih Mentor')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="flex items-center justify-center gap-4 mb-4">
                <h1 class="text-5xl font-bold text-blue-900">Kenalan sama<br>Para Mentor!</h1>
                <div class="w-32">
                    <img src="{{ asset('images/qira-hello.png') }}" alt="Qira" class="w-full"
                         onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Ctext y=%22.9em%22 font-size=%2290%22%3E🐘👋%3C/text%3E%3C/svg%3E'">
                </div>
            </div>
            <p class="text-2xl text-blue-800 font-light italic">
                Belajar akan jadi lebih seru dengan<br>bimbingan para mentor!
            </p>
        </div>
        
        <!-- Pending Request Alert -->
        @if($pendingRequest)
        <div class="bg-yellow-100 border-4 border-yellow-400 rounded-3xl p-6 mb-8">
            <div class="flex items-center gap-4">
                <div class="text-5xl">⏳</div>
                <div>
                    <p class="text-xl font-bold text-yellow-800">Permintaan sedang diproses</p>
                    <p class="text-yellow-700">
                        Kamu sudah mengirim permintaan ke 
                        <span class="font-bold">{{ $pendingRequest->mentor->user->username }}</span>. 
                        Tunggu persetujuan ya!
                    </p>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Mentors Grid -->
        <div class="grid grid-cols-3 gap-6">
            @forelse($mentors as $mentor)
            <div class="mentor-card bg-gradient-to-br from-pink-200 to-pink-100 rounded-3xl p-6 shadow-xl hover:scale-105 transition-transform cursor-pointer"
                 onclick="showMentorDetail({{ $mentor->mentor_id }}, '{{ $mentor->nama_lengkap }}', '{{ $mentor->user->username }}', {{ $mentor->murids->count() }})">
                
                <!-- Success Checkmark -->
                <div class="flex justify-center mb-4">
                    <div class="bg-green-400 rounded-full p-3">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                
                <!-- Egg-shaped Avatar Container -->
                <div class="bg-gradient-to-br from-yellow-200 to-yellow-100 rounded-full w-32 h-40 mx-auto mb-4 flex items-center justify-center shadow-inner"
                     style="border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;">
                    <div class="bg-blue-400 rounded-full w-20 h-20 flex items-center justify-center">
                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                        </svg>
                    </div>
                </div>
                
                <!-- Mentor Info -->
                <div class="text-center">
                    <h3 class="text-xl font-bold text-pink-700 mb-1">{{ $mentor->user->username }}</h3>
                    <p class="text-sm text-pink-600">Kelas: {{ $mentor->nama_lengkap }}</p>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center text-gray-500 py-12">
                Belum ada mentor yang tersedia
            </div>
            @endforelse
        </div>
        
    </div>
</div>

<!-- Mentor Detail Modal -->
<div id="mentorModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-gradient-to-br from-pink-200 to-pink-300 rounded-3xl p-8 max-w-lg mx-4 shadow-2xl relative">
        <button onclick="closeMentorModal()" class="absolute top-4 right-4 text-pink-700 hover:text-pink-900 text-3xl font-bold">
            ×
        </button>
        
        <!-- Mentor Avatar -->
        <div class="bg-gradient-to-br from-yellow-200 to-yellow-100 rounded-full w-40 h-48 mx-auto mb-6 flex items-center justify-center shadow-inner"
             style="border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;">
            <div class="bg-blue-400 rounded-full w-24 h-24 flex items-center justify-center">
                <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                </svg>
            </div>
        </div>
        
        <!-- Mentor Info -->
        <div class="text-center mb-6">
            <h2 class="text-3xl font-bold text-pink-700 mb-2" id="modal-mentor-name">Kak Ajeng</h2>
            <p class="text-xl text-pink-600" id="modal-mentor-class">Kelas: XXXXX</p>
        </div>
        
        <!-- Stats -->
        <div class="flex justify-center gap-4 mb-8">
            <div class="bg-white rounded-2xl px-6 py-3 text-center shadow-lg">
                <div class="flex items-center gap-2 text-blue-600">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                    </svg>
                    <span class="font-bold text-lg" id="modal-mentor-students">0</span>
                </div>
                <p class="text-sm text-gray-600">Murid</p>
            </div>
            
            <div class="bg-white rounded-2xl px-6 py-3 text-center shadow-lg">
                <div class="flex items-center gap-2 text-green-600">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-bold text-lg">2 Tahun</span>
                </div>
                <p class="text-sm text-gray-600">Pengalaman</p>
            </div>
        </div>
        
        <!-- Message -->
        <div class="bg-white rounded-2xl p-4 mb-6">
            <p class="text-center text-gray-600 italic">
                Apakah Kak <span id="modal-mentor-name-2">Ajeng</span> menjadi mentormu?
            </p>
        </div>
        
        <!-- Actions -->
        <div class="flex gap-4">
            <button onclick="closeMentorModal()" class="flex-1 bg-white text-pink-600 font-bold py-3 rounded-full hover:bg-gray-100 transition-colors">
                Gapapa
            </button>
            <button onclick="requestMentor()" id="btn-request-mentor" class="flex-1 bg-gradient-to-r from-pink-500 to-pink-600 text-white font-bold py-3 rounded-full hover:from-pink-600 hover:to-pink-700 transition-colors">
                Gabung
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let selectedMentorId = null;
    const hasPendingRequest = {{ $pendingRequest ? 'true' : 'false' }};
    const currentMentorId = {{ auth()->user()->murid->mentor_id ?? 'null' }};
    
    function showMentorDetail(mentorId, namaLengkap, username, studentCount) {
        selectedMentorId = mentorId;
        
        document.getElementById('modal-mentor-name').textContent = username;
        document.getElementById('modal-mentor-name-2').textContent = username;
        document.getElementById('modal-mentor-class').textContent = 'Kelas: ' + namaLengkap;
        document.getElementById('modal-mentor-students').textContent = studentCount;
        
        // Disable button if has pending request or already has mentor
        const btnRequest = document.getElementById('btn-request-mentor');
        if (hasPendingRequest || currentMentorId) {
            btnRequest.disabled = true;
            btnRequest.classList.add('opacity-50', 'cursor-not-allowed');
            btnRequest.textContent = hasPendingRequest ? 'Menunggu...' : 'Sudah Punya Mentor';
        }
        
        document.getElementById('mentorModal').style.display = 'flex';
    }
    
    function closeMentorModal() {
        document.getElementById('mentorModal').style.display = 'none';
    }
    
    async function requestMentor() {
        if (!selectedMentorId || hasPendingRequest || currentMentorId) {
            return;
        }
        
        try {
            const response = await fetchAPI(`/murid/mentor/request/${selectedMentorId}`, {
                method: 'POST'
            });
            
            if (response.success) {
                showToast(response.message, 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showToast(response.message, 'error');
            }
        } catch (error) {
            console.error('Error requesting mentor:', error);
            showToast('Terjadi kesalahan. Coba lagi ya!', 'error');
        }
    }
    
    // Close modal on outside click
    document.getElementById('mentorModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeMentorModal();
        }
    });
</script>
@endpush

@endsection