{{-- resources/views/components/column/video/actions.blade.php --}}
<div wire:key="action-{{ $video->video_id }}" class="flex space-x-2">
    {{-- Tombol View --}}
    <a 
        href="{{ route('admin.video.view', $video->video_id) }}"
        class="inline-flex items-center px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-medium rounded transition-colors duration-200"
        title="Lihat Video"
    >
        <i class="fas fa-eye mr-1.5"></i>
        Lihat
    </a>

    {{-- Tombol Edit --}}
    <a 
        href="{{ route('admin.video.edit', $video->video_id) }}"
        class="inline-flex items-center px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded transition-colors duration-200"
        title="Edit Video"
    >
        <i class="fas fa-edit mr-1.5"></i>
        Edit
    </a>

    {{-- Tombol Hapus (Livewire Component) --}}
    <livewire:admin.video.delete-video :video="$video" :wire:key="'delete-' . $video->video_id" />
</div>