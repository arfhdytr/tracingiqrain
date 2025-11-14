<div class="flex gap-2">
    @if($row->status_approval === 'pending')
        <button 
            wire:click="$emit('confirmApprove', {{ $row->mentor_id }})"
            class="bg-pink-400 hover:bg-pink-500 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Terima
        </button>
        
        <button 
            wire:click="$emit('showRejectModal', {{ $row->mentor_id }}, '{{ $row->nama_lengkap }}')"
            class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-300 px-4 py-2 rounded-lg transition">
            Tolak
        </button>
    @elseif($row->status_approval === 'approved')
        <span class="text-green-600 font-medium">Disetujui</span>
    @else
        <span class="text-red-600 font-medium">Ditolak</span>
    @endif
</div>

@push('scripts')
<script>
    // Konfirmasi approve
    window.addEventListener('confirmApprove', event => {
        const mentorId = event.detail;
        
        Swal.fire({
            title: 'Setujui Mentor?',
            text: 'Mentor ini akan dapat mengakses sistem',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#ec4899',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Setujui',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('approve', mentorId);
            }
        });
    });
</script>
@endpush