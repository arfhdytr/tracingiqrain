{{-- resources/views/livewire/notifications/notification-dropdown.blade.php --}}
<div class="relative inline-flex" x-data="{ open: false }">
    <button
        class="w-8 h-8 flex items-center justify-center hover:bg-gray-100 lg:hover:bg-gray-200 dark:hover:bg-gray-700/50 dark:lg:hover:bg-gray-800 rounded-full relative"
        :class="{ 'bg-gray-200 dark:bg-gray-800': open }"
        aria-haspopup="true"
        @click.prevent="
            open = !open; 
            if (open && !{{ $isLoaded ? 'true' : 'false' }}) {
                $wire.loadNotifications()
            }
        "
        :aria-expanded="open"
    >
        <span class="sr-only">Notifications</span>
        <svg class="fill-current text-gray-500/80 dark:text-gray-400/80" width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
            <path d="M6.5 0C2.91 0 0 2.462 0 5.5c0 1.075.37 2.074 1 2.922V12l2.699-1.542A7.454 7.454 0 0 0 6.5 11c3.59 0 6.5-2.462 6.5-5.5S10.09 0 6.5 0Z"/>
            <path d="M16 9.5c0-.987-.429-1.897-1.147-2.639C14.124 10.348 10.66 13 6.5 13c-.103 0-.202-.018-.305-.021C7.231 13.617 8.556 14 10 14c.449 0 .886-.04 1.307-.11L15 16v-4h-.012C15.627 11.285 16 10.425 16 9.5Z"/>
        </svg>
        
        @if($unreadCount > 0)
            <div class="absolute top-0 right-0 w-5 h-5 bg-pink-500 border-2 border-white dark:border-gray-900 rounded-full flex items-center justify-center">
                <span class="text-[10px] font-bold text-white">{{ $unreadCount }}</span>
            </div>
        @endif
    </button>
    
    <div
        class="origin-top-right z-50 absolute top-full min-w-80 !bg-white dark:!bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-xl shadow-2xl overflow-hidden mt-2 right-0 sm:right-0"
        @click.outside="open = false; $wire.markAsRead()"
        @keydown.escape.window="open = false"
        x-show="open"
        x-transition:enter="transition ease-out duration-200 transform"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-out duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-cloak
    >
        {{-- Header dengan Refresh Button --}}
        <div class="flex items-center justify-between text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase pt-2 pb-2 px-4 !bg-white dark:!bg-gray-800 border-b border-gray-100 dark:border-gray-700">
            <span>Notifikasi</span>
            <button 
                wire:click="refreshNotifications"
                class="text-pink-500 hover:text-pink-600 normal-case text-xs"
                title="Refresh"
            >
                <i class="fas fa-sync-alt" wire:loading.class="fa-spin" wire:target="refreshNotifications"></i>
            </button>
        </div>
        
        {{-- Content --}}
        <div class="!bg-white dark:!bg-gray-800">
            {{-- Loading State --}}
            <div wire:loading wire:target="loadNotifications" class="py-12 px-4 text-center flex flex-col items-center">
                <div class="animate-spin block w-8 h-8 border-4 border-current border-t-transparent text-pink-500 rounded-full mb-2 mx-auto" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Memuat notifikasi...</p>
            </div>

            {{-- Loaded State --}}
            <div wire:loading.remove wire:target="loadNotifications">
                @if(count($notifications) > 0)
                    <ul>
                        @foreach($notifications as $notification)
                            <li class="border-b border-gray-100 dark:border-gray-700 last:border-0">
                                <a 
                                    class="block py-3 px-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150" 
                                    href="{{ $notification['url'] }}" 
                                    @click="open = false"
                                    @focus="open = true" 
                                    @focusout="open = false"
                                >
                                    <span class="block text-sm mb-2">
                                        <span class="text-lg mr-1">{{ $notification['icon'] }}</span>
                                        <span class="font-semibold text-gray-900 dark:text-white">{{ $notification['title'] }}</span>
                                        <span class="text-gray-700 dark:text-gray-300">: {{ $notification['message'] }}</span>
                                    </span>
                                    <span class="block text-xs font-medium text-gray-400 dark:text-gray-500">
                                        {{ \Carbon\Carbon::parse($notification['time'])->diffForHumans() }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="py-8 px-4 text-center">
                        <div class="text-4xl mb-2">🔔</div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada notifikasi baru</p>
                    </div>
                @endif
            </div>
        </div>
        
        {{-- Footer --}}
        @if(count($notifications) > 0)
            <div class="border-t border-gray-100 dark:border-gray-700 !bg-white dark:!bg-gray-800">
                <a 
                    href="{{ Auth::user()->hasRole('mentor') ? route('mentor.dashboard') : route('admin.dashboard') }}" 
                    class="block text-center text-xs font-semibold text-pink-500 hover:text-pink-600 dark:text-pink-400 dark:hover:text-pink-300 py-3"
                    @click="open = false"
                >
                    Lihat Semua Aktivitas
                </a>
            </div>
        @endif
    </div>
</div>