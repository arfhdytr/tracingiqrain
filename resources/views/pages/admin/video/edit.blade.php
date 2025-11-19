{{-- resources/views/pages/admin/video/edit.blade.php --}}
<x-layouts.dashboard title="Edit Video">
    @livewire('admin.video.edit-video', ['video' => $video])
</x-layouts.dashboard>