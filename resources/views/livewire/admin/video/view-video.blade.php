{{-- resources/views/livewire/admin/video/view-video.blade.php --}}
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-6xl mx-auto">
    
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center justify-between gap-3 mb-2">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.video.index') }}" 
                   class="text-gray-400 hover:text-white transition-colors">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="text-3xl text-white font-bold">{{ $video->judul_video }}</h1>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.video.edit', $video->video_id) }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Video
                </a>
            </div>
        </div>
        <div class="flex items-center gap-3 text-gray-400">
            <span class="inline-flex items-center">
                <i class="fas fa-layer-group mr-2"></i>
                {{ $video->tingkatanIqra->nama_tingkatan }}
            </span>
            <span>•</span>
            <span class="inline-flex items-center">
                <i class="fas fa-calendar mr-2"></i>
                {{ $video->created_at->format('d M Y, H:i') }}
            </span>
        </div>
    </div>

    {{-- Video Player Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden mb-6">
        <div class="aspect-video bg-black">
            @if($this->videoUrl)
                <video 
                    controls 
                    class="w-full h-full"
                    controlsList="nodownload"
                >
                    <source src="{{ $this->videoUrl }}" type="video/mp4">
                    
                    @if($this->subtitleUrl)
                        <track 
                            label="Indonesian" 
                            kind="subtitles" 
                            srclang="id" 
                            src="{{ $this->subtitleUrl }}" 
                            default
                        >
                    @endif
                    
                    Browser Anda tidak mendukung pemutar video.
                </video>
            @else
                <div class="flex items-center justify-center h-full">
                    <div class="text-center text-white">
                        <i class="fas fa-exclamation-triangle text-6xl mb-4 opacity-50"></i>
                        <p class="text-lg">Video tidak ditemukan</p>
                        <p class="text-sm text-gray-400 mt-2">{{ $video->video_path }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Video Info Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
            <i class="fas fa-info-circle text-pink-500 mr-2"></i>
            Informasi Video
        </h3>

        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Judul Video</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white font-semibold">
                    {{ $video->judul_video }}
                </dd>
            </div>

            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tingkatan</dt>
                <dd class="mt-1">
                    @php
                        $colors = [
                            1 => 'bg-red-100 text-red-800',
                            2 => 'bg-orange-100 text-orange-800',
                            3 => 'bg-yellow-100 text-yellow-800',
                            4 => 'bg-green-100 text-green-800',
                            5 => 'bg-blue-100 text-blue-800',
                            6 => 'bg-purple-100 text-purple-800',
                        ];
                        $colorClass = $colors[$video->tingkatanIqra->level] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $colorClass }}">
                        {{ $video->tingkatanIqra->nama_tingkatan }}
                    </span>
                </dd>
            </div>

            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Ukuran File</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                    <i class="fas fa-file-video mr-1 text-pink-500"></i>
                    {{ $this->fileSize }}
                </dd>
            </div>

            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Subtitle</dt>
                <dd class="mt-1">
                    @if($video->subtitle_path && Storage::disk('public')->exists($video->subtitle_path))
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i>
                            Tersedia
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                            <i class="fas fa-times-circle mr-1"></i>
                            Tidak ada
                        </span>
                    @endif
                </dd>
            </div>

            <div class="md:col-span-2">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Deskripsi</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                    {{ $video->deskripsi ?: 'Tidak ada deskripsi' }}
                </dd>
            </div>

            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Ditambahkan</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                    {{ $video->created_at->format('d M Y, H:i') }}
                </dd>
            </div>

            <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Terakhir Diupdate</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                    {{ $video->updated_at->format('d M Y, H:i') }}
                </dd>
            </div>
        </dl>
    </div>

    {{-- Download Section --}}
    @if($this->videoUrl || $this->subtitleUrl)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                <i class="fas fa-download text-pink-500 mr-2"></i>
                Download File
            </h3>

            <div class="flex flex-wrap gap-3">
                @if($this->videoUrl)
                    <button
                        wire:click="downloadVideo"
                        class="inline-flex items-center px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white font-medium rounded-lg transition-colors duration-200"
                    >
                        <i class="fas fa-file-video mr-2"></i>
                        Download Video
                    </button>
                @endif

                @if($this->subtitleUrl)
                    <button
                        wire:click="downloadSubtitle"
                        class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg transition-colors duration-200"
                    >
                        <i class="fas fa-closed-captioning mr-2"></i>
                        Download Subtitle
                    </button>
                @endif
            </div>
        </div>
    @endif
</div>