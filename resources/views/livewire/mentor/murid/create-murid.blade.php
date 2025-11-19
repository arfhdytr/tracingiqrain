{{-- resources/views/livewire/mentor/murid/create-murid.blade.php --}}
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-4xl mx-auto">
    
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('mentor.murid.index') }}" 
               class="text-gray-400 hover:text-white transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl text-white font-bold">Tambah Murid Baru</h1>
        </div>
        <p class="text-gray-400">Tambahkan murid satu per satu atau import dari CSV</p>
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

    {{-- Import Summary --}}
    @if($import_summary)
        <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                <i class="fas fa-chart-bar text-pink-500 mr-2"></i>
                Hasil Import
            </h3>
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 text-center">
                    <div class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $import_summary['success'] }}</div>
                    <div class="text-sm text-green-700 dark:text-green-300 mt-1">Berhasil</div>
                </div>
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 text-center">
                    <div class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $import_summary['failed'] }}</div>
                    <div class="text-sm text-red-700 dark:text-red-300 mt-1">Gagal</div>
                </div>
            </div>

            @if(count($import_summary['errors']) > 0)
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                    <p class="text-sm font-medium text-red-800 dark:text-red-200 mb-2">Error Detail:</p>
                    <ul class="text-xs text-red-700 dark:text-red-300 list-disc list-inside space-y-1 max-h-40 overflow-y-auto">
                        @foreach($import_summary['errors'] as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mt-4 flex justify-end">
                <a href="{{ route('mentor.murid.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-pink-600 hover:bg-pink-700 text-white font-medium rounded-lg transition-colors">
                    <i class="fas fa-check mr-2"></i>
                    Selesai
                </a>
            </div>
        </div>
    @endif

    {{-- Mode Selection --}}
    <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pilih Metode</h3>
        <div class="grid grid-cols-2 gap-4">
            <button 
                wire:click="$set('mode', 'manual')"
                class="p-4 rounded-lg border-2 transition-all duration-200 {{ $mode === 'manual' ? 'border-pink-500 bg-pink-50 dark:bg-pink-900/20' : 'border-gray-300 dark:border-gray-600 hover:border-pink-300' }}"
            >
                <i class="fas fa-user-plus text-3xl {{ $mode === 'manual' ? 'text-pink-500' : 'text-gray-400' }} mb-2"></i>
                <div class="font-medium text-gray-900 dark:text-white">Tambah Manual</div>
                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Satu per satu</div>
            </button>

            <button 
                wire:click="$set('mode', 'csv')"
                class="p-4 rounded-lg border-2 transition-all duration-200 {{ $mode === 'csv' ? 'border-pink-500 bg-pink-50 dark:bg-pink-900/20' : 'border-gray-300 dark:border-gray-600 hover:border-pink-300' }}"
            >
                <i class="fas fa-file-csv text-3xl {{ $mode === 'csv' ? 'text-pink-500' : 'text-gray-400' }} mb-2"></i>
                <div class="font-medium text-gray-900 dark:text-white">Import CSV</div>
                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Banyak sekaligus</div>
            </button>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg">
        <form wire:submit.prevent="save">
            <div class="p-6 space-y-6">
                
                @if($mode === 'manual')
                    {{-- Manual Input Form --}}
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-user text-pink-500 mr-2"></i>
                            Data Murid
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

                            {{-- Password --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="password" 
                                    wire:model.blur="password"
                                    class="shadow-sm focus:ring-pink-500 focus:border-pink-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md @error('password') border-red-500 @enderror"
                                    placeholder="Minimal 6 karakter"
                                >
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

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

                            {{-- Pertanyaan Preferensi (Fixed/Read-only) --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Pertanyaan Keamanan
                                </label>
                                <div class="shadow-sm block w-full sm:text-sm border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-900 text-gray-600 dark:text-gray-400 rounded-md px-3 py-2">
                                    {{ \App\Livewire\Mentor\Murid\CreateMurid::PERTANYAAN_PREFERENSI }}
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Pertanyaan ini tetap dan tidak dapat diubah</p>
                            </div>

                            {{-- Jawaban Preferensi --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Jawaban <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    wire:model.blur="jawaban_preferensi"
                                    class="shadow-sm focus:ring-pink-500 focus:border-pink-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md @error('jawaban_preferensi') border-red-500 @enderror"
                                    placeholder="Contoh: Merah"
                                >
                                @error('jawaban_preferensi')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Jawaban ini digunakan untuk reset password</p>
                            </div>
                        </div>
                    </div>

                @else
                    {{-- CSV Upload Form --}}
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <i class="fas fa-file-csv text-pink-500 mr-2"></i>
                            Import dari CSV
                        </h3>

                        {{-- Download Template Button --}}
                        <div class="mb-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                            <div class="flex items-start">
                                <i class="fas fa-info-circle text-blue-400 mt-0.5 mr-3"></i>
                                <div class="flex-1">
                                    <p class="text-sm text-blue-800 dark:text-blue-200 mb-3">
                                        Download template CSV terlebih dahulu untuk melihat format yang benar
                                    </p>
                                    <a 
                                        href="{{ route('mentor.murid.download-template') }}"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors"
                                    >
                                        <i class="fas fa-download mr-2"></i>
                                        Download Template CSV
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- File Upload --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                File CSV <span class="text-red-500">*</span>
                            </label>
                            
                            <div class="flex items-center gap-3">
                                <label class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 cursor-pointer transition-colors">
                                    <i class="fas fa-upload mr-2"></i>
                                    <span>Pilih File CSV</span>
                                    <input 
                                        type="file" 
                                        wire:model="csv_file"
                                        accept=".csv,.txt"
                                        class="hidden"
                                    >
                                </label>
                                
                                <div wire:loading wire:target="csv_file" class="flex items-center text-pink-600">
                                    <svg class="animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span class="text-sm">Mengupload...</span>
                                </div>
                            </div>

                            @if ($csv_file)
                                <div class="mt-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-3">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center min-w-0 flex-1">
                                            <i class="fas fa-file-csv text-green-600 text-xl mr-3"></i>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-medium text-green-800 dark:text-green-200 truncate">
                                                    {{ $csv_file->getClientOriginalName() }}
                                                </p>
                                                <p class="text-xs text-green-600 dark:text-green-400 mt-0.5">
                                                    {{ number_format($csv_file->getSize() / 1024, 2) }} KB
                                                </p>
                                            </div>
                                        </div>
                                        <button 
                                            type="button"
                                            wire:click="$set('csv_file', null)"
                                            class="ml-3 text-red-600 hover:text-red-800 dark:text-red-400"
                                        >
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif

                            @error('csv_file')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            
                            <p class="mt-1 text-xs text-gray-500">Format: CSV (maksimal 2MB)</p>
                        </div>

                        {{-- Format Info --}}
                        <div class="mt-6 bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Format CSV:</h4>
                            <div class="text-xs text-gray-700 dark:text-gray-300 space-y-1">
                                <p><strong>Kolom 1:</strong> username</p>
                                <p><strong>Kolom 2:</strong> password</p>
                                <p><strong>Kolom 3:</strong> sekolah</p>
                                <p><strong>Kolom 4:</strong> jawaban_preferensi</p>
                            </div>
                            <div class="mt-3 text-xs text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-900/20 p-2 rounded">
                                <strong>Catatan:</strong> Pertanyaan keamanan otomatis "{{ \App\Livewire\Mentor\Murid\CreateMurid::PERTANYAAN_PREFERENSI }}"
                            </div>
                        </div>
                    </div>
                @endif

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
                    wire:target="save, csv_file"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-colors disabled:opacity-50"
                >
                    <i class="fas fa-save mr-2"></i>
                    <span wire:loading.remove wire:target="save">
                        {{ $mode === 'manual' ? 'Simpan Murid' : 'Import CSV' }}
                    </span>
                    <span wire:loading wire:target="save">
                        <i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>