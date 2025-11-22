{{-- resources/views/components/app/header.blade.php --}}
<header class="sticky top-0 before:absolute before:inset-0 before:backdrop-blur-md max-lg:before:bg-white/90 dark:max-lg:before:bg-gray-800/90 before:-z-10 z-30 border-b border-gray-200 dark:border-gray-700/60">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-18">

            {{-- Hamburger button (Mobile) --}}
            <div class="flex lg:hidden">
                <button
                    class="text-gray-500 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-200"
                    @click.stop="sidebarOpen = !sidebarOpen"
                    aria-controls="sidebar"
                    :aria-expanded="sidebarOpen"
                >
                    <span class="sr-only">Open sidebar</span>
                    <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <rect y="4" width="24" height="2" rx="1" />
                        <rect y="11" width="24" height="2" rx="1" />
                        <rect y="18" width="24" height="2" rx="1" />
                    </svg>
                </button>
            </div>

            {{-- Header: Left side (Desktop) --}}
            <div class="flex items-center flex-1 lg:flex-initial">
                {{-- Add your left content here --}}
            </div>

            {{-- Header: Right side --}}
            <div class="flex items-center space-x-3">

                {{-- Notifications --}}
                @livewire('notifications.notification-dropdown')

                {{-- Dark mode toggle --}}
                {{-- <x-theme-toggle /> --}}

                {{-- Divider --}}
                <hr class="w-px h-6 bg-gray-200 dark:bg-gray-700/60 border-none" />

                {{-- User button --}}
                <x-dropdown-profile align="right" />
                
            </div>

        </div>
    </div>
</header>