@php($convenio = $row)

<div class="flex flex-wrap items-center justify-end gap-2">
    {{-- Botón Editar --}}
    <a href="#"
       class="inline-flex items-center px-2 py-1 text-[11px] md:text-xs font-medium uppercase tracking-wide text-slate-500 hover:text-slate-700 border border-slate-200 rounded-full">
        Editar
    </a>

    {{-- Botón Ver Detalle --}}
    <a href="#"
       class="inline-flex items-center px-2 py-1 text-[11px] md:text-xs font-medium uppercase tracking-wide text-slate-500 hover:text-slate-700 border border-slate-200 rounded-full">
        Ver detalle
    </a>

    {{-- Botón Eliminar (UI) --}}
    <button
        type="button"
        class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-red-200 bg-white text-red-600 transition-colors hover:bg-red-50 hover:text-red-700"
        aria-label="Eliminar"
        title="Eliminar"
    >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor" class="h-4 w-4">
            <path d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16h8V208a16,16,0,0,0,16,16H192a16,16,0,0,0,16-16V64h8a8,8,0,0,0,0-16ZM96,40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96Zm96,168H64V64H192ZM112,104v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Zm48,0v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Z"></path>
        </svg>
    </button>
</div>

