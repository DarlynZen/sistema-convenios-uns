@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-neutral-400 focus:border-neutral-600 rounded']) }}>
