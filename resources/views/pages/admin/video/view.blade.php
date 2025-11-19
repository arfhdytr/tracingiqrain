{{-- resources/views/pages/admin/video/view.blade.php --}}
<x-layouts.dashboard title="Lihat Video">
    @livewire('admin.video.view-video', ['video' => $video])
</x-layouts.dashboard>