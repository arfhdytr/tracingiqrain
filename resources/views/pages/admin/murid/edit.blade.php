{{-- resources/views/pages/admin/murid/edit.blade.php --}}
<x-layouts.dashboard title="Edit Murid">
    @livewire('admin.murid.edit-murid', ['murid' => $murid])
</x-layouts.dashboard>