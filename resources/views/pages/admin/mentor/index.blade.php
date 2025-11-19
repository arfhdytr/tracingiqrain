{{-- resources/views/pages/admin/mentor/index.blade.php --}}
<x-layouts.dashboard title="Kelola Mentor">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        
        {{-- Page Header --}}
        <div class="mb-4 flex justify-between items-center">
            <div>
                <h1 class="text-3xl text-white font-bold">Kelola Mentor</h1>
                <p class="text-gray-400 mt-1">Manajemen data mentor IQRAIN</p>
            </div>
            <a href="{{ route('admin.mentor.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-pink-500 hover:bg-pink-600 text-white font-medium rounded-lg transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                Tambah Mentor
            </a>
        </div>

        {{-- Table Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <div class="p-6">
                @livewire('admin.mentor.mentor-table')
            </div>
        </div>
    </div>
</x-layouts.dashboard>