@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-neutral-600']) }}>
    {{ $value ?? $slot }}
</label>
