@php
    $faq = is_array($row ?? null) ? $row : [];
@endphp

<button
    type="button"
    class="inline-flex items-center justify-center h-8 w-8 rounded-full border border-neutral-200 bg-white text-neutral-600 hover:bg-neutral-50 hover:text-neutral-800"
    @click="$dispatch('faq-edit-requested', { faq: @js($faq) }); $dispatch('open-modal', 'editarFAQ')"
>
    <span class="sr-only">Editar</span>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor" class="h-4 w-4" aria-hidden="true">
        <path d="M227.32,73.37,182.63,28.69a16,16,0,0,0-22.63,0L36.69,152A15.86,15.86,0,0,0,32,163.31V208a16,16,0,0,0,16,16H216a8,8,0,0,0,0-16H115.32l112-112A16,16,0,0,0,227.32,73.37ZM92.69,208H48V163.31l88-88L180.69,120ZM192,108.69,147.32,64l24-24L216,84.69Z"></path>
    </svg>
</button>

<button
    type="button"
    class="inline-flex items-center justify-center h-8 w-8 rounded-full border border-red-200 bg-white text-red-600 hover:bg-red-50 hover:text-red-700"
    @click="$dispatch('faq-delete-requested', { faq: @js($faq) }); $dispatch('open-modal', 'eliminarFAQ')"
>
    <span class="sr-only">Eliminar</span>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor" class="h-4 w-4" aria-hidden="true">
        <path d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16h8V208a16,16,0,0,0,16,16H192a16,16,0,0,0,16-16V64h8a8,8,0,0,0,0-16ZM96,40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96Zm96,168H64V64H192ZM112,104v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Zm48,0v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Z"></path>
    </svg>
</button>
