@props(['status', 'action'])

@php
    $styles = [
        'new' => 'bg-blue-50 text-blue-700 border-blue-200 focus:ring-blue-500',
        'read' => 'bg-slate-50 text-slate-700 border-slate-200 focus:ring-slate-400',
        'replied' => 'bg-emerald-50 text-emerald-700 border-emerald-200 focus:ring-emerald-500',
        'closed' => 'bg-gray-50 text-gray-500 border-gray-200 focus:ring-gray-400',
    ];

    $chevron = "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%236b7280'><path fill-rule='evenodd' d='M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z' clip-rule='evenodd' /></svg>";
@endphp

<select
    wire:change="{{ $action }}"
    {{ $attributes->merge([
        'class' => "appearance-none cursor-pointer rounded-lg border pl-3 pr-8 py-1.5 text-xs font-semibold shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-1 bg-no-repeat transition {$styles[$status]}",
    ]) }}
    style="background-image: url(&quot;{{ $chevron }}&quot;); background-position: right 8px center; background-size: 14px;"
>
    <option value="new" @selected($status === 'new')>New</option>
    <option value="read" @selected($status === 'read')>Read</option>
    <option value="replied" @selected($status === 'replied')>Replied</option>
    <option value="closed" @selected($status === 'closed')>Closed</option>
</select>
