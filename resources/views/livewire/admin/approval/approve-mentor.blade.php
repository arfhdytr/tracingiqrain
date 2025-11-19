<div>
    {{-- Tombol "Terima" --}}
    <button 
        wire:click="confirmApproval"
        type="button"
        class="inline-flex items-center px-3 py-1.5 bg-pink-500 hover:bg-pink-600 text-white text-xs font-medium rounded transition-colors duration-200"
        wire:loading.attr="disabled"
    >
        <i class="fas fa-check mr-1.5"></i>
        <span wire:loading.remove wire:target="confirmApproval">Terima</span>
        <span wire:loading wire:target="confirmApproval">Loading...</span>
    </button>

    {{-- ✅ Gunakan Jetstream Dialog Modal --}}
    <x-dialog-modal wire:model="confirmApprove">
        <x-slot name="title">
            <div class="flex items-center">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10 mr-3">
                    <i class="fas fa-check text-green-600"></i>
                </div>
                <span>Setujui Mentor</span>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="text-sm text-gray-600 dark:text-gray-400">
                <p class="mb-3">Apakah Anda yakin ingin menyetujui pendaftaran mentor ini?</p>
                
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <dl class="space-y-2">
                        <div class="flex justify-between">
                            <dt class="font-medium">Nama:</dt>
                            <dd class="text-gray-900 dark:text-white">{{ $mentor->nama_lengkap }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-medium">Email:</dt>
                            <dd class="text-gray-900 dark:text-white">{{ $mentor->email }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmApprove', false)" wire:loading.attr="disabled">
                Batal
            </x-secondary-button>

            <button
                wire:click="approve"
                wire:loading.attr="disabled"
                type="button"
                class="ms-3 inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
                <i class="fas fa-check mr-2"></i>
                <span wire:loading.remove wire:target="approve">Ya, Setujui</span>
                <span wire:loading wire:target="approve">Processing...</span>
            </button>
        </x-slot>
    </x-dialog-modal>
</div>