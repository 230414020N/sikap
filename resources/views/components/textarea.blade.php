@props([
    'label' => null,
    'name' => null,
    'value' => null,
    'rows' => 4,
    'placeholder' => null
])

<div class="space-y-2">
    @if($label)
        <label for="{{ $name }}" class="text-sm font-medium text-gray-900">
            {{ $label }}
        </label>
    @endif

    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' =>
            'w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-900 placeholder:text-gray-400
             focus:outline-none focus:ring-2 focus:ring-black focus:border-black transition'
        ]) }}
    >{{ old($name, $value) }}</textarea>

    @error($name)
        <p class="text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
