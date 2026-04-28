<x-admin-layout>
    <div class="space-y-4">
        <x-admin.block>
            <div class="flex w-full items-start gap-3">
                <a href="{{ route('admin.convenios.index') }}"
                    class="mt-1 inline-flex h-8 w-8 items-center justify-center rounded-full border border-neutral-300 bg-white text-neutral-600 transition-colors hover:bg-neutral-50 hover:text-neutral-800"
                    aria-label="Volver">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor"
                        class="h-4 w-4">
                        <path
                            d="M181.66,221.66a8,8,0,0,1-11.32,0l-80-80a8,8,0,0,1,0-11.32l80-80a8,8,0,0,1,11.32,11.32L107.31,136l74.35,74.34A8,8,0,0,1,181.66,221.66Z">
                        </path>
                    </svg>
                </a>

                <div class="min-w-0 flex-1">
                    <div class="flex flex-wrap items-center gap-2 text-xs">
                        <span
                            class="inline-flex items-center rounded-full border border-neutral-300 bg-neutral-50 px-2 py-1 font-normal text-neutral-700">
                            {{ $tipoNombre }}
                        </span>
                        <span
                            class="inline-flex items-center rounded-full border border-emerald-200 bg-emerald-50 px-2 py-1 font-normal text-emerald-700">
                            {{ $estadoNombre }}
                        </span>
                        <span
                            class="inline-flex items-center rounded-full border border-neutral-300 bg-neutral-50 px-2 py-1 font-normal text-neutral-700">
                            {{ $ambitoNombre }}
                        </span>
                    </div>

                    <h1 class="mt-3 text-lg font-semibold text-neutral-600 md:text-xl">
                        {{ $titulo }}
                    </h1>
                    <p class="mt-1 text-sm text-neutral-500">{{ $resolucion }}</p>
                </div>
            </div>
        </x-admin.block>

        <x-admin.block>
            <div class="w-full">
                <div class="flex items-start gap-2 pb-4">
                    <div class="inline-flex items-center text-neutral-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor"
                            class="h-5 w-5">
                            <path
                                d="M213.66,82.34l-56-56A8,8,0,0,0,152,24H56A16,16,0,0,0,40,40V216a16,16,0,0,0,16,16H200a16,16,0,0,0,16-16V88A8,8,0,0,0,213.66,82.34ZM160,51.31,188.69,80H160ZM200,216H56V40h88V88a8,8,0,0,0,8,8h48V216Zm-32-80a8,8,0,0,1-8,8H96a8,8,0,0,1,0-16h64A8,8,0,0,1,168,136Zm0,32a8,8,0,0,1-8,8H96a8,8,0,0,1,0-16h64A8,8,0,0,1,168,168Z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-semibold text-neutral-800">Información del Convenio</h2>
                        <p class="mt-1 text-sm text-neutral-500">Datos generales y clasificación</p>
                    </div>
                </div>

                @php
                    $rows = [
                        ['label' => 'N° Resolución', 'value' => $resolucion],
                        ['label' => 'Año de Resolución', 'value' => $anioResolucion],
                        ['label' => 'Título', 'value' => $titulo],
                        ['label' => 'Tipo de convenio', 'value' => $tipoNombre],
                        ['label' => 'Estado', 'value' => $estadoNombre],
                        ['label' => 'Ámbito', 'value' => $ambitoNombre],
                        ['label' => 'Dirigido a', 'value' => $beneficiariosTexto],
                    ];
                @endphp

                <x-admin.simple-table
                    :columns="[]"
                    :rows="$rows"
                    :show-header="false"
                    :column-widths="['w-[18%]', 'w-[12%]', 'w-[30%]', 'w-[12%]', 'w-[10%]', 'w-[10%]', 'w-[18%]']"
                    table-min-width="1100px"
                    empty-state="No hay datos disponibles."
                />
            </div>
        </x-admin.block>

        <x-admin.block>
            <div class="w-full">
                <div class="flex items-start gap-2 pb-4">
                    <div class="inline-flex items-center text-neutral-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor"
                            class="h-5 w-5">
                            <path
                                d="M208,32H184V24a8,8,0,0,0-16,0v8H88V24a8,8,0,0,0-16,0v8H48A16,16,0,0,0,32,48V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32ZM72,48v8a8,8,0,0,0,16,0V48h80v8a8,8,0,0,0,16,0V48h24V80H48V48ZM208,208H48V96H208V208Z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-semibold text-neutral-800">Vigencia y Duración</h2>
                        <p class="mt-1 text-sm text-neutral-500">Fechas y plazos del convenio</p>
                    </div>
                </div>

                @php
                    $vigenciaRows = [
                        ['label' => 'Fecha de inicio', 'value' => optional($convenio->fecha_inicio)->format('d/m/Y') ?? '-'],
                        ['label' => 'Duración', 'value' => $convenio->duracion ?? '-'],
                        ['label' => 'Fecha de fin', 'value' => optional($convenio->fecha_fin)->format('d/m/Y') ?? '-'],
                        ['label' => 'Plazo de prórroga', 'value' => trim(($convenio->plazo_prorroga_valor ?? '-') . ' ' . ($convenio->plazo_prorroga_unidad ?? ''))],
                        ['label' => 'Observaciones', 'value' => $observacionProrroga ?: '-'],
                    ];
                @endphp

                <x-admin.simple-table
                    :columns="[]"
                    :rows="$vigenciaRows"
                    :show-header="false"
                    :column-widths="['w-[15%]', 'w-[15%]', 'w-[15%]', 'w-[15%]', 'w-[40%]']"
                    table-min-width="900px"
                    empty-state="No hay datos disponibles."
                />
            </div>
        </x-admin.block>

        <x-admin.block>
            <div class="w-full">
                <div class="flex items-start gap-2 pb-4">
                    <div class="inline-flex items-center text-neutral-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor"
                            class="h-5 w-5">
                            <path
                                d="M248,208H232V96a8,8,0,0,0,0-16H184V48a8,8,0,0,0,0-16H40a8,8,0,0,0,0,16V208H24a8,8,0,0,0,0,16H248a8,8,0,0,0,0-16ZM216,96V208H184V96ZM56,48H168V208H144V160a8,8,0,0,0-8-8H88a8,8,0,0,0-8,8v48H56Zm72,160H96V168h32ZM72,80a8,8,0,0,1,8-8H96a8,8,0,0,1,0,16H80A8,8,0,0,1,72,80Zm48,0a8,8,0,0,1,8-8h16a8,8,0,0,1,0,16H128A8,8,0,0,1,120,80ZM72,120a8,8,0,0,1,8-8H96a8,8,0,0,1,0,16H80A8,8,0,0,1,72,120Zm48,0a8,8,0,0,1,8-8h16a8,8,0,0,1,0,16H128A8,8,0,0,1,120,120Z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-semibold text-neutral-800">Entidad Asociada</h2>
                        <p class="mt-1 text-sm text-neutral-500">Información de la institución contraparte</p>
                    </div>
                </div>

                @php
                    $entidadRows = [
                        [
                            'institución/entidad/organismo' => $convenio->entidad_nombre ?? '-',
                            'tipo de entidad' => $convenio->entidad_tipo ?? '-',
                            'nacionalidad' => $convenio->nacionalidad ?? '-',
                            'logo' => $entidadLogoUrl,
                        ],
                    ];
                    $entidadColumns = [
                        ['key' => 'institución/entidad/organismo', 'label' => 'Institución/Entidad/Organismo', 'classes' => 'w-[42%]'],
                        ['key' => 'tipo de entidad', 'label' => 'Tipo de entidad', 'classes' => 'w-[18%]'],
                        ['key' => 'nacionalidad', 'label' => 'Nacionalidad', 'classes' => 'w-[15%]'],
                        ['key' => 'logo', 'label' => 'Logo', 'type' => 'image', 'classes' => 'w-[15%]', 'cellClasses' => 'align-middle'],
                    ];
                @endphp

                <x-admin.simple-table
                    :columns="$entidadColumns"
                    :rows="$entidadRows"
                    table-min-width="980px"
                    empty-state="No hay datos disponibles."
                />
            </div>
        </x-admin.block>

        @if (filled(data_get($convenio, 'detalles_coordinadores_json.coordinador_uns')) || filled(data_get($convenio, 'detalles_coordinadores_json.coordinador_institucion')) || data_get($convenio, 'detalles_coordinadores_json.no_se_menciona'))
            <x-admin.block>
                <div class="w-full">
                    <div class="flex items-start gap-3 border-b border-neutral-300 pb-4">
                        <div class="mt-0.5 inline-flex h-8 w-8 items-center justify-center rounded-lg border border-neutral-300 bg-white text-neutral-600">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor"
                                class="h-4 w-4">
                                <path
                                    d="M168,144a40,40,0,1,1-40-40A40,40,0,0,1,168,144ZM64,56A32,32,0,1,0,96,88,32,32,0,0,0,64,56Zm128,0a32,32,0,1,0,32,32A32,32,0,0,0,192,56Z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-semibold text-neutral-800">Coordinadores</h2>
                            <p class="mt-1 text-sm text-neutral-500">Coordinadores vinculados al convenio</p>
                        </div>
                    </div>

                    <div class="divide-y divide-neutral-300">
                        @php
                            $coordinadoresJson = data_get($convenio, 'detalles_coordinadores_json', []);
                            $coordinadoresUns = collect(data_get($coordinadoresJson, 'coordinador_uns', []))->filter()->values();
                            $coordinadoresInst = collect(data_get($coordinadoresJson, 'coordinador_institucion', []))->filter()->values();
                        @endphp

                        <div class="grid grid-cols-1 gap-2 px-4 py-4 md:grid-cols-3">
                            <div class="text-sm font-medium text-neutral-500">Coordinador UNS</div>
                            <div class="md:col-span-2 text-sm text-neutral-800">
                                {{ $coordinadoresUns->isNotEmpty() ? $coordinadoresUns->join(', ') : 'No se menciona' }}
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-2 px-4 py-4 md:grid-cols-3">
                            <div class="text-sm font-medium text-neutral-500">Coordinador Institución</div>
                            <div class="md:col-span-2 text-sm text-neutral-800">
                                {{ $coordinadoresInst->isNotEmpty() ? $coordinadoresInst->join(', ') : 'No se menciona' }}
                            </div>
                        </div>
                    </div>
                </div>
            </x-admin.block>
        @endif
    </div>
</x-admin-layout>
