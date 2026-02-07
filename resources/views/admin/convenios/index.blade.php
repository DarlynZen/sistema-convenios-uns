<x-admin-layout>
    <div class="space-y-4">
        <x-admin.block>
            <div class="flex flex-col gap-2">
                <h1 class="text-neutral-600 text-2xl font-bold">Gestión de Convenios</h1>
                <p class="text-neutral-600 text-sm">Administra todos los convenios y alianzas de la Universidad Nacional
                    del Santa</p>
            </div>
            <div class="flex flex-row items-center gap-2" x-data="{}">
                <x-admin.primary-button-create @click="$dispatch('open-modal', 'crearConvenio')">Nuevo
                    Convenio
                </x-admin.primary-button-create>
            </div>
            <!-- <x-admin.export-button>Exportar</x-admin.export-button> -->
        </x-admin.block>
        <!-- <div class="bg-white rounded p-4 border border-neutral-400 flex flex-row mx-auto w-full justify-between">
        </div> -->
        <div
            class="bg-white rounded p-4 border border-neutral-400">
            <div class="space-y-5">
                <div class="flex flex-col gap-2 mx-auto w-full justify-between">
                    <p class="text-neutral-600 text-base font-bold">Lista de Convenios</p>
                    <p class="text-neutral-600 text-sm">Lista completa de convenios registrados en el sistema.</p>
                </div>
                <div class="w-full max-w-full">
                    @php
                        $columns = [
                            ['key' => 'resolucion', 'label' => 'Nro. Resolución'],
                            ['key' => 'entidad_logo', 'label' => 'Logo', 'type' => 'image', 'classes' => 'w-12'],
                            ['key' => 'entidad_nombre', 'label' => 'Institución/Entidad/Organismo'],
                            ['key' => 'tipoConvenio.nombre', 'label' => 'Tipo'],
                            [
                                'key' => 'estado_convenio_id',
                                'label' => 'Estado',
                                'type' => 'badge',
                                'badgeComponent' => 'components.admin.badge-estado',
                                'fallback' => 'estadoConvenio.nombre',
                            ],
                            ['key' => 'ambito.nombre', 'label' => 'Ámbito'],
                            ['key' => 'beneficiario', 'label' => 'Dirigido a', 'type' => 'join', 'pluck' => 'codigo_beneficiario'],
                            ['key' => 'duracion', 'label' => 'Duración'],
                        ];

                        $actions = [
                            ['label' => 'Editar'],
                            ['label' => 'Ver Detalle'],
                            [
                                'label' => 'Eliminar',
                                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor" class="h-4 w-4"><path d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16h8V208a16,16,0,0,0,16,16H192a16,16,0,0,0,16-16V64h8a8,8,0,0,0,0-16ZM96,40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96Zm96,168H64V64H192ZM112,104v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Zm48,0v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Z"></path></svg>',
                                'classes' => 'inline-flex items-center justify-center h-8 w-8 rounded-full border border-red-200 bg-white text-red-600 hover:bg-red-50 hover:text-red-700',
                            ],
                        ];
                    @endphp
                    <x-admin.datatable :columns="$columns" :rows="$convenios" :actions="$actions"
                                       emptyState="No hay convenios registrados."/>
                </div>
            </div>
        </div>
    </div>

    {{--Modal Crear Convenio--}}
    <x-modal name="crearConvenio" :show="false" maxWidth="4xl">
        <x-slot name="title">
            <div class="font-bold text-base text-neutral-700">Crear nuevo convenio</div>
        </x-slot>

        {{-- El formulario ahora incluye su propia navegación interna --}}
        @include('admin.convenios.crearConvenio')

        <x-slot name="footer">
            <div x-data="{ step: 1, maxStep: 3 }" x-on:step-changed.window="step = $event.detail.step" class="flex flex-row items-center gap-2">
                <x-admin.cancel-button @click="$dispatch('close-modal', 'crearConvenio')">Cancelar</x-admin.cancel-button>

                <x-admin.cancel-button
                    @click="$dispatch('wizard-prev')"
                    x-bind:disabled="step === 1"
                    class="disabled:opacity-50 disabled:pointer-events-none"
                >
                    Anterior
                </x-admin.cancel-button>

                <x-admin.confirm-button
                    @click="$dispatch('wizard-next')"
                    x-bind:disabled="step === maxStep"
                    class="disabled:opacity-50 disabled:pointer-events-none"
                >
                    Siguiente
                </x-admin.confirm-button>

                <x-admin.confirm-button
                    type="submit"
                    form="form-crear-convenio"
                    x-bind:disabled="step !== maxStep"
                    x-bind:title="step !== maxStep ? 'Completa los pasos para habilitar este botón' : ''"
                    class="disabled:opacity-50 disabled:pointer-events-none"
                >
                    Crear convenio
                </x-admin.confirm-button>
            </div>
        </x-slot>
    </x-modal>

</x-admin-layout>
