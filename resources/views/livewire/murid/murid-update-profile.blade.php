{{-- resources/views/livewire/murid/murid-update-profile.blade.php --}}
<div class="h-screen w-full overflow-y-auto relative flex flex-col">
    <style>
        /* Menggunakan Font Mooli & Fredoka */
        @import url('https://fonts.googleapis.com/css2?family=Mooli&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Titan+One&display=swap');

        /* Definisi Font Tegak Bersambung */
        @font-face {
            font-family: 'Tegak Bersambung_IWK';
            src: url("{{ asset('fonts/TegakBersambung_IWK.ttf') }}") format('truetype');
        }

        .font-fredoka { font-family: 'Fredoka', sans-serif; }
        .font-mooli { font-family: 'Mooli', sans-serif; }
        .font-titan { font-family: 'Titan One', sans-serif; }
        .font-cursive { font-family: 'Tegak Bersambung_IWK', cursive; }
    </style>
    
    {{-- Background with Pattern --}}
    <div class="fixed inset-0 w-full h-full z-0 pointer-events-none"
        style="background: linear-gradient(180deg, #56B1F3 0%, #D3F2FF 100%); z-index: -1;">
        {{-- Pattern --}}
        <div class="absolute inset-0 w-full h-full"
            style="background-image: url('{{ asset('images/games/game-pattern.webp') }}'); 
                   background-size: 500px;
                   background-repeat: repeat;
                   background-position: center; 
                   opacity: 0.3;">
        </div>
    </div>

    {{-- Back Button --}}
    <a 
        href="{{ route('murid.pilih-iqra') }}" 
        class="absolute top-6 left-6 z-[100] flex items-center space-x-2 px-4 py-2 bg-white border-2 border-iqrain-blue text-iqrain-blue rounded-lg hover:bg-iqrain-blue hover:text-white transition-all shadow-md cursor-pointer"
    >
        <i class="fas fa-arrow-left"></i>
        <span class="font-mooli font-semibold font-medium ">Kembali</span>
    </a>

    {{-- Main Content Container with padding for footer --}}
    <div class="flex-1 flex items-center justify-center px-4 relative z-10 py-24">
        <div class="w-full max-w-4xl">
            
            {{-- Form Container --}}
            <div class="bg-white rounded-2xl shadow-2xl p-8">
                <form wire:submit.prevent="updateProfile" class="space-y-6">
                    
                    {{-- Title --}}
                    <div class="text-center mb-6">
                        <h1 class="text-4xl font-fredoka font-bold text-iqrain-blue flex items-center justify-center space-x-3">
                            <span>Ubah Profil Saya</span>
                        </h1>
                    </div>

                    {{-- Content Grid --}}
                    <div class="grid grid-cols-3 gap-8">
                        
                        {{-- Left Column: Photo --}}
                        <div class="col-span-1 flex flex-col items-center justify-center space-y-4" x-data="{ photoPreview: null }">
                            {{-- Photo Display --}}
                            <div class="relative">
                                <div x-show="!photoPreview">
                                    <img src="{{ $currentPhoto }}" alt="Foto Profil" class="w-40 h-40 rounded-full object-cover border-4 border-iqrain-yellow shadow-lg">
                                </div>
                                <div x-show="photoPreview" style="display: none;">
                                    <img :src="photoPreview" alt="Preview" class="w-40 h-40 rounded-full object-cover border-4 border-iqrain-yellow shadow-lg">
                                </div>
                            </div>

                            <input 
                                type="file" 
                                id="photo" 
                                wire:model="photo" 
                                class="hidden"
                                accept="image/*"
                                x-ref="photoInput"
                                @change="
                                    const file = $refs.photoInput.files[0];
                                    if (file) {
                                        const reader = new FileReader();
                                        reader.onload = (e) => photoPreview = e.target.result;
                                        reader.readAsDataURL(file);
                                    }
                                "
                            >

                            {{-- Photo Actions --}}
                            <div class="flex flex-col space-y-2 w-full">
                                <button 
                                    type="button"
                                    @click="$refs.photoInput.click()"
                                    class="w-full px-4 py-2 bg-iqrain-blue font-mooli font-semibold text-white rounded-lg hover:opacity-90 transition shadow"
                                >
                                    <i class="fas fa-camera mr-2"></i>Pilih Foto
                                </button>
                            </div>

                            @error('photo')
                                <p class="text-red-500 text-sm text-center">{{ $message }}</p>
                            @enderror

                            <div wire:loading wire:target="photo" class="text-iqrain-blue text-sm">
                                <i class="fas fa-spinner fa-spin mr-2"></i>Mengunggah...
                            </div>
                        </div>

                        {{-- Right Column: Form Fields --}}
                        <div class="col-span-2 space-y-5">
                            
                            {{-- Username --}}
                            <div>
                                <label class="block text-3xl font-cursive text-iqrain-blue mb-2">
                                    <i class="fas fa-user mr-2"></i>
                                    <span class="phrase-pink">Username</span>
                                </label>
                                <input 
                                    type="text" 
                                    wire:model="username" 
                                    class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-iqrain-blue focus:outline-none transition @error('username') border-red-500 @enderror"
                                    placeholder="Username kamu"
                                >
                                @error('username')
                                    <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Sekolah --}}
                            <div>
                                <label class="block text-iqrain-blue text-3xl font-cursive mb-2">
                                    <i class="fas fa-school mr-2"></i>
                                    <span class="phrase-pink">Sekolah</span>
                                </label>
                                <input 
                                    type="text" 
                                    wire:model="sekolah" 
                                    class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-iqrain-blue focus:outline-none transition"
                                    placeholder="Nama sekolah"
                                >
                            </div>

                            {{-- Warna Kesukaan --}}
                            <div>
                                <label class="block text-3xl font-cursive text-iqrain-blue mb-2">
                                    <i class="fas fa-palette mr-2"></i>
                                    <span class="phrase-pink">Warna</span>
                                    <span class="phrase-pink">Kesukaan</span>
                                </label>

                                {{-- Color Grid --}}
                                <div class="grid grid-cols-4 gap-3">
                                    @foreach(['Merah', 'Biru', 'Hijau', 'Kuning', 'Ungu', 'Pink', 'Oranye', 'Hitam'] as $warna)
                                        <button 
                                            type="button"
                                            wire:click="$set('warna_kesukaan', '{{ $warna }}')"
                                            class="relative p-3 rounded-lg border-2 transition hover:scale-105
                                                @if($warna_kesukaan === $warna) 
                                                    border-iqrain-blue bg-blue-50
                                                @else 
                                                    border-gray-300 hover:border-iqrain-blue
                                                @endif"
                                        >
                                            {{-- Checkmark --}}
                                            @if($warna_kesukaan === $warna)
                                                <div class="absolute -top-1 -right-1 bg-iqrain-blue text-white rounded-full w-5 h-5 flex items-center justify-center shadow">
                                                    <i class="fas fa-check text-xs"></i>
                                                </div>
                                            @endif

                                            {{-- Color Box --}}
                                            <div class="w-full h-10 rounded mb-1 shadow-sm {{ 
                                                $warna === 'Merah' ? 'bg-red-500' :
                                                ($warna === 'Biru' ? 'bg-blue-500' :
                                                ($warna === 'Hijau' ? 'bg-green-500' :
                                                ($warna === 'Kuning' ? 'bg-yellow-400' :
                                                ($warna === 'Ungu' ? 'bg-purple-500' :
                                                ($warna === 'Pink' ? 'bg-pink-500' :
                                                ($warna === 'Oranye' ? 'bg-orange-500' : 'bg-gray-800'))))))
                                            }}"></div>
                                            
                                            {{-- Label --}}
                                            <p class="text-xl font-cursive font-medium text-gray-700 phrase-pink">{{ $warna }}</p>
                                        </button>
                                    @endforeach
                                </div>
                                
                                @error('warna_kesukaan')
                                    <p class="mt-2 text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                                
                                <p class="mt-2 text-gray-500 text-xs font-mooli font-semibold">
                                    <i class="fas fa-lock mr-1"></i>Untuk pemulihan akun jika lupa password
                                </p>
                            </div>

                        </div>

                    </div>

                    {{-- Submit Button --}}
                    <div class="flex justify-center pt-4">
                        <button 
                            type="submit" 
                            class="px-8 py-3 bg-iqrain-blue text-white font-mooli font-semibold rounded-lg hover:opacity-90 transition shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                            wire:loading.attr="disabled"
                        >
                            <span wire:loading.remove wire:target="updateProfile">
                                <i class="fas fa-save mr-2"></i>Simpan Profil
                            </span>
                            <span wire:loading wire:target="updateProfile">
                                <i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...
                            </span>
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>

    {{-- SweetAlert Script untuk mendengarkan event Livewire --}}
    @push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('show-success', (event) => {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });

                Toast.fire({
                    icon: 'success',
                    title: event.message || 'Berhasil!'
                });
            });
        });
    </script>
    @endpush

</div>