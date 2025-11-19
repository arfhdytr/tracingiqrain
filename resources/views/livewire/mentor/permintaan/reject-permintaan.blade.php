{{-- resources/views/livewire/mentor/permintaan/reject-permintaan.blade.php --}}
<div>
    {{-- Tombol "Tolak" --}}
    <button 
        wire:click="confirmRejection"
        type="button"
        class="inline-flex items-center px-3 py-1.5 bg-white dark:bg-gray-700 border-2 border-red-300 dark:border-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 text-red-600 dark:text-red-400 text-xs font-medium rounded transition-colors duration-200"
        wire:loading.attr="disabled"
    >
        <span wire:loading.remove wire:target="confirmRejection">Tolak</span>
        <span wire:loading wire:target="confirmRejection">Loading...</span>
    </button>

    {{-- Modal Konfirmasi Tolak --}}
    <x-dialog-modal wire:model="confirmReject">
        <x-slot name="title">
            <div class="flex items-center">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10 mr-3">
                    <i class="fas fa-times-circle text-red-600"></i>
                </div>
                <span>Tolak Permintaan Bimbingan</span>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Apakah Anda yakin ingin menolak permintaan bimbingan dari murid ini?
                </p>
                
                {{-- Info Murid --}}
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <dl class="space-y-2">
                        <div class="flex justify-between">
                            <dt class="font-medium text-sm text-gray-700 dark:text-gray-300">Nama:</dt>
                            <dd class="text-sm text-gray-900 dark:text-white font-semibold">
                                {{ $permintaan->murid->user->username ?? '-' }}
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-medium text-sm text-gray-700 dark:text-gray-300">Email:</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">
                                {{ ($permintaan->murid->user->username ?? 'murid') . '@gmail.com' }}
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-medium text-sm text-gray-700 dark:text-gray-300">Sekolah:</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">
                                {{ $permintaan->murid->sekolah ?: 'Tidak ada' }}
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-medium text-sm text-gray-700 dark:text-gray-300">Waktu Permintaan:</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">
                                {{ $permintaan->waktu_permintaan }}
                            </dd>
                        </div>
                    </dl>
                </div>

                {{-- Catatan Penolakan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Catatan Penolakan (Opsional)
                    </label>
                    <textarea 
                        wire:model="catatan"
                        rows="3"
                        class="shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md"
                        placeholder="Berikan alasan penolakan (opsional)"
                    ></textarea>
                    <p class="mt-1 text-xs text-gray-500">Maksimal 500 karakter</p>
                </div>

                {{-- Warning Info --}}
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-800 dark:text-red-200">
                                Setelah ditolak, murid dapat memilih mentor lain.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmReject', false)" wire:loading.attr="disabled">
                <i class="fas fa-times mr-2"></i>
                Batal
            </x-secondary-button>

            <button
                wire:click="reject"
                wire:loading.attr="disabled"
                type="button"
                class="ms-3 inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
                <i class="fas fa-times mr-2"></i>
                <span wire:loading.remove wire:target="reject">Ya, Tolak Permintaan</span>
                <span wire:loading wire:target="reject">
                    <i class="fas fa-spinner fa-spin mr-2"></i>Menolak...
                </span>
            </button>
        </x-slot>
    </x-dialog-modal>
</div>