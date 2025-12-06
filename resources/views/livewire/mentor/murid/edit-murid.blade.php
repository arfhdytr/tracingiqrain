{{-- resources/views/livewire/mentor/murid/edit-murid.blade.php --}}
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-4xl mx-auto">
    
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('mentor.murid.index') }}" 
               class="text-iqrain-yellow hover:text-white transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl text-white font-bold">Edit Murid</h1>
        </div>
        <p class="text-iqrain-yellow">Perbarui informasi murid {{ $murid->user->username }}</p>
    </div>

    {{-- Alert Messages --}}
    @if (session()->has('error'))
        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
            <div class="flex">
                <i class="fas fa-exclamation-circle text-red-400 mt-0.5"></i>
                <div class="ml-3">
                    <p class="text-sm text-red-800 dark:text-red-200">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    {{-- Form Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg">
        <form wire:submit.prevent="save">
            <div class="p-6 space-y-6">
                
                {{-- Section: Akun Login --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-user-circle text-pink-500 mr-2"></i>
                        Informasi Akun
                    </h3>
                    <div class="grid grid-cols-1 gap-6">
                        {{-- Username --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Username <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                wire:model.blur="username"
                                class="shadow-sm focus:ring-pink-500 focus:border-pink-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md @error('username') border-red-500 @enderror"
                                placeholder="Masukkan username"
                            >
                            @error('username')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- New Password --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Password Baru
                            </label>
                            <input 
                                type="password" 
                                wire:model.blur="new_password"
                                class="shadow-sm focus:ring-pink-500 focus:border-pink-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md @error('new_password') border-red-500 @enderror"
                                placeholder="Kosongkan jika tidak ingin mengubah password"
                            >
                            @error('new_password')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Minimal 6 karakter. Kosongkan jika tidak ingin mengubah.</p>
                        </div>

                        {{-- Confirm New Password --}}
                        @if($new_password)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Konfirmasi Password Baru
                                </label>
                                <input 
                                    type="password" 
                                    wire:model.blur="new_password_confirmation"
                                    class="shadow-sm focus:ring-pink-500 focus:border-pink-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md"
                                    placeholder="Ketik ulang password baru"
                                >
                            </div>
                        @endif
                    </div>
                </div>

                <hr class="border-gray-200 dark:border-gray-700">

                {{-- Section: Informasi Murid --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-id-card text-pink-500 mr-2"></i>
                        Informasi Murid
                    </h3>
                    <div class="grid grid-cols-1 gap-6">
                        {{-- Sekolah --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Sekolah
                            </label>
                            <input 
                                type="text" 
                                wire:model.blur="sekolah"
                                class="shadow-sm focus:ring-pink-500 focus:border-pink-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md @error('sekolah') border-red-500 @enderror"
                                placeholder="Nama sekolah (opsional)"
                            >
                            @error('sekolah')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="border-gray-200 dark:border-gray-700">

                {{-- Section: Preferensi Keamanan --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-shield-alt text-pink-500 mr-2"></i>
                        Preferensi Keamanan
                    </h3>
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-4">
                        <div class="flex">
                            <i class="fas fa-info-circle text-blue-400 mt-0.5 mr-3"></i>
                            <div class="flex-1">
                                <p class="text-sm text-blue-800 dark:text-blue-200">
                                    Pertanyaan keamanan tetap dan tidak dapat diubah. Jawaban ini digunakan untuk reset password jika murid lupa password.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-6">
                        {{-- Pertanyaan Preferensi (Fixed/Read-only) --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Pertanyaan Keamanan
                            </label>
                            <div class="shadow-sm block w-full sm:text-sm border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-900 text-gray-600 dark:text-gray-400 rounded-md px-3 py-2">
                                {{ \App\Livewire\Mentor\Murid\EditMurid::PERTANYAAN_PREFERENSI }}
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Pertanyaan ini tetap dan tidak dapat diubah</p>
                        </div>

                        {{-- Jawaban Preferensi --}}
                        <div x-data="{
                            open: false,
                            selected: @entangle('jawaban_preferensi'),
                            colors: {
                                'Merah': 'bg-red-500',
                                'Biru': 'bg-blue-500',
                                'Hijau': 'bg-green-500',
                                'Kuning': 'bg-yellow-400',
                                'Ungu': 'bg-purple-500',
                                'Pink': 'bg-pink-500',
                                'Oranye': 'bg-orange-500',
                                'Hitam': 'bg-gray-800'
                            },
                            selectColor(color) {
                                this.selected = color;
                                this.open = false;
                            }
                        }">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Jawaban (Opsional)
                            </label>

                            <div class="relative" @click.away="open = false">
                                {{-- Dropdown Button --}}
                                <button
                                    type="button"
                                    @click="open = !open"
                                    class="w-full px-4 py-2 text-left rounded-md border @error('jawaban_preferensi') border-red-500 @else border-gray-300 dark:border-gray-600 @enderror bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-pink-500 flex items-center justify-between"
                                >
                                    <span class="flex items-center">
                                        <template x-if="selected && colors[selected]">
                                            <span class="w-4 h-4 rounded mr-2" :class="colors[selected]"></span>
                                        </template>
                                        <span x-text="selected || 'Pilih Warna Kesukaan'"></span>
                                    </span>
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                {{-- Dropdown Menu --}}
                                <div
                                    x-show="open"
                                    x-transition
                                    class="absolute z-10 mt-1 w-full bg-white dark:bg-gray-700 rounded-md shadow-lg border border-gray-200 dark:border-gray-600 max-h-60 overflow-y-auto"
                                >
                                    <template x-for="(colorClass, colorName) in colors" :key="colorName">
                                        <div
                                            @click="selectColor(colorName)"
                                            class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer flex items-center"
                                        >
                                            <span class="w-4 h-4 rounded mr-2" :class="colorClass"></span>
                                            <span x-text="colorName"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            @error('jawaban_preferensi')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Jawaban ini digunakan untuk reset password</p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Footer Actions --}}
            <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 flex items-center justify-end space-x-3 rounded-b-lg">
                <a href="{{ route('mentor.murid.index') }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </a>
                <button 
                    type="submit"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-colors disabled:opacity-50"
                >
                    <i class="fas fa-save mr-2"></i>
                    <span wire:loading.remove wire:target="save">Simpan Perubahan</span>
                    <span wire:loading wire:target="save">
                        <i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>