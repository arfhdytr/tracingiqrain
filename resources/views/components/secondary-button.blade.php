<button {{ $attributes->merge(['type' => 'button', 'class' => 'px-4 py-2 btn bg-white dark:bg-gray-800 border-black dark:border-gray-700/60 hover:border-gray-300 dark:hover:border-gray-600 text-gray-800 dark:text-gray-300']) }}>
    {{ $slot }}
</button>
