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
                <p class="text-neutral-600 text-sm">Completa los pasos para registrar un nuevo convenio académico o de investigación</p>
            </div>
        </x-admin.block>

        <div class="bg-white rounded border border-neutral-400">
            <x-admin.stepper :steps="[
                ['key' => 'info', 'label' => 'General'],
                ['key' => 'details', 'label' => 'Detalles'],
                ['key' => 'docs', 'label' => 'Documentación'],
            ]" current="1">
    <form
        id="form-crear-convenio"
        method="POST"
        action="{{ route('admin.convenios.store') }}"
        enctype="multipart/form-data"
        class="space-y-3"
        x-data="{
            step: 1,
            maxStep: 3,
            notice: '',
            noticeTimeout: null,
            canShowFinalActions: false,

            setStep(to) {
                const next = Math.min(this.maxStep, Math.max(1, to));
                this.step = next;
                this.$dispatch('step-changed', { step: next });
                this.refreshFinalStepValidity();
            },

            showNotice(message) {
                this.notice = message;
                if (this.noticeTimeout) clearTimeout(this.noticeTimeout);
                this.noticeTimeout = setTimeout(() => { this.notice = ''; }, 3500);
            },

            validateStep(stepIndex, shouldReport = true) {
                const section = this.$el.querySelector(`[data-step-section='${stepIndex}']`);
                if (!section) return true;

                const elements = Array.from(section.querySelectorAll('input, select, textarea'))
                    .filter((el) => !el.disabled)
                    .filter((el) => el.type !== 'hidden');

                for (const el of elements) {
                    if (!el.checkValidity()) {
                        if (shouldReport) {
                            el.reportValidity();
                        }
                        return false;
                    }
                }

                return true;
            },

            refreshFinalStepValidity() {
                if (this.step !== this.maxStep) {
                    this.canShowFinalActions = false;
                    return;
                }

                this.canShowFinalActions = this.validateStep(this.maxStep, false);
            },

            handleStepRequested(event) {
                const to = Number(event.detail?.step);
                if (!Number.isFinite(to)) return;

                // Ir hacia atrás siempre está permitido
                if (to <= this.step) {
                    this.setStep(to);
                    return;
                }

                // Hacia adelante: solo se permite avanzar 1 paso y si el actual es válido
                if (to !== this.step + 1) {
                    this.showNotice('Debes completar el paso actual antes de saltar. Avanza en secuencia (1 → 2 → 3).');
                    return;
                }
                if (!this.validateStep(this.step, true)) {
                    this.showNotice('Hay campos pendientes en este paso. Completa lo requerido para continuar.');
                    return;
                }

                this.setStep(to);
            },

            next() {
                this.handleStepRequested({ detail: { step: this.step + 1 } });
            },

            prev() {
                this.setStep(this.step - 1);
            },

            validateAllAndSubmit() {
                for (let i = 1; i <= this.maxStep; i++) {
                    if (!this.validateStep(i, true)) {
                        this.setStep(i);
                        this.showNotice('Completa los campos requeridos antes de crear el convenio.');
                        return;
                    }
                }

                this.$el.submit();
            },
        }"
        x-init="$nextTick(() => refreshFinalStepValidity())"
        x-on:step-requested.window="handleStepRequested($event)"
        x-on:wizard-next.window="next()"
        x-on:wizard-prev.window="prev()"
        x-on:input.debounce.150ms="refreshFinalStepValidity()"
        x-on:change="refreshFinalStepValidity()"
        x-on:submit.prevent="validateAllAndSubmit()"
    >
        @csrf

        <div
            x-show="notice"
            x-transition
            x-cloak
            class="rounded-md border border-amber-200 bg-amber-50 px-3 py-2 text-sm text-amber-900"
            x-text="notice"
        ></div>
        {{-- Sección: Información básica del convenio (Paso 1) --}}
        <section class="w-full" x-show="step === 1" x-cloak data-step-section="1">
            <div class="p-5">
                {{-- <div class="mb-4 flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-sm font-semibold text-neutral-800">General</h2>
                        <p class="mt-0.5 text-xs text-neutral-500">Datos generales del convenio y la entidad.</p>
                    </div>
                </div> --}}

                <div class="space-y-4">
                    {{-- Título del convenio (texto largo) --}}
                    <div>
                        <x-input-label for="titulo" value="Título del convenio" />
                        <textarea
                            id="titulo"
                            name="titulo"
                            rows="4"
                            required
                            class="mt-1 block min-h-[96px] w-full resize-y rounded-lg border border-neutral-200 bg-white px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                            placeholder="Nombre del título del convenio"
                        >{{ old('titulo') }}</textarea>
                        <x-input-error :messages="$errors->get('titulo')" class="mt-1" />
                    </div>

                    {{-- Tipo de convenio, Tipo de ámbito y Nro. de Transcripción de Resolución --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="tipo_convenio_id" value="Tipo de convenio"/>
                            <select
                                id="tipo_convenio_id"
                                name="tipo_convenio_id"
                                required
                                class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                            >
                                <option value="">Seleccionar tipo</option>
                                @foreach($tiposConvenio as $tipo)
                                    <option
                                        value="{{ $tipo->id }}"
                                        @selected(old('tipo_convenio_id') == $tipo->id)
                                    >
                                        {{ $tipo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('tipo_convenio_id')" class="mt-1"/>
                        </div>

                        <div>
                            <x-input-label for="ambito_id" value="Tipo de ámbito"/>
                            <select
                                id="ambito_id"
                                name="ambito_id"
                                required
                                class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                            >
                                <option value="">Seleccionar ámbito</option>
                                @foreach($ambitos as $ambito)
                                    <option
                                        value="{{ $ambito->id }}"
                                        @selected(old('ambito_id') == $ambito->id)
                                    >
                                        {{ $ambito->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('ambito_id')" class="mt-1"/>
                        </div>

                        <div>
                            <x-input-label for="resolucion" value="Nro. de Transcripción"/>
                            <x-text-input
                                id="resolucion"
                                name="resolucion"
                                type="text"
                                class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                                placeholder="Nro. de transcripción"
                                :value="old('resolucion')"
                            />
                            <x-input-error :messages="$errors->get('resolucion')" class="mt-1"/>
                        </div>
                    </div>

                    {{-- Institución/Entidad/Organismo --}}
                    <div>
                        <x-input-label for="entidad_nombre" value="Institución/Entidad/Organismo"/>
                        <x-text-input
                            id="entidad_nombre"
                            name="entidad_nombre"
                            type="text"
                            class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                            placeholder="Nombre de la Institución"
                            required
                            :value="old('entidad_nombre')"
                        />
                        <x-input-error :messages="$errors->get('entidad_nombre')" class="mt-1"/>
                    </div>

                    {{-- Nacionalidad y Estado del convenio --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="nacionalidad" value="Nacionalidad"/>
                            <x-text-input
                                id="nacionalidad"
                                name="nacionalidad"
                                type="text"
                                class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                                placeholder="Nombre del país"
                                :value="old('nacionalidad')"
                            />
                            <x-input-error :messages="$errors->get('nacionalidad')" class="mt-1"/>
                        </div>

                        <div>
                            <x-input-label for="estado_convenio_id" value="Estado del convenio"/>
                            <select
                                id="estado_convenio_id"
                                name="estado_convenio_id"
                                required
                                class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                            >
                                <option value="">Seleccionar estado</option>
                                @foreach($estadosConvenio as $estado)
                                    <option
                                        value="{{ $estado->id }}"
                                        @selected(old('estado_convenio_id') == $estado->id)
                                    >
                                        {{ $estado->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('estado_convenio_id')" class="mt-1"/>
                        </div>
                    </div>

                    {{-- Dirigido a (beneficiarios), Fecha de suscripción, Duración y Tiempo para renovación --}}
                    <div>
                        <x-input-label for="beneficiarios_general" value="Dirigido a" />
                        @php
                            $beneficiariosOptions = collect($beneficiarios ?? [])->map(function ($beneficiario) {
                                return [
                                    'id' => $beneficiario->id,
                                    'label' => $beneficiario->nombre
                                        ?? $beneficiario->codigo_beneficiario
                                        ?? ('Beneficiario ' . $beneficiario->id),
                                ];
                            })->values();
                            $beneficiariosOld = collect(old('beneficiarios', []))
                                ->filter(fn ($v) => $v !== null && $v !== '')
                                ->map(fn ($v) => (int) $v)
                                ->values();
                        @endphp

                        <div
                            class="relative mt-1"
                            x-data="{
                                open: false,
                                options: @js($beneficiariosOptions),
                                selected: @js($beneficiariosOld),

                                isSelected(id) { return this.selected.includes(Number(id)); },
                                toggle(id) {
                                    id = Number(id);
                                    if (this.isSelected(id)) {
                                        this.selected = this.selected.filter((v) => v !== id);
                                    } else {
                                        this.selected = [...this.selected, id];
                                    }
                                },
                                remove(id) {
                                    id = Number(id);
                                    this.selected = this.selected.filter((v) => v !== id);
                                },
                                labelFor(id) {
                                    id = Number(id);
                                    const opt = this.options.find((o) => Number(o.id) === id);
                                    return opt ? opt.label : id;
                                },
                            }"
                        >
                            <div
                                id="beneficiarios_general"
                                role="combobox"
                                aria-haspopup="listbox"
                                x-bind:aria-expanded="open"
                                tabindex="0"
                                @click="open = true"
                                @keydown.enter.prevent="open = !open"
                                @keydown.escape.prevent="open = false"
                                class="min-h-[42px] w-full rounded-lg border border-neutral-200 bg-white px-3 py-2 text-[13px] focus-within:border-red-400 focus-within:ring-2 focus-within:ring-red-200"
                            >
                                <div class="flex flex-wrap items-center gap-1.5">
                                    <template x-for="id in selected" :key="id">
                                        <span class="inline-flex items-center gap-1 rounded-md bg-neutral-100 px-2 py-1 text-[12px] text-neutral-700">
                                            <span x-text="labelFor(id)"></span>
                                            <button
                                                type="button"
                                                class="ml-0.5 inline-flex h-4 w-4 items-center justify-center rounded text-neutral-500 hover:text-neutral-700"
                                                @click.stop="remove(id)"
                                                aria-label="Quitar"
                                            >
                                                &times;
                                            </button>
                                        </span>
                                    </template>

                                    <span x-show="selected.length === 0" class="text-neutral-400">Selecciona beneficiarios</span>
                                </div>
                            </div>

                            <div
                                x-show="open"
                                x-transition.origin.top
                                x-cloak
                                @click.outside="open = false"
                                class="absolute z-50 mt-1 w-full rounded-lg border border-neutral-200 bg-white shadow-sm"
                                role="listbox"
                            >
                                <ul class="max-h-52 overflow-y-auto py-1">
                                    <template x-for="opt in options" :key="opt.id">
                                        <li>
                                            <button
                                                type="button"
                                                class="flex w-full items-center justify-between px-3 py-2 text-left text-sm hover:bg-neutral-50"
                                                :class="isSelected(opt.id) ? 'bg-red-50/50' : ''"
                                                @click="toggle(opt.id)"
                                            >
                                                <span class="text-neutral-700" x-text="opt.label"></span>
                                                <span class="text-xs text-neutral-400" x-show="isSelected(opt.id)">✓</span>
                                            </button>
                                        </li>
                                    </template>
                                </ul>
                            </div>

                            <template x-for="id in selected" :key="'hidden-' + id">
                                <input type="hidden" name="beneficiarios[]" :value="id" />
                            </template>
                        </div>
                        <x-input-error :messages="$errors->get('beneficiarios')" class="mt-1" />
                    </div>

                    {{-- Fecha de suscripción, Duración y Plazo de prórroga --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="fecha_inicio" value="Fecha de suscripción"/>
                            <x-text-input
                                id="fecha_inicio"
                                name="fecha_inicio"
                                type="date"
                                class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                                required
                                :value="old('fecha_inicio')"
                            />
                            <x-input-error :messages="$errors->get('fecha_inicio')" class="mt-1"/>
                        </div>

                        <div>
                            <x-input-label for="duracion_valor" value="Duración"/>
                            <div class="mt-1 grid grid-cols-2 gap-2">
                                <x-text-input
                                    id="duracion_valor"
                                    name="duracion_valor"
                                    type="number"
                                    min="1"
                                    step="1"
                                    required
                                    class="block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                                    placeholder="Valor"
                                    :value="old('duracion_valor')"
                                />
                                <select
                                    id="duracion_unidad"
                                    name="duracion_unidad"
                                    required
                                    class="block w-full rounded-lg border border-neutral-200 bg-white px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                                >
                                    <option value="">Unidad</option>
                                    <option value="dias" @selected(old('duracion_unidad') === 'dias')>Días</option>
                                    <option value="semanas" @selected(old('duracion_unidad') === 'semanas')>Semanas</option>
                                    <option value="meses" @selected(old('duracion_unidad') === 'meses')>Meses</option>
                                    <option value="anios" @selected(old('duracion_unidad') === 'anios')>Años</option>
                                </select>
                            </div>
                            <x-input-error :messages="$errors->get('duracion_valor')" class="mt-1"/>
                            <x-input-error :messages="$errors->get('duracion_unidad')" class="mt-1"/>
                        </div>

                        <div>
                            <x-input-label for="plazo_prorroga_valor" value="Plazo de prórroga"/>
                            <div class="mt-1 grid grid-cols-2 gap-2">
                                <x-text-input
                                    id="plazo_prorroga_valor"
                                    name="plazo_prorroga_valor"
                                    type="number"
                                    min="1"
                                    step="1"
                                    required
                                    class="block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                                    placeholder="Valor"
                                    :value="old('plazo_prorroga_valor')"
                                />
                                <select
                                    id="plazo_prorroga_unidad"
                                    name="plazo_prorroga_unidad"
                                    required
                                    class="block w-full rounded-lg border border-neutral-200 bg-white px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                                >
                                    <option value="">Unidad</option>
                                    <option value="dias" @selected(old('plazo_prorroga_unidad') === 'dias')>Días</option>
                                    <option value="semanas" @selected(old('plazo_prorroga_unidad') === 'semanas')>Semanas</option>
                                    <option value="meses" @selected(old('plazo_prorroga_unidad') === 'meses')>Meses</option>
                                </select>
                            </div>
                            <x-input-error :messages="$errors->get('plazo_prorroga_valor')" class="mt-1"/>
                            <x-input-error :messages="$errors->get('plazo_prorroga_unidad')" class="mt-1"/>
                        </div>
                    </div>

                    {{-- Fecha de vencimiento (se calcula en el backend) --}}
                    <div>
                        <x-input-label for="fecha_fin" value="Fecha de vencimiento"/>
                        <x-text-input
                            id="fecha_fin"
                            name="fecha_fin"
                            type="date"
                            class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] bg-neutral-50"
                            readonly
                            :value="old('fecha_fin')"
                        />
                        <p class="mt-1 text-xs text-neutral-500">Se calcula automáticamente en el servidor basándose en la fecha de suscripción y la duración.</p>
                        <x-input-error :messages="$errors->get('fecha_fin')" class="mt-1"/>
                    </div>

                </div>
            </div>
        </section>

        {{-- Detalles del Convenio (Paso 2) --}}
        <section class="space-y-3" x-show="step === 2" x-cloak data-step-section="2">
            <div class="p-4 sm:p-5">
                <div class="mb-4 flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-sm font-semibold text-neutral-800">Detalles</h2>
                        <p class="mt-0.5 text-xs text-neutral-500">Información adicional y objetivo específico del convenio.</p>
                    </div>
                </div>

                <div class="space-y-3">
                    {{-- Observación (solo visible si tipo de convenio es "específico") --}}
                    @php
                        // Obtener el tipo de convenio "específico"
                        $tipoConvenioEspecifico = $tiposConvenio?->where('nombre', 'específico')->first();
                        $tipoConvenioEspecificoId = $tipoConvenioEspecifico?->id;
                    @endphp

                    <div
                        x-data="{
                            tipoEspecificoId: @js($tipoConvenioEspecificoId),
                            checkVisibility() {
                                const tipoSelect = document.querySelector('select[name=tipo_convenio_id]');
                                return tipoSelect && parseInt(tipoSelect.value) === this.tipoEspecificoId;
                            }
                        }"
                        x-show="checkVisibility()"
                        @step-changed.window="$nextTick(() => { if ($el.style.display !== 'none') { $el.style.display = 'block'; } })"
                        x-cloak
                        class="rounded-lg border border-neutral-200 bg-neutral-50/60 p-4"
                    >
                        <x-input-label for="observacion" value="Observación"/>
                        <p class="mt-1 text-xs text-neutral-500">Solo visible si el tipo de convenio es "específico".</p>
                        <textarea
                            id="observacion"
                            name="observacion"
                            rows="3"
                            class="mt-2 block w-full rounded-lg border border-neutral-200 bg-white px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                            placeholder="Observación sobre el convenio específico..."
                        >{{ old('observacion') }}</textarea>
                        <x-input-error :messages="$errors->get('observacion')" class="mt-1" />
                    </div>

                    {{-- Coordinadores --}}
                    <div class="rounded-lg border border-neutral-200 bg-neutral-50/60 p-4">
                        <div class="mb-4 flex items-start justify-between gap-3">
                            <div>
                                <h3 class="text-sm font-semibold text-neutral-800">Coordinadores</h3>
                                <p class="mt-0.5 text-xs text-neutral-500">Coordinador de la UNS y de la institución externa.</p>
                            </div>
                        </div>

                        <div
                            x-data="{
                                coordinadores: @js(
                                    collect(old('coordinadores', []))->map(function($coord) {
                                        return $coord ? (array)$coord : null;
                                    })->filter()->values()->all() ?? []
                                ),
                                agregarCoordinador() {
                                    this.coordinadores.push({ coordinador_uns: '', coordinador_institucion: '', no_se_menciona: false });
                                },
                                eliminarCoordinador(index) {
                                    this.coordinadores.splice(index, 1);
                                }
                            }"
                            x-init="if (coordinadores.length === 0) agregarCoordinador()"
                            class="space-y-3"
                        >
                            <template x-for="(coord, index) in coordinadores" :key="index">
                                <div class="flex flex-col gap-3 rounded-lg border border-neutral-200 bg-white p-3 md:flex-row md:items-end">
                                    <div class="flex-1">
                                        <x-input-label value="Coordinador UNS"/>
                                        <x-text-input
                                            name="coordinador_uns[]"
                                            type="text"
                                            class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                                            placeholder="Nombre del coordinador UNS"
                                        />
                                    </div>

                                    <div class="flex-1">
                                        <x-input-label value="Coordinador Institución"/>
                                        <x-text-input
                                            name="coordinador_institucion[]"
                                            type="text"
                                            class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                                            placeholder="Nombre del coordinador institución"
                                        />
                                    </div>

                                    <div class="flex items-end gap-2">
                                        <label class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-neutral-700">
                                            <input
                                                type="checkbox"
                                                name="no_se_menciona[]"
                                                value="1"
                                                class="rounded border-neutral-200"
                                            />
                                            No se menciona
                                        </label>
                                    </div>

                                    <button
                                        type="button"
                                        @click="eliminarCoordinador(index)"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-red-200 bg-white text-red-600 hover:bg-red-50"
                                        aria-label="Eliminar coordinador"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor" class="h-4 w-4">
                                            <path d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16h8V208a16,16,0,0,0,16,16H192a16,16,0,0,0,16-16V64h8a8,8,0,0,0,0-16ZM96,40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96Zm96,168H64V64H192Z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </template>

                            <button
                                type="button"
                                @click="agregarCoordinador()"
                                class="inline-flex items-center gap-2 rounded-md border border-neutral-200 bg-white px-3 py-2 text-sm font-medium text-neutral-700 hover:bg-neutral-50"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor" class="h-4 w-4">
                                    <path d="M232,128a8,8,0,0,1-8,8H136v88a8,8,0,0,1-16,0V136H32a8,8,0,0,1,0-16H120V32a8,8,0,0,1,16,0v88h88A8,8,0,0,1,232,128Z"></path>
                                </svg>
                                Agregar coordinador
                            </button>
                        </div>
                        <p class="mt-2 text-xs text-neutral-500">Puedes agregar múltiples coordinadores o marcar "No se menciona" si no aplica.</p>
                    </div>

                    <details class="rounded-lg border border-neutral-200 bg-neutral-50/60">
                        <summary class="cursor-pointer select-none px-3 py-2 text-sm font-medium text-neutral-700">
                            Objetivo (opcional)
                        </summary>
                        <div class="px-3 pb-3">
                            <p class="text-xs text-neutral-500">Si aplica, describe el objetivo del convenio específico.</p>
                            <textarea
                                id="objetivo_personalizado"
                                name="objetivo_personalizado"
                                rows="3"
                                class="mt-2 block w-full rounded-lg border border-neutral-200 bg-white px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                                placeholder="Describe el objetivo del convenio."
                            >{{ old('objetivo_personalizado') }}</textarea>
                            <x-input-error :messages="$errors->get('objetivo_personalizado')" class="mt-1" />
                        </div>
                    </details>
                </div>
            </div>
        </section>

        {{-- Sección: Archivos PDF / Documentos (Paso 3) --}}
        <section class="space-y-3" x-show="step === 3" x-cloak data-step-section="3">
            <div class="p-4 sm:p-5">
                <div class="mb-4 flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-sm font-semibold text-neutral-800">Documentación</h2>
                        <p class="mt-0.5 text-xs text-neutral-500">Adjunta los documentos requeridos (PDF).</p>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label value="Archivo 1 (PDF)"/>
                            <input
                                type="file"
                                name="archivo_uno"
                                accept="application/pdf"
                                required
                                class="mt-1 block w-full text-sm text-neutral-700 file:mr-4 file:rounded-md file:border-0 file:bg-neutral-100 file:px-3 file:py-2 file:text-sm file:font-medium file:text-neutral-700 hover:file:bg-neutral-200"
                            >
                        </div>

                        <div>
                            <x-input-label value="Archivo 2 (PDF)"/>
                            <input
                                type="file"
                                name="archivo_dos"
                                accept="application/pdf"
                                required
                                class="mt-1 block w-full text-sm text-neutral-700 file:mr-4 file:rounded-md file:border-0 file:bg-neutral-100 file:px-3 file:py-2 file:text-sm file:font-medium file:text-neutral-700 hover:file:bg-neutral-200"
                            >
                        </div>
                    </div>
                    <p class="text-xs text-neutral-500">Solo PDF. Máximo 5 MB por archivo.</p>
                </div>
            </div>
        </section>

        <div class="flex items-center justify-end gap-2 px-4 pb-4 sm:px-5" x-show="step === maxStep && canShowFinalActions" x-cloak>

            <x-admin.cancel-button onclick="window.location.href='{{ route('admin.convenios.index') }}'">
                Cancelar
            </x-admin.cancel-button>

            <x-admin.confirm-button type="submit">
                Guardar
            </x-admin.confirm-button>
        </div>
    </form>
            </x-admin.stepper>
        </div>
    </div>
</x-admin-layout>
