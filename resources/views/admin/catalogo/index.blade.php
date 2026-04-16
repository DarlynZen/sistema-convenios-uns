<x-admin-layout>
    <div
        class="space-y-4"
        x-data="{
            selected: null,
            openEdit(row) {
                this.selected = {
                    id: row.id,
                    nombre: row.nombre ?? '',
                    codigo_beneficiario: row.codigo_beneficiario ?? '',
                    descripcion: row.descripcion ?? '',
                    estado: Number(row.estado) === 1,
                };
                $dispatch('open-modal', 'editar-beneficiario');
            },
        }"
        x-on:catalogo-beneficiario-edit.window="openEdit($event.detail)"
    >
        @if (session('success'))
            <div class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <x-admin.block>
            <div class="flex flex-col gap-2">
                <h1 class="text-neutral-600 text-2xl font-bold">Catálogo del sistema</h1>
                <p class="text-neutral-600 text-sm">Gestión de beneficiarios del sistema</p>
            </div>
        </x-admin.block>

        <div class="bg-white rounded p-4 border border-neutral-400">
            <div class="space-y-5">
                <div class="flex flex-col gap-2 mx-auto w-full justify-between">
                    <p class="text-neutral-600 text-base font-bold">Beneficiarios</p>
                    <p class="text-neutral-600 text-sm">Listado actual de beneficiarios registrados.</p>
                </div>
                <div class="w-full max-w-full">
                    @php
                        $columns = [
                            ['key' => 'nombre', 'label' => 'Nombre'],
                            ['key' => 'codigo_beneficiario', 'label' => 'Código'],
                            ['key' => 'descripcion', 'label' => 'Descripción'],
                            ['key' => 'estado_texto', 'label' => 'Estado'],
                        ];

                        $rows = collect($beneficiarios)->map(function ($beneficiario) {
                            return [
                                'id' => $beneficiario->id,
                                'nombre' => $beneficiario->nombre,
                                'codigo_beneficiario' => $beneficiario->codigo_beneficiario,
                                'descripcion' => $beneficiario->descripcion ?: '—',
                                'estado' => (int) $beneficiario->estado,
                                'estado_texto' => (int) $beneficiario->estado === 1 ? 'Activo' : 'Inactivo',
                            ];
                        })->all();
                    @endphp

                    <x-admin.datatable
                        :columns="$columns"
                        :rows="$rows"
                        actions="admin.catalogo.partials.beneficiario-actions"
                        emptyState="No hay beneficiarios registrados."
                    />
                </div>
            </div>
        </div>

        <x-modal name="editar-beneficiario" :show="false" maxWidth="md">
            <x-slot name="title">
                <div class="font-bold text-base text-neutral-700">Editar beneficiario</div>
            </x-slot>

            <form
                x-bind:action="selected ? '{{ url('admin/catalogo/beneficiarios') }}/' + selected.id : '#'"
                method="POST"
                class="p-4 space-y-4"
            >
                @csrf
                @method('PATCH')

                <div class="flex items-center justify-between rounded-lg border border-neutral-200 px-3 py-2">
                    <span class="text-sm font-medium text-neutral-700">Activo</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" x-model="selected.estado">
                        <input type="hidden" name="estado" x-bind:value="selected && selected.estado ? 1 : 0">
                        <div class="w-11 h-6 bg-neutral-200 rounded-full peer peer-focus:ring-2 peer-focus:ring-brand-200 peer-checked:bg-brand-600 transition-colors"></div>
                        <span class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white transition-transform" x-bind:class="selected && selected.estado ? 'translate-x-5' : 'translate-x-0'"></span>
                    </label>
                </div>

                <div>
                    <x-input-label for="beneficiario_nombre" value="Título"/>
                    <x-text-input
                        id="beneficiario_nombre"
                        type="text"
                        x-bind:value="selected ? selected.nombre : ''"
                        class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] bg-neutral-50"
                        readonly
                    />
                </div>

                <div>
                    <x-input-label for="beneficiario_codigo" value="Código nombre"/>
                    <x-text-input
                        id="beneficiario_codigo"
                        type="text"
                        x-bind:value="selected ? selected.codigo_beneficiario : ''"
                        class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] bg-neutral-50"
                        readonly
                    />
                </div>

                <div>
                    <x-input-label for="descripcion" value="Descripción"/>
                    <textarea
                        id="descripcion"
                        name="descripcion"
                        rows="3"
                        x-model="selected.descripcion"
                        class="mt-1 block w-full rounded-lg border border-neutral-200 bg-white px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                        placeholder="Descripción del beneficiario"
                    ></textarea>
                </div>

                <div class="flex justify-end gap-2">
                    <x-admin.cancel-button type="button" @click="$dispatch('close-modal', 'editar-beneficiario')">
                        Cancelar
                    </x-admin.cancel-button>
                    <x-admin.confirm-button type="submit">
                        Guardar cambios
                    </x-admin.confirm-button>
                </div>
            </form>
        </x-modal>
    </div>
</x-admin-layout>
