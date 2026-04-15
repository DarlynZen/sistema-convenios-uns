<x-admin-layout>
    <div class="space-y-4">
        {{-- Encabezado --}}
        <x-admin.block>
            <div class="flex flex-col gap-2">
                <h1 class="text-neutral-600 text-2xl font-bold">Crear nuevo convenio</h1>
                <p class="text-neutral-600 text-sm">Completa los pasos para registrar un nuevo convenio académico o de investigación</p>
            </div>
        </x-admin.block>

        {{-- Formulario con Stepper --}}
        <div class="bg-white rounded border border-neutral-400">
            @include('admin.convenios.crearConvenio')
        </div>

        {{-- Botones de acción (Volver/Cancelar) --}}
        <div class="flex justify-between items-center">
            <a href="{{ route('admin.convenios.index') }}"
               class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-neutral-700 border border-neutral-200 rounded-md bg-white hover:bg-neutral-50 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" class="h-4 w-4 mr-2" aria-hidden="true">
                    <path fill="currentColor" d="M224,128a8,8,0,0,1-8,8H59.31l58.35,58.34a8,8,0,0,1-11.32,11.32l-72-72a8,8,0,0,1,0-11.32l72-72a8,8,0,0,1,11.32,11.32L59.31,120H216A8,8,0,0,1,224,128Z"></path>
                </svg>
                Volver a la lista
            </a>
        </div>
    </div>
</x-admin-layout>
