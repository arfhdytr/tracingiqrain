{{-- resources/views/pages/admin/tracking/index.blade.php --}}
<x-layouts.dashboard title="Log Aktivitas Murid">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        
        {{-- Header Banner --}}
        <div class="mb-6 bg-gradient-to-r from-pink-400 to-pink-500 rounded-2xl shadow-lg p-8 text-center">
            <h1 class="text-4xl text-white font-black mb-2">Log Aktivitas Murid</h1>
            <p class="text-white text-lg opacity-90">Melihat semua kegiatan yang dilakukan murid secara keseluruhan</p>
        </div>

        {{-- Progress Murid Section --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6">
                @livewire('admin.tracking.tracking-table')
            </div>
        </div>
    </div>
</x-layouts.dashboard>