@props(['mentor'])

<div class="flex items-center space-x-2">
    {{-- Panggil komponen ApproveModal untuk mentor ini --}}
    <livewire:admin.approval.approve-modal :mentor="$mentor" :wire:key="'approve-' . $mentor->mentor_id" />

    {{-- Panggil komponen RejectModal untuk mentor ini --}}
    <livewire:admin.approval.reject-modal :mentor="$mentor" :wire:key="'reject-' . $mentor->mentor_id" />
</div>