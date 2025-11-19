{{-- resources/views/livewire/admin/murid/delete-murid.blade.php --}}
<div>
    {{-- Tombol "Hapus" --}}
    <button 
        wire:click="confirmDeletion"
        type="button"
        class="inline-flex items-center px-3 py-1.5 bg-white dark:bg-gray-800 border border-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 text-red-500 text-xs font-medium rounded transition-colors duration-200"
        wire:loading.attr="disabled"
    >
        <i class="fas fa-trash-alt mr-1.5"></i>
        <span wire:loading.remove wire:target="confirmDeletion">Hapus</span>
        <span wire:loading wire:target="confirmDeletion">Loading...</span>
    </button>

    {{-- Modal Konfirmasi Hapus --}}
    <x-dialog-modal wire:model="confirmDelete">
        <x-slot name="title">
            <div class="flex items-center">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10 mr-3">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <span>Hapus Murid</span>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Apakah Anda yakin ingin menghapus murid ini? Tindakan ini tidak dapat dibatalkan.
                </p>
                
                {{-- Warning Box --}}
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                                Data yang akan dihapus:
                            </h3>
                            <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Akun user dan profil murid</li>
                                    <li>Riwayat permainan game</li>
                                    <li>Progress pembelajaran</li>
                                    <li>Data leaderboard</li>
                                    <li>Preferensi pertanyaan keamanan</li>
                                    <li>Permintaan bimbingan</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Info Murid --}}
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <dl class="space-y-2">
                        <div class="flex justify-between">
                            <dt class="font-medium text-sm text-gray-700 dark:text-gray-300">Username:</dt>
                            <dd class="text-sm text-gray-900 dark:text-white font-semibold">
                                {{ $murid->user->username ?? '-' }}
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-medium text-sm text-gray-700 dark:text-gray-300">Sekolah:</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">
                                {{ $murid->sekolah ?: 'Belum diisi' }}
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-medium text-sm text-gray-700 dark:text-gray-300">Mentor:</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">
                                {{ $murid->mentor->nama_lengkap ?? 'Tidak ada mentor' }}
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-medium text-sm text-gray-700 dark:text-gray-300">Preferensi:</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">
                                {{ $murid->preferensi_terisi ? 'Sudah diisi' : 'Belum diisi' }}
                            </dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-medium text-sm text-gray-700 dark:text-gray-300">Terdaftar:</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">
                                {{ $murid->created_at->format('d M Y, H:i') }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmDelete', false)" wire:loading.attr="disabled">
                <i class="fas fa-times mr-2"></i>
                Batal
            </x-secondary-button>

            <button
                wire:click="delete"
                wire:loading.attr="disabled"
                type="button"
                class="ms-3 inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
                <i class="fas fa-trash-alt mr-2"></i>
                <span wire:loading.remove wire:target="delete">Ya, Hapus Murid</span>
                <span wire:loading wire:target="delete">
                    <i class="fas fa-spinner fa-spin mr-2"></i>Menghapus...
                </span>
            </button>
        </x-slot>
    </x-dialog-modal>
</div>