<x-admin-layout>
    <div class="space-y-4">
        @if (session('success'))
            <div class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                {{ session('error') }}
            </div>
        @endif

        <x-admin.block>
            <div class="flex flex-col gap-2">
                <h1 class="text-neutral-600 text-2xl font-bold">Gestión de Convenios</h1>
                <p class="text-neutral-600 text-sm">Administra todos los convenios y alianzas de la Universidad Nacional
                    del Santa</p>
            </div>
            <x-admin.primary-button-create
                onclick="window.location.href='{{ route('admin.convenios.create') }}';">
                Nuevo Convenio
            </x-admin.primary-button-create>
            <!-- <x-admin.export-button>Exportar</x-admin.export-button> -->
        </x-admin.block>
        <!-- <div class="bg-white rounded p-4 border border-neutral-400 flex flex-row mx-auto w-full justify-between">
        </div> -->
        <div class="bg-white rounded p-4 border border-neutral-400">
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
                            [
                                'key' => 'beneficiario',
                                'label' => 'Dirigido a',
                                'type' => 'join',
                                'pluck' => 'codigo_beneficiario',
                            ],
                            ['key' => 'duracion', 'label' => 'Duración'],
                        ];
                    @endphp
                    <x-admin.datatable :columns="$columns" :rows="$convenios" actions="admin.convenios.partials.actions"
                        emptyState="No hay convenios registrados." />
                </div>
            </div>
        </div>
    </div>

</x-admin-layout>
