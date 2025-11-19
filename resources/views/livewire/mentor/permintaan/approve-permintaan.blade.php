{{-- resources/views/livewire/mentor/permintaan/approve-permintaan.blade.php --}}
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

    {{-- Modal Konfirmasi Terima --}}
    <x-dialog-modal wire:model="confirmApprove">
        <x-slot name="title">
            <div class="flex items-center">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10 mr-3">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
                <span>Terima Permintaan Bimbingan</span>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Apakah Anda yakin ingin menerima permintaan bimbingan dari murid ini?
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

                {{-- Success Info --}}
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-800 dark:text-green-200">
                                Setelah diterima, murid ini menjadi murid Anda dan dapat akses materi pembelajaran.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmApprove', false)" wire:loading.attr="disabled">
                <i class="fas fa-times mr-2"></i>
                Batal
            </x-secondary-button>

            <button
                wire:click="approve"
                wire:loading.attr="disabled"
                type="button"
                class="ms-3 inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
                <i class="fas fa-check mr-2"></i>
                <span wire:loading.remove wire:target="approve">Ya, Terima Murid</span>
                <span wire:loading wire:target="approve">
                    <i class="fas fa-spinner fa-spin mr-2"></i>Menerima...
                </span>
            </button>
        </x-slot>
    </x-dialog-modal>
</div>