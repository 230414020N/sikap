@props([
    'variant' => 'primary',
    'type' => 'submit'
])

@php
    $styles = [
        'primary' => 'bg-black text-white hover:bg-gray-900',
        'secondary' => 'bg-white text-gray-900 border border-gray-300 hover:bg-gray-50',
        'danger' => 'bg-red-600 text-white hover:bg-red-700',
    ];
@endphp

<button type="{{ $type }}"
    {{ $attributes->merge(['class' =>
        'inline-flex items-center justify-center rounded-xl px-5 py-2.5 text-sm font-medium transition
         focus:outline-none focus:ring-2 focus:ring-black ' . ($styles[$variant] ?? $styles['primary'])
    ]) }}>
    {{ $slot }}
</button>
