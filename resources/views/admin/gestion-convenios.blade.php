<x-admin-layout>
    <div class="space-y-4">
        <x-admin.block>
            <div class="flex flex-col gap-2">
                <h1 class="text-neutral-600 text-2xl font-bold">Gestión de Convenios</h1>
                <p class="text-neutral-600 text-sm">Administra todos los convenios y alianzas de la Universidad Nacional del Santa</p>
            </div>
            <div class="flex flex-row items-center gap-2" x-data="{}">
                <x-admin.primary-button-create @click="$dispatch('open-modal', 'info')" >Nuevo
                    Convenio</x-admin.primary-button-create>
            </div>
            <x-modal name="info" :show="false" maxWidth="2xl">
                <x-slot name="title">Crear nuevo convenio</x-slot>
                <div>Convenios</div>
                <x-slot name="footer">
                    <x-admin.cancel-button>Cancelar</x-admin.cancel-button>
                    <x-admin.confirm-button>Crear convenio</x-admin.confirm-button>
                </x-slot>
            </x-modal>
            <!-- <x-admin.export-button>Exportar</x-admin.export-button> -->
        </x-admin.block>
        <!-- <div class="bg-white rounded p-4 border border-neutral-400 flex flex-row mx-auto w-full justify-between">

        </div> -->
        <div class="bg-white rounded p-4 border border-neutral-400 flex flex-row mx-auto w-full justify-between">
            <div class="space-y-5">
                <div class="flex flex-col gap-2">
                    <p class="text-neutral-600 text-base font-bold">Lista de Convenios</p>
                    <p class="text-neutral-600 text-sm">Lista completa de convenios registrados en el sistema.</p>
                </div>
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
                        ['label' => 'Eliminar'],
                    ];
                @endphp
                <x-admin.datatable :columns="$columns" :rows="$convenios" :actions="$actions" emptyState="No hay convenios registrados." />
            </div>
        </div>
    </div>
</x-admin-layout>
