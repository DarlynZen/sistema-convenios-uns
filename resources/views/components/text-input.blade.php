@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-neutral-300 focus:border-red-400 focus:ring-2 focus:ring-red-200 rounded']) }}>
