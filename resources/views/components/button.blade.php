<button {{ $attributes->merge(['type' => 'submit', 'class' => 'px-4 py-2 bg-pink-500 text-white hover:bg-pink-600 whitespace-nowrap rounded cursor-pointer']) }}>
    {{ $slot }}
</button>