{{-- resources/views/components/column/murid/actions.blade.php --}}
<div wire:key="action-{{ $murid->murid_id }}" class="flex space-x-2">
    {{-- Tombol Edit --}}
    <a 
        href="{{ route('admin.murid.edit', $murid->murid_id) }}"
        class="inline-flex items-center px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded transition-colors duration-200"
        title="Edit Murid"
    >
        <i class="fas fa-edit mr-1.5"></i>
        Edit
    </a>

    {{-- Tombol Hapus (Livewire Component) --}}
    <livewire:admin.murid.delete-murid :murid="$murid" :wire:key="'delete-' . $murid->murid_id" />
</div>