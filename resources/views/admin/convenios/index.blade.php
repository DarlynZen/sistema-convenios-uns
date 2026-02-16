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
                            [
                                'label' => 'Editar',
                                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor" class="h-4 w-4"><path d="M227.32,73.37,182.63,28.69a16,16,0,0,0-22.63,0L36.69,152A15.86,15.86,0,0,0,32,163.31V208a16,16,0,0,0,16,16H216a8,8,0,0,0,0-16H115.32l112-112A16,16,0,0,0,227.32,73.37ZM92.69,208H48V163.31l88-88L180.69,120ZM192,108.69,147.32,64l24-24L216,84.69Z"></path></svg>',
                                'classes' => 'inline-flex items-center justify-center h-8 w-8 rounded-full border border-neutral-200 bg-white text-neutral-600 hover:bg-neutral-50 hover:text-neutral-800',
                            ],
                            [
                                'label' => 'Ver detalle',
                                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor" class="h-4 w-4"><path d="M247.31,124.76c-.35-.79-8.82-19.58-27.65-38.41C194.57,61.26,162.88,48,128,48S61.43,61.26,36.34,86.35C17.51,105.18,9,124,8.69,124.76a8,8,0,0,0,0,6.5c.35.79,8.82,19.57,27.65,38.4C61.43,194.74,93.12,208,128,208s66.57-13.26,91.66-38.34c18.83-18.83,27.3-37.61,27.65-38.4A8,8,0,0,0,247.31,124.76ZM128,192c-30.78,0-57.67-11.19-79.93-33.25A133.47,133.47,0,0,1,25,128,133.33,133.33,0,0,1,48.07,97.25C70.33,75.19,97.22,64,128,64s57.67,11.19,79.93,33.25A133.46,133.46,0,0,1,231.05,128C223.84,141.46,192.43,192,128,192Zm0-112a48,48,0,1,0,48,48A48.05,48.05,0,0,0,128,80Zm0,80a32,32,0,1,1,32-32A32,32,0,0,1,128,160Z"></path></svg>',
                                'classes' => 'inline-flex items-center justify-center h-8 w-8 rounded-full border border-neutral-200 bg-white text-neutral-600 hover:bg-neutral-50 hover:text-neutral-800',
                            ],
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
    <x-modal name="crearConvenio" :show="false" maxWidth="2xl">
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
