@php($convenio = $row)

<div class="flex flex-wrap items-center justify-center gap-2">
    {{-- Botón Editar --}}
    <a href="{{ route('admin.convenios.show', $convenio) }}"
       class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-neutral-200 bg-white text-neutral-600 transition-colors hover:bg-neutral-50 hover:text-neutral-800"
       aria-label="Editar"
       title="Editar">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor" class="h-4 w-4">
            <path d="M227.32,73.37,182.63,28.69a16,16,0,0,0-22.63,0L36.69,152A15.86,15.86,0,0,0,32,163.31V208a16,16,0,0,0,16,16H216a8,8,0,0,0,0-16H115.32l112-112A16,16,0,0,0,227.32,73.37ZM92.69,208H48V163.31l88-88L180.69,120ZM192,108.69,147.32,64l24-24L216,84.69Z"></path>
        </svg>
    </a>

    {{-- Botón Ver Detalle --}}
    <a href="{{ route('admin.convenios.show', $convenio) }}"
       class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-neutral-200 bg-white text-neutral-600 transition-colors hover:bg-neutral-50 hover:text-neutral-800"
       aria-label="Ver detalle"
       title="Ver detalle">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor" class="h-4 w-4">
            <path d="M247.31,124.76c-.35-.79-8.82-19.58-27.65-38.41C194.57,61.26,162.88,48,128,48S61.43,61.26,36.34,86.35C17.51,105.18,9,124,8.69,124.76a8,8,0,0,0,0,6.5c.35.79,8.82,19.57,27.65,38.4C61.43,194.74,93.12,208,128,208s66.57-13.26,91.66-38.34c18.83-18.83,27.3-37.61,27.65-38.4A8,8,0,0,0,247.31,124.76ZM128,192c-30.78,0-57.67-11.19-79.93-33.25A133.47,133.47,0,0,1,25,128,133.33,133.33,0,0,1,48.07,97.25C70.33,75.19,97.22,64,128,64s57.67,11.19,79.93,33.25A133.46,133.46,0,0,1,231.05,128C223.84,141.46,192.43,192,128,192Zm0-112a48,48,0,1,0,48,48A48.05,48.05,0,0,0,128,80Zm0,80a32,32,0,1,1,32-32A32,32,0,0,1,128,160Z"></path>
        </svg>
    </a>

    {{-- Botón Eliminar --}}
    <button
        type="button"
        class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-red-200 bg-white text-red-600 transition-colors hover:bg-red-50 hover:text-red-700"
        aria-label="Eliminar"
        title="Eliminar"
        x-on:click.prevent="$dispatch('open-modal', 'delete-convenio-{{ $convenio->id }}')"
    >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor" class="h-4 w-4">
            <path d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16h8V208a16,16,0,0,0,16,16H192a16,16,0,0,0,16-16V64h8a8,8,0,0,0,0-16ZM96,40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96Zm96,168H64V64H192ZM112,104v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Zm48,0v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Z"></path>
        </svg>
    </button>

    <x-admin.confimartion-modal
        name="delete-convenio-{{ $convenio->id }}"
        size="sm"
        title="Confirmar eliminación"
        :icon="'<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 256 256&quot; fill=&quot;currentColor&quot; class=&quot;h-4 w-4&quot;><path d=&quot;M236.8,188.09,149.35,36.22h0a24.76,24.76,0,0,0-42.7,0L19.2,188.09a23.51,23.51,0,0,0,0,23.72A24.35,24.35,0,0,0,40.55,224h174.9a24.35,24.35,0,0,0,21.33-12.19A23.51,23.51,0,0,0,236.8,188.09ZM222.93,203.8a8.5,8.5,0,0,1-7.48,4.2H40.55a8.5,8.5,0,0,1-7.48-4.2,7.59,7.59,0,0,1,0-7.72L120.52,44.21a8.75,8.75,0,0,1,15,0l87.45,151.87A7.59,7.59,0,0,1,222.93,203.8ZM120,144V104a8,8,0,0,1,16,0v40a8,8,0,0,1-16,0Zm20,36a12,12,0,1,1-12-12A12,12,0,0,1,140,180Z&quot;></path></svg>'"
    >
        <p class="text-sm text-neutral-600">
            ¿Estás seguro(a) de eliminar el convenio "<span class="font-medium text-neutral-800">{{ $convenio->titulo }}</span>"?
        </p>

        <form method="POST" action="{{ route('admin.convenios.destroy', $convenio) }}" class="flex items-center justify-end gap-2">
            @csrf
            @method('DELETE')

            <button
                type="button"
                class="inline-flex items-center rounded border border-neutral-300 bg-white px-3 py-2 text-sm font-medium text-neutral-700 transition-colors hover:bg-neutral-50"
                x-on:click="$dispatch('close-modal')"
            >
                Cancelar
            </button>

            <button
                type="submit"
                class="inline-flex items-center rounded border border-red-200 bg-red-50 px-3 py-2 text-sm font-medium text-red-700 transition-colors hover:bg-red-100"
            >
                Eliminar
            </button>
        </form>
    </x-admin.confimartion-modal>
</div>
