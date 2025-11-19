{{-- resources/views/livewire/admin/video/create-video.blade.php --}}
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-4xl mx-auto">
    
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('admin.video.index') }}" 
               class="text-gray-400 hover:text-white transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl text-white font-bold">Tambah Video Pembelajaran</h1>
        </div>
        <p class="text-gray-400">Unggah video pembelajaran huruf hijaiyah untuk murid tunarungu</p>
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
                
                {{-- Section: Informasi Video --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-info-circle text-pink-500 mr-2"></i>
                        Informasi Video
                    </h3>
                    <div class="grid grid-cols-1 gap-6">
                        {{-- Tingkatan Iqra --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tingkatan Iqra <span class="text-red-500">*</span>
                            </label>
                            <select 
                                wire:model.live="tingkatan_id"
                                class="shadow-sm focus:ring-pink-500 focus:border-pink-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md @error('tingkatan_id') border-red-500 @enderror"
                            >
                                <option value="">-- Pilih Tingkatan --</option>
                                @foreach($tingkatans as $tingkatan)
                                    <option value="{{ $tingkatan->tingkatan_id }}">
                                        {{ $tingkatan->nama_tingkatan }} - {{ $tingkatan->deskripsi }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tingkatan_id')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Judul Video --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Judul Video <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                wire:model.blur="judul_video"
                                class="shadow-sm focus:ring-pink-500 focus:border-pink-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md @error('judul_video') border-red-500 @enderror"
                                placeholder="Contoh: Pengenalan Huruf Alif"
                            >
                            @error('judul_video')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Deskripsi
                            </label>
                            <textarea 
                                wire:model.blur="deskripsi"
                                rows="3"
                                class="shadow-sm focus:ring-pink-500 focus:border-pink-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md @error('deskripsi') border-red-500 @enderror"
                                placeholder="Deskripsi singkat tentang video ini (opsional)"
                            ></textarea>
                            @error('deskripsi')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="border-gray-200 dark:border-gray-700">

                {{-- Section: Upload File --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                        <i class="fas fa-upload text-pink-500 mr-2"></i>
                        Upload File
                    </h3>

                    {{-- Info Box --}}
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6">
                        <div class="flex">
                            <i class="fas fa-info-circle text-blue-400 mt-0.5"></i>
                            <div class="ml-3">
                                <p class="text-sm text-blue-800 dark:text-blue-200">
                                    <strong>Panduan Upload:</strong>
                                </p>
                                <ul class="mt-2 text-sm text-blue-700 dark:text-blue-300 list-disc list-inside space-y-1">
                                    <li>Format video: MP4, MOV, AVI, atau WMV</li>
                                    <li>Ukuran maksimal video: 100MB</li>
                                    <li>Subtitle bersifat opsional (format: SRT, VTT, atau TXT)</li>
                                    <li>Subtitle sangat dianjurkan untuk murid tunarungu</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        {{-- Upload Video --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                File Video <span class="text-red-500">*</span>
                            </label>
                            
                            {{-- File Input - Perbaikan: tidak full width --}}
                            <div class="flex items-center gap-3">
                                <label class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 cursor-pointer transition-colors">
                                    <i class="fas fa-upload mr-2"></i>
                                    <span>Pilih Video</span>
                                    <input 
                                        type="file" 
                                        wire:model="video_file"
                                        accept="video/*"
                                        class="hidden"
                                    >
                                </label>
                                
                                {{-- Loading State --}}
                                <div wire:loading wire:target="video_file" class="flex items-center text-pink-600">
                                    <svg class="animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span class="text-sm">Mengupload...</span>
                                </div>
                            </div>

                            {{-- File Preview --}}
                            @if ($video_file)
                                <div class="mt-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-3">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center min-w-0 flex-1">
                                            <i class="fas fa-file-video text-green-600 text-xl mr-3"></i>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-medium text-green-800 dark:text-green-200 truncate">
                                                    {{ $video_file->getClientOriginalName() }}
                                                </p>
                                                <p class="text-xs text-green-600 dark:text-green-400 mt-0.5">
                                                    {{ number_format($video_file->getSize() / 1024 / 1024, 2) }} MB
                                                </p>
                                            </div>
                                        </div>
                                        <button 
                                            type="button"
                                            wire:click="$set('video_file', null)"
                                            class="ml-3 text-red-600 hover:text-red-800 dark:text-red-400"
                                        >
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif

                            @error('video_file')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            
                            <p class="mt-1 text-xs text-gray-500">MP4, MOV, AVI, WMV hingga 100MB</p>
                        </div>

                        {{-- Upload Subtitle --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                File Subtitle (Opsional)
                            </label>
                            
                            {{-- File Input - Perbaikan: tidak full width --}}
                            <div class="flex items-center gap-3">
                                <label class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 cursor-pointer transition-colors">
                                    <i class="fas fa-upload mr-2"></i>
                                    <span>Pilih Subtitle</span>
                                    <input 
                                        type="file" 
                                        wire:model="subtitle_file"
                                        accept=".srt,.vtt,.txt"
                                        class="hidden"
                                    >
                                </label>
                                
                                {{-- Loading State --}}
                                <div wire:loading wire:target="subtitle_file" class="flex items-center text-green-600">
                                    <svg class="animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span class="text-sm">Mengupload...</span>
                                </div>
                            </div>

                            {{-- File Preview --}}
                            @if ($subtitle_file)
                                <div class="mt-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-3">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center min-w-0 flex-1">
                                            <i class="fas fa-closed-captioning text-green-600 text-xl mr-3"></i>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-medium text-green-800 dark:text-green-200 truncate">
                                                    {{ $subtitle_file->getClientOriginalName() }}
                                                </p>
                                                <p class="text-xs text-green-600 dark:text-green-400 mt-0.5">
                                                    {{ number_format($subtitle_file->getSize() / 1024, 2) }} KB
                                                </p>
                                            </div>
                                        </div>
                                        <button 
                                            type="button"
                                            wire:click="$set('subtitle_file', null)"
                                            class="ml-3 text-red-600 hover:text-red-800 dark:text-red-400"
                                        >
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif

                            @error('subtitle_file')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            
                            <p class="mt-1 text-xs text-gray-500">SRT, VTT, TXT hingga 2MB</p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Footer Actions --}}
            <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 flex items-center justify-end space-x-3 rounded-b-lg">
                <a href="{{ route('admin.video.index') }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </a>
                <button 
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:target="save, video_file, subtitle_file"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-colors disabled:opacity-50"
                >
                    <i class="fas fa-save mr-2"></i>
                    <span wire:loading.remove wire:target="save">Simpan Video</span>
                    <span wire:loading wire:target="save">
                        <i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>