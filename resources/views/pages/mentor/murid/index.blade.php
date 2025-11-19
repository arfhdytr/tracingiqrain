{{-- resources/views/pages/mentor/murid/index.blade.php --}}
<x-layouts.dashboard title="Daftar Murid">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        
        {{-- Page Header --}}
        <div class="mb-6 bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl text-gray-900 dark:text-white font-black">Daftar Murid</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Kelola murid yang dibimbing</p>
                </div>
                <a href="{{ route('mentor.murid.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white font-bold rounded-xl shadow-lg transition-all duration-200">
                    <i class="fas fa-user-plus mr-2"></i>
                    Tambah Murid
                </a>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6">
                @livewire('mentor.murid.murid-table')
            </div>
        </div>
    </div>
</x-layouts.dashboard>