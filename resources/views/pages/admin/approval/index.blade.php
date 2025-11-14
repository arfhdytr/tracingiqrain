<x-layouts.dashboard title="Persetujuan Mentor">
    <x-card name="Persetujuan Mentor">
        @slot('subtitle')
            Review dan Setujui Pendaftaran Mentor baru
        @endslot
        
        @livewire('admin.approval.approval-table')
    </x-card>
</x-layouts.dashboard>