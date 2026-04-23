<x-admin-layout>
    @php
        $tipoNombre = data_get($convenio, 'tipoConvenio.nombre', 'Sin tipo');
        $ambitoNombre = data_get($convenio, 'ambito.nombre', 'Sin ámbito');
        $estadoNombre = data_get($convenio, 'estadoConvenio.nombre', 'Sin estado');
        $resolucion = $convenio->resolucion ?? 'Sin resolución';
        $titulo = $convenio->titulo ?? 'Convenio sin título';
        $beneficiarios = collect($convenio->beneficiarios ?? []);
        $beneficiariosTexto = $beneficiarios->pluck('codigo_beneficiario')->filter()->join(', ');
        $beneficiariosTexto = $beneficiariosTexto !== '' ? $beneficiariosTexto : '-';
        $observacion = $convenio->observacion ?? data_get($convenio, 'observacion', '-');
    @endphp

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
                    <div class="flex flex-wrap items-center gap-2 text-xs md:text-sm">
                        <span
                            class="inline-flex items-center rounded-full border border-neutral-300 bg-neutral-50 px-3 py-1 font-medium text-neutral-700">
                            {{ $tipoNombre }}
                        </span>
                        <span
                            class="inline-flex items-center rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 font-medium text-emerald-700">
                            {{ $estadoNombre }}
                        </span>
                        <span
                            class="inline-flex items-center rounded-full border border-neutral-300 bg-neutral-50 px-3 py-1 font-medium text-neutral-700">
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
                <div class="flex items-start gap-3 border-b border-neutral-300 pb-4">
                    <div class="mt-0.5 inline-flex h-8 w-8 items-center justify-center rounded-lg border border-neutral-300 bg-white text-neutral-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor"
                            class="h-4 w-4">
                            <path
                                d="M213.66,82.34l-56-56A8,8,0,0,0,152,24H56A16,16,0,0,0,40,40V216a16,16,0,0,0,16,16H200a16,16,0,0,0,16-16V88A8,8,0,0,0,213.66,82.34ZM160,51.31,188.69,80H160ZM200,216H56V40h88V88a8,8,0,0,0,8,8h48V216Zm-42.34-77.66a8,8,0,0,1-11.32,11.32L136,139.31V184a8,8,0,0,1-16,0V139.31l-10.34,10.35a8,8,0,0,1-11.32-11.32l24-24a8,8,0,0,1,11.32,0Z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-semibold text-neutral-800">Información del Convenio</h2>
                        <p class="mt-1 text-sm text-neutral-500">Datos generales y clasificación</p>
                    </div>
                </div>

                <div class="overflow-hidden rounded border border-neutral-400">
                    <table class="w-full table-auto bg-white text-sm text-[#393939]">
                        <tbody class="divide-y divide-neutral-300 align-top">
                            @php
                                $rows = [
                                    ['label' => 'Tipo de convenio', 'value' => $tipoNombre],
                                    ['label' => 'Ámbito', 'value' => $ambitoNombre],
                                    ['label' => 'Estado', 'value' => $estadoNombre],
                                    ['label' => 'N° Resolución', 'value' => $resolucion],
                                    ['label' => 'Título', 'value' => $titulo],
                                    ['label' => 'Dirigido a', 'value' => $beneficiariosTexto],
                                    ['label' => 'Institución/Entidad/Organismo', 'value' => $convenio->entidad_nombre ?? '-'],
                                    ['label' => 'Duración', 'value' => $convenio->duracion ?? '-'],
                                    ['label' => 'Observación', 'value' => $observacion ?: '-'],
                                ];
                            @endphp

                            @foreach ($rows as $row)
                                <tr class="group transition hover:bg-neutral-100">
                                    <td class="w-1/3 px-4 py-3 align-top text-sm font-medium text-neutral-500">
                                        {{ $row['label'] }}
                                    </td>
                                    <td class="px-4 py-3 align-top text-sm text-neutral-800">
                                        {{ $row['value'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
