{{-- resources/views/components/column/mentor/actions.blade.php --}}
<div wire:key="action-{{ $mentor->mentor_id }}" class="flex space-x-2">
    {{-- Tombol Edit --}}
    <a 
        href="{{ route('admin.mentor.edit', $mentor->mentor_id) }}"
        class="inline-flex items-center px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded transition-colors duration-200"
        title="Edit Mentor"
    >
        <i class="fas fa-edit mr-1.5"></i>
        Edit
    </a>

    {{-- Tombol Hapus (Livewire Component) --}}
    <livewire:admin.mentor.delete-mentor :mentor="$mentor" :wire:key="'delete-' . $mentor->mentor_id" />
</div>