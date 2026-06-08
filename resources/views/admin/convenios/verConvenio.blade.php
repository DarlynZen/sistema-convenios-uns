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
                    <div class="inline-flex items-center text-brand-600">
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

                <x-admin.simple-table
                    :columns="[]"
                    :rows="$informacionRows"
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
                    <div class="inline-flex items-center text-brand-600">
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
                    <div class="inline-flex items-center text-brand-600">
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

                <x-admin.simple-table
                    :columns="$entidadColumns"
                    :rows="$entidadRows"
                    table-min-width="980px"
                    empty-state="No hay datos disponibles."
                />
            </div>
        </x-admin.block>

        <x-admin.block>
            <div class="w-full">
                <div class="flex items-start gap-2 pb-4">
                    <div class="inline-flex items-center text-brand-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor"
                            class="h-5 w-5">
                            <path
                                d="M24,128A72.08,72.08,0,0,1,96,56H204.69L194.34,45.66a8,8,0,0,1,11.32-11.32l24,24a8,8,0,0,1,0,11.32l-24,24a8,8,0,0,1-11.32-11.32L204.69,72H96a56.06,56.06,0,0,0-56,56,8,8,0,0,1-16,0Zm200-8a8,8,0,0,0-8,8,56.06,56.06,0,0,1-56,56H51.31l10.35-10.34a8,8,0,0,0-11.32-11.32l-24,24a8,8,0,0,0,0,11.32l24,24a8,8,0,0,0,11.32-11.32L51.31,200H160a72.08,72.08,0,0,0,72-72A8,8,0,0,0,224,120Z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-semibold text-neutral-800">Renovación</h2>
                        <p class="mt-1 text-sm text-neutral-500">Relación con convenios anteriores</p>
                    </div>
                </div>

                <x-admin.simple-table
                    :columns="[]"
                    :rows="$renovacionRows"
                    :show-header="false"
                    :column-widths="['w-[30%]', 'w-[70%]']"
                    table-min-width="700px"
                    empty-state="No hay datos disponibles."
                />
            </div>
        </x-admin.block>

        <x-admin.block>
            <div class="w-full">
                <div class="flex items-start gap-2 pb-4">
                    <div class="inline-flex items-center text-brand-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor"
                            class="h-5 w-5">
                            <path
                                d="M209.66,122.34a8,8,0,0,1,0,11.32l-82.05,82a56,56,0,0,1-79.2-79.21L147.67,35.73a40,40,0,1,1,56.61,56.55L105,193A24,24,0,1,1,71,159L154.3,74.38A8,8,0,1,1,165.7,85.6L82.39,170.31a8,8,0,1,0,11.27,11.36L192.93,81A24,24,0,1,0,159,47L59.76,147.68a40,40,0,1,0,56.53,56.62l82.06-82A8,8,0,0,1,209.66,122.34Z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-semibold text-neutral-800">Documentación adjunta</h2>
                        <p class="mt-1 text-sm text-neutral-500">Documentos relacionados al convenio</p>
                    </div>
                </div>

                @if ($documentosAdjuntos->isNotEmpty())
                    <div class="space-y-3">
                        @foreach ($documentosAdjuntos as $documento)
                            <div class="flex flex-wrap items-center justify-between gap-4 rounded border border-neutral-300 bg-white px-4 py-3">
                                <div class="flex items-start gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-50 text-red-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor"
                                            class="h-5 w-5">
                                            <path
                                                d="M213.66,82.34l-56-56A8,8,0,0,0,152,24H56A16,16,0,0,0,40,40V216a16,16,0,0,0,16,16H200a16,16,0,0,0,16-16V88A8,8,0,0,0,213.66,82.34ZM160,51.31,188.69,80H160ZM200,216H56V40h88V88a8,8,0,0,0,8,8h48V216Z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-neutral-800">{{ $documento['nombre'] }}</div>
                                        <div class="mt-0.5 text-xs text-neutral-500">
                                            {{ $documento['sizeLabel'] }} · Subido el {{ $documento['fechaLabel'] }}
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ $documento['downloadUrl'] }}"
                                    class="inline-flex items-center gap-2 text-sm font-semibold text-neutral-700 transition hover:text-neutral-900 {{ $documento['hasFile'] ? '' : 'pointer-events-none text-neutral-400' }}"
                                    @if ($documento['hasFile']) download @endif>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor"
                                        class="h-4 w-4">
                                        <path
                                            d="M208,160a8,8,0,0,1-8,8H56a8,8,0,0,1,0-16H200A8,8,0,0,1,208,160Zm-80-24a8,8,0,0,1-5.66-2.34l-32-32a8,8,0,1,1,11.32-11.32L120,108.69V40a8,8,0,0,1,16,0v68.69l18.34-18.35a8,8,0,0,1,11.32,11.32l-32,32A8,8,0,0,1,128,136Z">
                                        </path>
                                    </svg>
                                    Descargar
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="rounded border border-neutral-300 bg-neutral-50 px-4 py-6 text-sm text-neutral-500">
                        No hay documentación adjunta.
                    </div>
                @endif
            </div>
        </x-admin.block>

        @if ($mostrarCoordinadores)
            <x-admin.block>
                <div class="w-full">
                    <div class="flex items-start gap-3 pb-4">
                        <div class="inline-flex items-center text-brand-600">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor"
                                class="h-5 w-5">
                                <path
                                    d="M117.25,157.92a60,60,0,1,0-66.5,0A95.83,95.83,0,0,0,3.53,195.63a8,8,0,1,0,13.4,8.74,80,80,0,0,1,134.14,0,8,8,0,0,0,13.4-8.74A95.83,95.83,0,0,0,117.25,157.92ZM40,108a44,44,0,1,1,44,44A44.05,44.05,0,0,1,40,108Zm210.14,98.7a8,8,0,0,1-11.07-2.33A79.83,79.83,0,0,0,172,168a8,8,0,0,1,0-16,44,44,0,1,0-16.34-84.87,8,8,0,1,1-5.94-14.85,60,60,0,0,1,55.53,105.64,95.83,95.83,0,0,1,47.22,37.71A8,8,0,0,1,250.14,206.7Z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-semibold text-neutral-800">Coordinadores</h2>
                            <p class="mt-1 text-sm text-neutral-500">Personas de contacto designadas por cada institución</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div class="rounded border border-neutral-400 bg-white p-4 shadow-sm">
                            <span
                                class="inline-flex items-center rounded-full border border-red-200 bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                                UNS
                            </span>
                            <div class="mt-3 border-t border-neutral-400 pt-3">
                                <div class="space-y-2 text-sm text-neutral-700">
                                <div class="flex items-start gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor"
                                        class="mt-0.5 h-4 w-4 text-neutral-500">
                                        <path
                                            d="M230.92,212c-15.23-26.33-38.7-45.21-66.09-54.16a72,72,0,1,0-73.66,0C63.78,166.78,40.31,185.66,25.08,212a8,8,0,1,0,13.85,8c18.84-32.56,52.14-52,89.07-52s70.23,19.44,89.07,52a8,8,0,1,0,13.85-8ZM72,96a56,56,0,1,1,56,56A56.06,56.06,0,0,1,72,96Z">
                                        </path>
                                    </svg>
                                    <div>
                                        <div class="font-semibold text-neutral-800">
                                            {{ $coordinadoresUns->isNotEmpty() ? $coordinadoresUns->join(', ') : 'No se menciona' }}
                                        </div>
                                        <div class="text-xs text-neutral-500">Coordinacion UNS</div>
                                    </div>
                                </div>
                                <div class="flex items-start gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor"
                                        class="mt-0.5 h-4 w-4 text-neutral-500">
                                        <path
                                            d="M224,48H32a8,8,0,0,0-8,8V192a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V56A8,8,0,0,0,224,48ZM203.43,64,128,133.15,52.57,64ZM216,192H40V74.19l82.59,75.71a8,8,0,0,0,10.82,0L216,74.19V192Z">
                                        </path>
                                    </svg>
                                    <div class="text-neutral-700">-</div>
                                </div>
                                <div class="flex items-start gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor"
                                        class="mt-0.5 h-4 w-4 text-neutral-500">
                                        <path
                                            d="M222.37,158.46l-47.11-21.11-.13-.06a16,16,0,0,0-15.17,1.4,8.12,8.12,0,0,0-.75.56L134.87,160c-15.42-7.49-31.34-23.29-38.83-38.51l20.78-24.71c.2-.25.39-.5.57-.77a16,16,0,0,0,1.32-15.06l0-.12L97.54,33.64a16,16,0,0,0-16.62-9.52A56.26,56.26,0,0,0,32,80c0,79.4,64.6,144,144,144a56.26,56.26,0,0,0,55.88-48.92A16,16,0,0,0,222.37,158.46ZM176,208A128.14,128.14,0,0,1,48,80,40.2,40.2,0,0,1,82.87,40a.61.61,0,0,0,0,.12l21,47L83.2,111.86a6.13,6.13,0,0,0-.57.77,16,16,0,0,0-1,15.7c9.06,18.53,27.73,37.06,46.46,46.11a16,16,0,0,0,15.75-1.14,8.44,8.44,0,0,0,.74-.56L168.89,152l47,21.05h0s.08,0,.11,0A40.21,40.21,0,0,1,176,208Z">
                                        </path>
                                    </svg>
                                    <div class="text-neutral-700">-</div>
                                </div>
                                </div>
                            </div>
                        </div>

                        <div class="rounded border border-neutral-400 bg-white p-4 shadow-sm">
                            <span
                                class="inline-flex items-center rounded-full border border-red-200 bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                                {{ $entidadEtiqueta }}
                            </span>
                            <div class="mt-3 border-t border-neutral-400 pt-3">
                                <div class="space-y-2 text-sm text-neutral-700">
                                <div class="flex items-start gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor"
                                        class="mt-0.5 h-4 w-4 text-neutral-500">
                                        <path
                                            d="M230.92,212c-15.23-26.33-38.7-45.21-66.09-54.16a72,72,0,1,0-73.66,0C63.78,166.78,40.31,185.66,25.08,212a8,8,0,1,0,13.85,8c18.84-32.56,52.14-52,89.07-52s70.23,19.44,89.07,52a8,8,0,1,0,13.85-8ZM72,96a56,56,0,1,1,56,56A56.06,56.06,0,0,1,72,96Z">
                                        </path>
                                    </svg>
                                    <div>
                                        <div class="font-semibold text-neutral-800">
                                            {{ $coordinadoresInst->isNotEmpty() ? $coordinadoresInst->join(', ') : 'No se menciona' }}
                                        </div>
                                        <div class="text-xs text-neutral-500">Coordinacion institucion</div>
                                    </div>
                                </div>
                                <div class="flex items-start gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor"
                                        class="mt-0.5 h-4 w-4 text-neutral-500">
                                        <path
                                            d="M224,48H32a8,8,0,0,0-8,8V192a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V56A8,8,0,0,0,224,48ZM203.43,64,128,133.15,52.57,64ZM216,192H40V74.19l82.59,75.71a8,8,0,0,0,10.82,0L216,74.19V192Z">
                                        </path>
                                    </svg>
                                    <div class="text-neutral-700">-</div>
                                </div>
                                <div class="flex items-start gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor"
                                        class="mt-0.5 h-4 w-4 text-neutral-500">
                                        <path
                                            d="M222.37,158.46l-47.11-21.11-.13-.06a16,16,0,0,0-15.17,1.4,8.12,8.12,0,0,0-.75.56L134.87,160c-15.42-7.49-31.34-23.29-38.83-38.51l20.78-24.71c.2-.25.39-.5.57-.77a16,16,0,0,0,1.32-15.06l0-.12L97.54,33.64a16,16,0,0,0-16.62-9.52A56.26,56.26,0,0,0,32,80c0,79.4,64.6,144,144,144a56.26,56.26,0,0,0,55.88-48.92A16,16,0,0,0,222.37,158.46ZM176,208A128.14,128.14,0,0,1,48,80,40.2,40.2,0,0,1,82.87,40a.61.61,0,0,0,0,.12l21,47L83.2,111.86a6.13,6.13,0,0,0-.57.77,16,16,0,0,0-1,15.7c9.06,18.53,27.73,37.06,46.46,46.11a16,16,0,0,0,15.75-1.14,8.44,8.44,0,0,0,.74-.56L168.89,152l47,21.05h0s.08,0,.11,0A40.21,40.21,0,0,1,176,208Z">
                                        </path>
                                    </svg>
                                    <div class="text-neutral-700">-</div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </x-admin.block>
        @endif
    </div>
</x-admin-layout>
