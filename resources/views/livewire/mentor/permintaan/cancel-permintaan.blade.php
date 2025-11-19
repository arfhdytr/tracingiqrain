{{-- resources/views/livewire/mentor/permintaan/cancel-permintaan.blade.php --}}
<div>
    {{-- Tombol "Batalkan" --}}
    <button 
        wire:click="confirmCancellation"
        type="button"
        class="inline-flex items-center px-3 py-1.5 bg-gray-500 hover:bg-gray-600 text-white text-xs font-medium rounded transition-colors duration-200"
        wire:loading.attr="disabled"
    >
        <i class="fas fa-undo mr-1.5"></i>
        <span wire:loading.remove wire:target="confirmCancellation">Batalkan</span>
        <span wire:loading wire:target="confirmCancellation">Loading...</span>
    </button>

    {{-- Modal Konfirmasi Batalkan --}}
    <x-dialog-modal wire:model="confirmCancel">
        <x-slot name="title">
            <div class="flex items-center">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-gray-100 sm:mx-0 sm:h-10 sm:w-10 mr-3">
                    <i class="fas fa-undo text-gray-600"></i>
                </div>
                <span>Batalkan Keputusan</span>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Apakah Anda yakin ingin membatalkan keputusan 
                    <strong class="{{ $permintaan->status === 'approved' ? 'text-green-600' : 'text-red-600' }}">
                        {{ $permintaan->status === 'approved' ? 'penerimaan' : 'penolakan' }}
                    </strong> 
                    untuk permintaan ini?
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
                            <dt class="font-medium text-sm text-gray-700 dark:text-gray-300">Status Saat Ini:</dt>
                            <dd class="text-sm">
                                @if($permintaan->status === 'approved')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Diterima
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Ditolak
                                    </span>
                                @endif
                            </dd>
                        </div>
                        @if($permintaan->tanggal_respons)
                            <div class="flex justify-between">
                                <dt class="font-medium text-sm text-gray-700 dark:text-gray-300">Tanggal Keputusan:</dt>
                                <dd class="text-sm text-gray-900 dark:text-white">
                                    {{ $permintaan->tanggal_respons->format('d M Y, H:i') }}
                                </dd>
                            </div>
                        @endif
                        @if($permintaan->catatan)
                            <div class="pt-2 border-t border-gray-200 dark:border-gray-600">
                                <dt class="font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Catatan:</dt>
                                <dd class="text-sm text-gray-900 dark:text-white italic">
                                    "{{ $permintaan->catatan }}"
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>

                {{-- Info Pembatalan --}}
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200 mb-1">
                                Yang akan terjadi:
                            </h3>
                            <ul class="text-sm text-blue-700 dark:text-blue-300 list-disc list-inside space-y-1">
                                <li>Status permintaan kembali ke <strong>Menunggu</strong></li>
                                @if($permintaan->status === 'approved')
                                    <li>Murid akan dikeluarkan dari daftar bimbingan Anda</li>
                                @endif
                                <li>Anda dapat memproses ulang permintaan ini</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmCancel', false)" wire:loading.attr="disabled">
                <i class="fas fa-times mr-2"></i>
                Batal
            </x-secondary-button>

            <button
                wire:click="cancel"
                wire:loading.attr="disabled"
                type="button"
                class="ms-3 inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
                <i class="fas fa-undo mr-2"></i>
                <span wire:loading.remove wire:target="cancel">Ya, Batalkan Keputusan</span>
                <span wire:loading wire:target="cancel">
                    <i class="fas fa-spinner fa-spin mr-2"></i>Membatalkan...
                </span>
            </button>
        </x-slot>
    </x-dialog-modal>
</div>