{{-- resources/views/components/column/mentor/murid/actions.blade.php --}}
<div wire:key="action-{{ $murid->murid_id }}" class="flex space-x-2">
    {{-- Tombol Edit --}}
    <a 
        href="{{ route('mentor.murid.edit', $murid->murid_id) }}"
        class="inline-flex items-center px-3 py-1.5 bg-white dark:bg-gray-700 border-2 border-pink-300 dark:border-pink-600 hover:bg-pink-50 dark:hover:bg-pink-900/20 text-pink-600 dark:text-pink-400 text-xs font-medium rounded transition-colors duration-200"
        title="Edit Murid"
    >
        <i class="fas fa-edit mr-1.5"></i>
        Edit
    </a>

    {{-- Tombol Hapus (Livewire Component) --}}
    <livewire:mentor.murid.delete-murid :murid="$murid" :wire:key="'delete-' . $murid->murid_id" />
</div>