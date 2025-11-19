{{-- resources/views/components/column/mentor/permintaan/actions.blade.php --}}
<div wire:key="action-{{ $permintaan->permintaan_id }}" class="flex space-x-2">
    @if($permintaan->status === 'pending')
        {{-- Tombol Terima & Tolak untuk status pending --}}
        <livewire:mentor.permintaan.approve-permintaan :permintaan="$permintaan" :wire:key="'approve-' . $permintaan->permintaan_id" />
        <livewire:mentor.permintaan.reject-permintaan :permintaan="$permintaan" :wire:key="'reject-' . $permintaan->permintaan_id" />
    @else
        {{-- Tombol Batalkan untuk status approved atau rejected --}}
        <livewire:mentor.permintaan.cancel-permintaan :permintaan="$permintaan" :wire:key="'cancel-' . $permintaan->permintaan_id" />
    @endif
</div>