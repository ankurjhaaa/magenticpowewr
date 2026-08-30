@props(['routeName' => null])

@php
    $exists = $routeName && \Illuminate\Support\Facades\Route::has($routeName);
    $href = $exists ? route($routeName) : '#';
    $active = $exists && request()->routeIs($routeName.'*');
@endphp

<a
    href="{{ $href }}"
    @if (! $exists) aria-disabled="true" @endif
    {{ $attributes->merge([
        'class' => 'flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold transition '
            . ($active
                ? 'bg-gray-900 text-white'
                : ($exists ? 'text-gray-900 hover:bg-gray-50' : 'text-gray-400 cursor-not-allowed')),
    ]) }}
>
    @isset($icon)
        <span class="shrink-0 [&>svg]:w-5 [&>svg]:h-5">{{ $icon }}</span>
    @endisset
    <span class="truncate">{{ $slot }}</span>
</a>
