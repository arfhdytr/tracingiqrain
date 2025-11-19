{{-- resources/views/pages/mentor/permintaan/index.blade.php --}}
<x-layouts.dashboard title="Permintaan Bimbingan">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        
        {{-- Page Header --}}
        <div class="mb-6 bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
            <div>
                <h1 class="text-3xl text-gray-900 dark:text-white font-black">Permintaan Bimbingan</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Murid yang ingin bergabung ke kelas Anda</p>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6">
                @livewire('mentor.permintaan.permintaan-table')
            </div>
        </div>
    </div>
</x-layouts.dashboard>