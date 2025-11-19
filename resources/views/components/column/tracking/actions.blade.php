{{-- resources/views/components/column/tracking/actions.blade.php --}}
<div wire:key="action-{{ $murid->murid_id }}" class="flex justify-center">
    <a 
        href="{{ route('admin.tracking.detail', $murid->murid_id) }}"
        class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border-2 border-pink-300 dark:border-pink-600 hover:bg-pink-50 dark:hover:bg-pink-900/20 text-pink-600 dark:text-pink-400 text-sm font-medium rounded-lg transition-colors duration-200"
    >
        Lihat detail
    </a>
</div>