{{-- resources/views/pages/admin/mentor/edit.blade.php --}}
<x-layouts.dashboard title="Edit Mentor">
    @livewire('admin.mentor.edit-mentor', ['mentor' => $mentor])
</x-layouts.dashboard>