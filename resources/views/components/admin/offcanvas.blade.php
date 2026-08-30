@props(['name', 'show' => false, 'title' => 'Filters', 'width' => 'w-full sm:w-96'])

<div
    x-data="{ show: @js($show) }"
    x-show="show"
    x-on:open-offcanvas.window="$event.detail.name === '{{ $name }}' ? show = true : null"
    x-on:close-offcanvas.window="(! $event.detail || $event.detail.name === '{{ $name }}') ? show = false : null"
    x-on:keydown.escape.window="show = false"
    x-cloak
    class="fixed inset-0 z-50"
>
    <div x-show="show" x-transition.opacity @click="show = false" class="fixed inset-0 bg-gray-900/50"></div>

    <div
        x-show="show"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="translate-y-full sm:translate-y-0 sm:translate-x-full"
        x-transition:enter-end="translate-y-0 sm:translate-x-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="translate-y-0 sm:translate-x-0"
        x-transition:leave-end="translate-y-full sm:translate-y-0 sm:translate-x-full"
        class="fixed inset-x-0 bottom-0 sm:inset-y-0 sm:right-0 sm:left-auto {{ $width }} max-h-[85vh] sm:max-h-none bg-white rounded-t-2xl sm:rounded-none shadow-xl flex flex-col"
    >
        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200 shrink-0">
            <h3 class="font-semibold text-gray-900">{{ $title }}</h3>
            <button @click="show = false" class="p-1 rounded-md text-gray-500 hover:bg-gray-100 cursor-pointer">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="flex-1 overflow-y-auto p-4">
            {{ $slot }}
        </div>
    </div>
</div>
