@props(['name', 'show' => false, 'maxWidth' => 'md'])

@php
    $maxWidthClass = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
    ][$maxWidth] ?? 'sm:max-w-md';
@endphp

<div
    x-data="{ show: @js($show) }"
    x-show="show"
    x-on:open-modal.window="$event.detail.name === '{{ $name }}' ? show = true : null"
    x-on:close-modal.window="(! $event.detail || $event.detail.name === '{{ $name }}') ? show = false : null"
    x-on:keydown.escape.window="show = false"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
>
    <div x-show="show" x-transition.opacity @click="show = false" class="fixed inset-0 bg-gray-900/50"></div>

    <div
        x-show="show"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative w-full {{ $maxWidthClass }} bg-white rounded-xl shadow-xl p-6"
    >
        {{ $slot }}
    </div>
</div>
