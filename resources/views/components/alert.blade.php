@props([
    'type' => 'success'
])

@php
    $styles = [
        'success' => 'bg-gray-900 text-white',
        'error' => 'bg-red-600 text-white',
        'info' => 'bg-gray-100 text-gray-900 border border-gray-200',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'rounded-xl px-4 py-3 text-sm ' . ($styles[$type] ?? $styles['info'])]) }}>
    {{ $slot }}
</div>
