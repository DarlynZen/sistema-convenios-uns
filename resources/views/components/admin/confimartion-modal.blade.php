@props(['name', 'size', ])

@php
    $sizes = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-2xl'
    ];
@endphp

<div 
    x-data="{ open: false }"
    x-on:open-modal.window="if ($event.detail === '{{ $name }}') open = true"
    x-on:close-modal.window="open = false"
    x-cloak
>
    <div 
        x-show="open"
        class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
    >
        <div 
            x-show="open"
            x-transition
            @click.outside="open = false"
            class="bg-white p-6 rounded-xl shadow-xl w-full {{ $sizes[$size] }}"
        >
            {{ $slot }}
        </div>
    </div>
</div>
