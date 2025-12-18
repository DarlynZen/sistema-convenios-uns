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

    {{-- Botón Eliminar (no redirige aún, solo placeholder) --}}
    <button type="button"
            class="inline-flex items-center px-2 py-1 text-[11px] md:text-xs font-medium uppercase tracking-wide text-red-600 hover:text-red-700 border border-red-200 rounded-full">
        Eliminar
    </button>
</div>

