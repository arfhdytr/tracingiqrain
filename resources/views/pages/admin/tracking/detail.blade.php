{{-- resources/views/pages/admin/tracking/detail.blade.php --}}
<x-layouts.dashboard title="Detail Progres Murid">
    @livewire('admin.tracking.tracking-detail', ['murid' => $murid])
</x-layouts.dashboard>