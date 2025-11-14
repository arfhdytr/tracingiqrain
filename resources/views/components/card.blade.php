<div class="overflow-hidden">
    <div class="flex justify-between items-center">
        @if (isset($name))
            <h4 class="mb-4 flex-1 text-lg font-semibold text-gray-800 capitalize">
                {{ $name }}
            </h4>
        @endif
        @if (isset($right))
            <div class="mb-4 ">
                {{ $right }}
            </div>
        @endif
    </div>
    <div class="px-4 py-3 mb-8 rounded-md shadow-md bg-primaryPoi25-50 border border-primaryPoi25-200">
        {{ $slot }}
    </div>
</div>
