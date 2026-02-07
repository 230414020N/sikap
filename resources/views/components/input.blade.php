@props([
    'label' => null,
    'name' => null,
    'type' => 'text',
    'value' => null,
    'placeholder' => null
])

<div class="space-y-2">
    @if($label)
        <label for="{{ $name }}" class="text-sm font-medium text-gray-900">
            {{ $label }}
        </label>
    @endif

    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' =>
            'w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400
             focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition'
        ]) }}
    />

    @error($name)
        <p class="text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
