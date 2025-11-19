{{-- resources/views/pages/mentor/laporan-murid/index.blade.php --}}
<x-layouts.dashboard title="Laporan Murid">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        
        {{-- Header --}}
        <div class="mb-6 bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
            <div>
                <h1 class="text-3xl text-gray-900 dark:text-white font-black">Progres Murid</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Lihat perkembangan murid yang dibimbing</p>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6">
                @livewire('mentor.laporan-murid.laporan-murid-table')
            </div>
        </div>
    </div>
</x-layouts.dashboard>