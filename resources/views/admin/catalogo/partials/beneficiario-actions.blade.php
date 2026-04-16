@php
    $item = is_array($row ?? null) ? $row : [];
@endphp

<button
    type="button"
    class="inline-flex items-center justify-center h-8 w-8 rounded-full border border-neutral-200 bg-white text-neutral-600 hover:bg-neutral-50 hover:text-neutral-800"
    @click="$dispatch('catalogo-beneficiario-edit', @js($item))"
>
    <span class="sr-only">Editar</span>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor" class="h-4 w-4" aria-hidden="true">
        <path d="M227.32,73.37,182.63,28.69a16,16,0,0,0-22.63,0L36.69,152A15.86,15.86,0,0,0,32,163.31V208a16,16,0,0,0,16,16H216a8,8,0,0,0,0-16H115.32l112-112A16,16,0,0,0,227.32,73.37ZM92.69,208H48V163.31l88-88L180.69,120ZM192,108.69,147.32,64l24-24L216,84.69Z"></path>
    </svg>
</button>
