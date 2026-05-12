<x-admin-layout>
    <div class="space-y-4">
        @if (session('error'))
            <div class="rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                {{ session('error') }}
            </div>
        @endif

        <x-admin.block>
            <div class="flex flex-col gap-2">
                <h1 class="text-neutral-600 text-2xl font-bold">Crear nuevo convenio</h1>
                <p class="text-neutral-600 text-sm">Completa los pasos para registrar un nuevo convenio</p>
            </div>
        </x-admin.block>

        @php
            $stepperIconConvenio = '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M254.3,107.91,228.78,56.85a16,16,0,0,0-21.47-7.15L182.44,62.13,130.05,48.27a8.14,8.14,0,0,0-4.1,0L73.56,62.13,48.69,49.7a16,16,0,0,0-21.47,7.15L1.7,107.9a16,16,0,0,0,7.15,21.47l27,13.51,55.49,39.63a8.06,8.06,0,0,0,2.71,1.25l64,16a8,8,0,0,0,7.6-2.1l55.07-55.08,26.42-13.21a16,16,0,0,0,7.15-21.46Zm-54.89,33.37L165,113.72a8,8,0,0,0-10.68.61C136.51,132.27,116.66,130,104,122L147.24,80h31.81l27.21,54.41ZM41.53,64,62,74.22,36.43,125.27,16,115.06Zm116,119.13L99.42,168.61l-49.2-35.14,28-56L128,64.28l9.8,2.59-45,43.68-.08.09a16,16,0,0,0,2.72,24.81c20.56,13.13,45.37,11,64.91-5L188,152.66Zm62-57.87-25.52-51L214.47,64,240,115.06Zm-87.75,92.67a8,8,0,0,1-7.75,6.06,8.13,8.13,0,0,1-1.95-.24L80.41,213.33a7.89,7.89,0,0,1-2.71-1.25L51.35,193.26a8,8,0,0,1,9.3-13l25.11,17.94L126,208.24A8,8,0,0,1,131.82,217.94Z"></path></svg>';
            $stepperIconInstitucion = '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M248,208H232V96a8,8,0,0,0,0-16H184V48a8,8,0,0,0,0-16H40a8,8,0,0,0,0,16V208H24a8,8,0,0,0,0,16H248a8,8,0,0,0,0-16ZM216,96V208H184V96ZM56,48H168V208H144V160a8,8,0,0,0-8-8H88a8,8,0,0,0-8,8v48H56Zm72,160H96V168h32ZM72,80a8,8,0,0,1,8-8H96a8,8,0,0,1,0,16H80A8,8,0,0,1,72,80Zm48,0a8,8,0,0,1,8-8h16a8,8,0,0,1,0,16H128A8,8,0,0,1,120,80ZM72,120a8,8,0,0,1,8-8H96a8,8,0,0,1,0,16H80A8,8,0,0,1,72,120Zm48,0a8,8,0,0,1,8-8h16a8,8,0,0,1,0,16H128A8,8,0,0,1,120,120Z"></path></svg>';
            $stepperIconDocumentos = '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M213.66,82.34l-56-56A8,8,0,0,0,152,24H56A16,16,0,0,0,40,40V216a16,16,0,0,0,16,16H200a16,16,0,0,0,16-16V88A8,8,0,0,0,213.66,82.34ZM160,51.31,188.69,80H160ZM200,216H56V40h88V88a8,8,0,0,0,8,8h48V216Zm-42.34-77.66a8,8,0,0,1-11.32,11.32L136,139.31V184a8,8,0,0,1-16,0V139.31l-10.34,10.35a8,8,0,0,1-11.32-11.32l24-24a8,8,0,0,1,11.32,0Z"></path></svg>';
        @endphp

        <div class="bg-white rounded border border-neutral-400">
            <x-admin.stepper :steps="[
                ['key' => 'info', 'label' => 'Convenio', 'description' => 'Datos generales', 'icon' => $stepperIconConvenio],
                ['key' => 'details', 'label' => 'Institución', 'description' => 'Entidad y coordinadores', 'icon' => $stepperIconInstitucion],
                ['key' => 'docs', 'label' => 'Documentación', 'description' => 'Archivos PDF requeridos', 'icon' => $stepperIconDocumentos],
            ]" current="1">
                <form id="form-crear-convenio" method="POST" action="{{ route('admin.convenios.store') }}"
                    enctype="multipart/form-data" class="space-y-3">
                    @csrf

                    {{-- Sección: Información principal del convenio (Paso 1) --}}
                    <section class="w-full" x-show="step === 1" x-cloak data-step-section="1">
                        <div class="p-5">
                            <div class="mb-4 flex items-start gap-2">
                                <span
                                    class="mt-0.5 inline-flex flex-none items-center justify-center text-brand-600 [&>svg]:h-[1em] [&>svg]:w-[1em] [&>svg]:fill-current">
                                    {!! $stepperIconConvenio !!}
                                </span>
                                <div class="min-w-0">
                                    <h2 class="text-sm font-semibold text-neutral-800">Información del Convenio</h2>
                                    <p class="mt-0.5 text-xs text-neutral-500">Completa los datos generales y la
                                        vigencia del convenio.</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                {{-- Título del convenio (texto largo) --}}
                                <div>
                                    <x-input-label for="titulo" value="Título del convenio" />
                                    <textarea id="titulo" name="titulo" rows="4" required
                                        class="mt-1 block min-h-[96px] w-full resize-y rounded-lg border border-neutral-300 bg-white px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                                        placeholder="Nombre del título del convenio">{{ old('titulo') }}</textarea>
                                    <x-input-error :messages="$errors->get('titulo')" class="mt-1" />
                                </div>

                                {{-- Tipo de convenio, Tipo de ámbito, Nro. de Transcripción y Estado --}}
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div>
                                        <x-input-label for="tipo_convenio_id" value="Tipo de convenio" />
                                        <select id="tipo_convenio_id" name="tipo_convenio_id" required
                                            class="mt-1 block w-full rounded-lg border border-neutral-300 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200">
                                            <option value="">Seleccionar tipo</option>
                                            @foreach ($tiposConvenio as $tipo)
                                                <option value="{{ $tipo->id }}" @selected(old('tipo_convenio_id') == $tipo->id)>
                                                    {{ $tipo->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('tipo_convenio_id')" class="mt-1" />
                                    </div>

                                    <div>
                                        <x-input-label for="ambito_id" value="Tipo de ámbito" />
                                        <select id="ambito_id" name="ambito_id" required
                                            class="mt-1 block w-full rounded-lg border border-neutral-300 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200">
                                            <option value="">Seleccionar ámbito</option>
                                            @foreach ($ambitos as $ambito)
                                                <option value="{{ $ambito->id }}" @selected(old('ambito_id') == $ambito->id)>
                                                    {{ $ambito->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('ambito_id')" class="mt-1" />
                                    </div>

                                    <div>
                                        <x-input-label for="resolucion" value="Nro. de Transcripción" />
                                        <x-text-input id="resolucion" name="resolucion" type="text"
                                            class="mt-1 block w-full rounded-lg border border-neutral-300 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                                            placeholder="Nro. de transcripción" :value="old('resolucion')" />
                                        <x-input-error :messages="$errors->get('resolucion')" class="mt-1" />
                                    </div>

                                </div>

                                {{-- Nacionalidad, Estado del convenio y beneficiarios --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="nacionalidad" value="Nacionalidad" />
                                        <x-text-input id="nacionalidad" name="nacionalidad" type="text"
                                            class="mt-1 block w-full rounded-lg border border-neutral-300 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                                            placeholder="Nombre del país" :value="old('nacionalidad')" />
                                        <x-input-error :messages="$errors->get('nacionalidad')" class="mt-1" />
                                    </div>

                                    <div>
                                        <x-input-label for="estado_convenio_id" value="Estado del convenio" />
                                        <select id="estado_convenio_id" name="estado_convenio_id" required
                                            class="mt-1 block w-full rounded-lg border border-neutral-300 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200">
                                            <option value="">Seleccionar estado</option>
                                            @foreach ($estadosConvenio as $estado)
                                                <option value="{{ $estado->id }}" @selected(old('estado_convenio_id') == $estado->id)>
                                                    {{ $estado->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('estado_convenio_id')" class="mt-1" />
                                    </div>
                                </div>

                                {{-- Dirigido a (beneficiarios), Fecha de suscripción, Duración y Tiempo para renovación --}}
                                <div>
                                    @php
                                        $beneficiariosOptions = collect($beneficiarios ?? [])
                                            ->map(function ($beneficiario) {
                                                return [
                                                    'id' => $beneficiario->id,
                                                    'label' =>
                                                        $beneficiario->nombre ??
                                                        ($beneficiario->codigo_beneficiario ??
                                                            'Beneficiario ' . $beneficiario->id),
                                                ];
                                            })
                                            ->values();
                                        $beneficiariosOld = collect(old('beneficiarios', []))
                                            ->filter(fn($v) => $v !== null && $v !== '')
                                            ->map(fn($v) => (int) $v)
                                            ->values();
                                    @endphp

                                    <x-admin.beneficiarios-multiselect
                                        label="Dirigido a"
                                        name="beneficiarios"
                                        :options="$beneficiariosOptions"
                                        :selected="$beneficiariosOld"
                                        :error-messages="$errors->get('beneficiarios')"
                                    />
                                </div>

                                {{-- Fecha de suscripción, Duración y Plazo de prórroga --}}
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <x-input-label for="fecha_inicio" value="Fecha de suscripción" />
                                        <x-text-input id="fecha_inicio" name="fecha_inicio" type="date"
                                            class="mt-1 block w-full rounded-lg border border-neutral-300 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                                            required :value="old('fecha_inicio')" />
                                        <x-input-error :messages="$errors->get('fecha_inicio')" class="mt-1" />
                                    </div>

                                    <div>
                                        <x-input-label for="duracion_valor" value="Duración" />
                                        <div class="mt-1 grid grid-cols-2 gap-2">
                                            <x-text-input id="duracion_valor" name="duracion_valor" type="number"
                                                min="1" step="1" required
                                                class="block w-full rounded-lg border border-neutral-300 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                                                placeholder="Valor" :value="old('duracion_valor')" />
                                            <select id="duracion_unidad" name="duracion_unidad" required
                                                class="block w-full rounded-lg border border-neutral-300 bg-white px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200">
                                                <option value="">Unidad</option>
                                                <option value="dias" @selected(old('duracion_unidad') === 'dias')>Días</option>
                                                <option value="semanas" @selected(old('duracion_unidad') === 'semanas')>Semanas</option>
                                                <option value="meses" @selected(old('duracion_unidad') === 'meses')>Meses</option>
                                                <option value="anios" @selected(old('duracion_unidad') === 'anios')>Años</option>
                                            </select>
                                        </div>
                                        <x-input-error :messages="$errors->get('duracion_valor')" class="mt-1" />
                                        <x-input-error :messages="$errors->get('duracion_unidad')" class="mt-1" />
                                    </div>

                                    <div>
                                        <x-input-label for="plazo_prorroga_valor" value="Plazo de prórroga" />
                                        <div class="mt-1 grid grid-cols-2 gap-2">
                                            <x-text-input id="plazo_prorroga_valor" name="plazo_prorroga_valor"
                                                type="number" min="1" step="1" required
                                                class="block w-full rounded-lg border border-neutral-300 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                                                placeholder="Valor" :value="old('plazo_prorroga_valor')" />
                                            <select id="plazo_prorroga_unidad" name="plazo_prorroga_unidad" required
                                                class="block w-full rounded-lg border border-neutral-300 bg-white px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200">
                                                <option value="">Unidad</option>
                                                <option value="dias" @selected(old('plazo_prorroga_unidad') === 'dias')>Días</option>
                                                <option value="semanas" @selected(old('plazo_prorroga_unidad') === 'semanas')>Semanas</option>
                                                <option value="meses" @selected(old('plazo_prorroga_unidad') === 'meses')>Meses</option>
                                            </select>
                                        </div>
                                        <x-input-error :messages="$errors->get('plazo_prorroga_valor')" class="mt-1" />
                                        <x-input-error :messages="$errors->get('plazo_prorroga_unidad')" class="mt-1" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- Sección: Información de la Institución colaboradora (Paso 2) --}}
                    <section class="space-y-3" x-show="step === 2" x-cloak data-step-section="2">
                        <div class="p-4 sm:p-5">
                            <div class="mb-4 flex items-start gap-2">
                                <span
                                    class="mt-0.5 inline-flex flex-none items-center justify-center text-brand-600 [&>svg]:h-[1em] [&>svg]:w-[1em] [&>svg]:fill-current">
                                    {!! $stepperIconInstitucion !!}
                                </span>
                                <div class="min-w-0">
                                    <h2 class="text-sm font-semibold text-neutral-800">Información de la Institución
                                        colaboradora</h2>
                                    <p class="mt-0.5 text-xs text-neutral-500">Datos de la institución externa,
                                        coordinadores y observaciones del convenio.</p>
                                </div>
                            </div>

                            <div class="space-y-3">
                                {{-- Institución/Entidad/Organismo --}}
                                <div>
                                    <x-input-label for="entidad_nombre" value="Institución/Entidad/Organismo" />
                                    <x-text-input id="entidad_nombre" name="entidad_nombre" type="text"
                                        class="mt-1 block w-full rounded-lg border border-neutral-300 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                                        placeholder="Nombre de la Institución" required :value="old('entidad_nombre')" />
                                    <x-input-error :messages="$errors->get('entidad_nombre')" class="mt-1" />
                                </div>

                                {{-- Tipo de Entidad y Nacionalidad --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="entidad_tipo" value="Tipo de Entidad" />
                                        <x-text-input id="entidad_tipo" name="entidad_tipo" type="text"
                                            class="mt-1 block w-full rounded-lg border border-neutral-300 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                                            placeholder="Tipo de entidad" :value="old('entidad_tipo')" />
                                        <x-input-error :messages="$errors->get('entidad_tipo')" class="mt-1" />
                                    </div>

                                    <div>
                                        <x-input-label for="nacionalidad" value="Nacionalidad" />
                                        <x-text-input id="nacionalidad" name="nacionalidad" type="text"
                                            class="mt-1 block w-full rounded-lg border border-neutral-300 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                                            placeholder="Nombre del país" :value="old('nacionalidad')" />
                                        <x-input-error :messages="$errors->get('nacionalidad')" class="mt-1" />
                                    </div>
                                </div>

                                {{-- Observación (solo visible si tipo de convenio es "específico") --}}
                                @php
                                    // Obtener el tipo de convenio "específico"
                                    $tipoConvenioEspecifico = $tiposConvenio?->where('nombre', 'específico')->first();
                                    $tipoConvenioEspecificoId = $tipoConvenioEspecifico?->id;
                                @endphp

                                <div x-data="{
                                    tipoEspecificoId: @js($tipoConvenioEspecificoId),
                                    checkVisibility() {
                                        const tipoSelect = document.querySelector('select[name=tipo_convenio_id]');
                                        return tipoSelect && parseInt(tipoSelect.value) === this.tipoEspecificoId;
                                    }
                                }" x-show="checkVisibility()"
                                    @step-changed.window="$nextTick(() => { if ($el.style.display !== 'none') { $el.style.display = 'block'; } })"
                                    x-cloak class="rounded-lg border border-neutral-300 bg-neutral-50/60 p-4">
                                    <x-input-label for="observaciones_prorroga" value="Observación" />
                                    <p class="mt-1 text-xs text-neutral-500">Solo visible si el tipo de convenio es
                                        "específico".</p>
                                        <textarea id="observaciones_prorroga" name="observaciones_prorroga" rows="3"
                                        class="mt-2 block w-full rounded-lg border border-neutral-300 bg-white px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                                        style="border-color: rgb(212 212 216) !important; border-style: solid !important;"
                                        placeholder="Observación sobre el convenio específico...">{{ old('observaciones_prorroga', old('observacion')) }}</textarea>
                                    <x-input-error :messages="$errors->get('observaciones_prorroga')" class="mt-1" />
                                </div>

                                {{-- Coordinadores --}}
                                <div class="rounded-lg border border-neutral-300 bg-neutral-50/60 p-4">
                                    <div class="mb-4 flex items-start justify-between gap-3">
                                        <div>
                                            <h3 class="text-sm font-semibold text-neutral-800">Coordinadores</h3>
                                            <p class="mt-0.5 text-xs text-neutral-500">Coordinador de la UNS y de la
                                                institución externa.</p>
                                        </div>
                                    </div>

                                    <div x-data="{
                                        coordinadores: @js(
                                            collect(old('coordinadores', []))
                                                ->map(function ($coord) {
                                                    return $coord ? (array) $coord : null;
                                                })
                                                ->filter()
                                                ->values()
                                                ->all() ?? [],
                                            ),
                                        agregarCoordinador() {
                                            this.coordinadores.push({ coordinador_uns: '', coordinador_institucion: '', no_se_menciona: false });
                                        },
                                        eliminarCoordinador(index) {
                                            this.coordinadores.splice(index, 1);
                                        }
                                    }" x-init="if (coordinadores.length === 0) agregarCoordinador()" class="space-y-3">
                                        <template x-for="(coord, index) in coordinadores" :key="index">
                                            <div
                                                class="flex flex-col gap-3 rounded-lg border border-neutral-300 bg-white p-3 md:flex-row md:items-end">
                                                <div class="flex-1">
                                                    <x-input-label value="Coordinador UNS" />
                                                    <x-text-input name="coordinador_uns[]" type="text"
                                                        class="mt-1 block w-full rounded-lg border border-neutral-300 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                                                        placeholder="Nombre del coordinador UNS" />
                                                </div>

                                                <div class="flex-1">
                                                    <x-input-label value="Coordinador Institución" />
                                                    <x-text-input name="coordinador_institucion[]" type="text"
                                                        class="mt-1 block w-full rounded-lg border border-neutral-300 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                                                        placeholder="Nombre del coordinador institución" />
                                                </div>

                                                <div class="flex items-end gap-2">
                                                    <label
                                                        class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-neutral-700">
                                                        <input type="checkbox" name="no_se_menciona[]" value="1"
                                                            class="rounded-lg border-neutral-300" />
                                                        No se menciona
                                                    </label>
                                                </div>

                                                <button type="button" @click="eliminarCoordinador(index)"
                                                    class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-red-200 bg-white text-red-600 hover:bg-red-50"
                                                    aria-label="Eliminar coordinador">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"
                                                        fill="currentColor" class="h-4 w-4">
                                                        <path
                                                            d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16h8V208a16,16,0,0,0,16,16H192a16,16,0,0,0,16-16V64h8a8,8,0,0,0,0-16ZM96,40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96Zm96,168H64V64H192Z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </template>

                                        <button type="button" @click="agregarCoordinador()"
                                            class="inline-flex items-center gap-2 rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm font-medium text-neutral-700 hover:bg-neutral-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"
                                                fill="currentColor" class="h-4 w-4">
                                                <path
                                                    d="M232,128a8,8,0,0,1-8,8H136v88a8,8,0,0,1-16,0V136H32a8,8,0,0,1,0-16H120V32a8,8,0,0,1,16,0v88h88A8,8,0,0,1,232,128Z">
                                                </path>
                                            </svg>
                                            Agregar coordinador
                                        </button>
                                    </div>
                                    <p class="mt-2 text-xs text-neutral-500">Puedes agregar múltiples coordinadores o
                                        marcar "No se menciona" si no aplica.</p>
                                </div>

                                <details class="rounded-lg border border-neutral-300 bg-neutral-50/60">
                                    <summary
                                        class="cursor-pointer select-none px-3 py-2 text-sm font-medium text-neutral-700">
                                        Objetivo (opcional)
                                    </summary>
                                    <div class="px-3 pb-3">
                                        <p class="text-xs text-neutral-500">Si aplica, describe el objetivo del
                                            convenio específico.</p>
                                        <textarea id="objetivo_personalizado" name="objetivo_personalizado" rows="3"
                                            class="mt-2 block w-full rounded-lg border border-neutral-300 bg-white px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                                            placeholder="Describe el objetivo del convenio.">{{ old('objetivo_personalizado') }}</textarea>
                                        <x-input-error :messages="$errors->get('objetivo_personalizado')" class="mt-1" />
                                    </div>
                                </details>
                            </div>
                        </div>
                    </section>

                    {{-- Sección: Archivos PDF / Documentos (Paso 3) --}}
                    <section class="space-y-3" x-show="step === 3" x-cloak data-step-section="3">
                        <div class="p-4 sm:p-5">
                            <div class="mb-4 flex items-start gap-2">
                                <span
                                    class="mt-0.5 inline-flex flex-none items-center justify-center text-brand-600 [&>svg]:h-[1em] [&>svg]:w-[1em] [&>svg]:fill-current">
                                    {!! $stepperIconDocumentos !!}
                                </span>
                                <div class="min-w-0">
                                    <h2 class="text-sm font-semibold text-neutral-800">Documentación</h2>
                                    <p class="mt-0.5 text-xs text-neutral-500">Adjunta los documentos requeridos (PDF).
                                    </p>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                    <x-admin.file-dropzone label="Resolución (PDF)" name="archivo_uno" required />
                                    <x-admin.file-dropzone label="Convenio (PDF)" name="archivo_dos" required />
                                </div>

                                <div class="rounded border border-neutral-400 bg-neutral-100 px-4 py-4">
                                    <div class="flex items-start gap-3">
                                        <div>
                                            <p class="text-sm font-semibold text-neutral-800">Antes de guardar</p>
                                            <p class="mt-1 text-sm text-neutral-600">Verifica que los documentos sean
                                                legibles y correspondan al convenio descrito en los pasos anteriores.
                                                Una vez guardado, podrás editar la información pero no eliminar el
                                                convenio.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="flex items-center justify-between gap-2 px-4 pb-4 sm:px-5">
                        <div>
                            <x-admin.cancel-button type="button" @click="$dispatch('wizard-prev')" x-show="step > 1"
                                x-cloak>
                                Anterior
                            </x-admin.cancel-button>
                        </div>

                        <div class="flex items-center gap-2">
                            <x-admin.confirm-button type="button" @click="$dispatch('wizard-next')"
                                x-show="step < maxStep" x-cloak>
                                Siguiente
                            </x-admin.confirm-button>

                            <div class="flex items-center gap-2" x-show="step === maxStep" x-cloak>
                                <x-admin.cancel-button
                                    @click="window.location.href='{{ route('admin.convenios.index') }}'">
                                    Cancelar
                                </x-admin.cancel-button>

                                <x-admin.confirm-button type="submit">
                                    Guardar
                                </x-admin.confirm-button>
                            </div>
                        </div>
                    </div>
                </form>
            </x-admin.stepper>
        </div>
    </div>
</x-admin-layout>
