<div>
    {{-- Tombol "Tolak" --}}
    <button 
        wire:click="confirmRejection"
        type="button"
        class="inline-flex items-center px-3 py-1.5 bg-white dark:bg-gray-800 border border-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 text-red-500 text-xs font-medium rounded transition-colors duration-200"
        wire:loading.attr="disabled"
    >
        <i class="fas fa-times mr-1.5"></i>
        <span wire:loading.remove wire:target="confirmRejection">Tolak</span>
        <span wire:loading wire:target="confirmRejection">Loading...</span>
    </button>
 
    <x-dialog-modal wire:model="confirmReject">
        <x-slot name="title">
            <div class="flex items-center">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10 mr-3">
                    <i class="fas fa-times text-red-600"></i>
                </div>
                <span>Tolak Mentor</span>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Apakah Anda yakin ingin menolak pendaftaran mentor ini?
                </p>
                
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <dl class="space-y-2">
                        <div class="flex justify-between">
                            <dt class="font-medium text-sm">Nama:</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $mentor->nama_lengkap }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-medium text-sm">Email:</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $mentor->email }}</dd>
                        </div>
                    </dl>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Alasan Penolakan (Opsional)
                    </label>
                    <textarea 
                        wire:model.live="reason"
                        rows="3"
                        class="shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md"
                        placeholder="Masukkan alasan penolakan..."
                    ></textarea>
                    <x-input-error for="reason" class="mt-2" />
                    
                    @if($reason)
                        <p class="mt-1 text-xs text-gray-500">
                            {{ strlen($reason) }}/500 karakter
                        </p>
                    @endif
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmReject', false)" wire:loading.attr="disabled">
                Batal
            </x-secondary-button>

            <button
                wire:click="reject"
                wire:loading.attr="disabled"
                type="button"
                class="ms-3 inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
                <i class="fas fa-times mr-2"></i>
                <span wire:loading.remove wire:target="reject">Ya, Tolak</span>
                <span wire:loading wire:target="reject">Processing...</span>
            </button>
        </x-slot>
    </x-dialog-modal>
</div>