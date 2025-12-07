<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Titan+One&family=Mooli&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400..700&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles         

        @rappasoftTableStyles

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

        @stack('styles')

        <script>
            if (localStorage.getItem('dark-mode') === 'false' || !('dark-mode' in localStorage)) {
                document.querySelector('html').classList.remove('dark');
                document.querySelector('html').style.colorScheme = 'light';
            } else {
                document.querySelector('html').classList.add('dark');
                document.querySelector('html').style.colorScheme = 'dark';
            }
        </script>
    </head>
    <body
        class="font-inter antialiased bg-gray-100 dark:bg-gray-900 text-gray-600 dark:text-gray-400"
        :class="{ 'sidebar-expanded': sidebarExpanded }"
        x-data="{ sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebar-expanded') == 'true' }"
        x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebar-expanded', value))"     
    >

        <script>
            if (localStorage.getItem('sidebar-expanded') == 'true') {
                document.querySelector('body').classList.add('sidebar-expanded');
            } else {
                document.querySelector('body').classList.remove('sidebar-expanded');
            }
        </script>

        <div class="flex h-[100dvh] overflow-hidden">

            <x-app.sidebar :variant="$attributes['sidebarVariant']" />

            <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden @if($attributes['background']){{ $attributes['background'] }}@endif" x-ref="contentarea">

                <x-app.header :variant="$attributes['headerVariant']" />

                <main class="grow bg-iqrain-blue">
                    {{ $slot }}
                </main>

            </div>

        </div>

        @livewireScriptConfig

        @rappasoftTableScripts

        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>

        <script>
            // Definisikan Toast global
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            // (A) Listener untuk event Livewire
            // Menangkap event yang di-dispatch dari komponen (misal: 'updated')
            window.addEventListener('updated', event => {
                // Cek jika data ada di event.detail[0] (Livewire 3)
                if (event.detail[0]) {
                    Toast.fire({
                        icon: event.detail[0].icon,        
                        title: event.detail[0].title,      
                        iconColor: event.detail[0].iconColor 
                    });
                }
                // Fallback untuk Livewire 2 atau event non-array
                else if (event.detail.title) {
                    Toast.fire({
                        icon: event.detail.icon,        
                        title: event.detail.title,      
                        iconColor: event.detail.iconColor 
                    });
                }
            });

            // (B) Listener untuk notifikasi Session
            // Menangkap notifikasi dari redirect Controller (non-Livewire)
            @if (session('success'))
                Toast.fire({
                    icon: 'success',
                    title: '{{ session('success') }}'
                });
            @endif

            @if (session('error'))
                Swal.fire({ // Untuk error, lebih baik non-toast agar dibaca
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}'
                });
            @endif

            @if (session('info'))
                Toast.fire({
                    icon: 'info',
                    title: '{{ session('info') }}'
                });
            @endif
        </script>

        @stack('scripts')
    </body>
</html>