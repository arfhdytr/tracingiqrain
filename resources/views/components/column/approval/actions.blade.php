<div wire:key="action-{{ $mentor->mentor_id }}" class="flex space-x-2">
    <livewire:admin.approval.approve-mentor :mentor="$mentor" :wire:key="'approve-' . $mentor->mentor_id" />
    <livewire:admin.approval.reject-mentor :mentor="$mentor" :wire:key="'reject-' . $mentor->mentor_id" />
</div>