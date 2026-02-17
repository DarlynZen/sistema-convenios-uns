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

            setStep(to) {
                const next = Math.min(this.maxStep, Math.max(1, to));
                this.step = next;
                this.$dispatch('step-changed', { step: next });
            },

            showNotice(message) {
                this.notice = message;
                if (this.noticeTimeout) clearTimeout(this.noticeTimeout);
                this.noticeTimeout = setTimeout(() => { this.notice = ''; }, 3500);
            },

            validateStep(stepIndex) {
                const section = this.$el.querySelector(`[data-step-section='${stepIndex}']`);
                if (!section) return true;

                const elements = Array.from(section.querySelectorAll('input, select, textarea'))
                    .filter((el) => !el.disabled)
                    .filter((el) => el.type !== 'hidden');

                for (const el of elements) {
                    if (!el.checkValidity()) {
                        el.reportValidity();
                        return false;
                    }
                }

                return true;
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
                if (!this.validateStep(this.step)) {
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
                    if (!this.validateStep(i)) {
                        this.setStep(i);
                        this.showNotice('Completa los campos requeridos antes de crear el convenio.');
                        return;
                    }
                }

                this.$el.submit();
            },
        }"
        x-on:step-requested.window="handleStepRequested($event)"
        x-on:wizard-next.window="next()"
        x-on:wizard-prev.window="prev()"
        x-on:open-modal.window="if ($event.detail === 'crearConvenio') { notice=''; setStep(1); }"
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
        <section class="space-y-3" x-show="step === 1" x-cloak data-step-section="1">
            <div class="rounded-lg border border-neutral-200 bg-white p-4 sm:p-5">
                <div class="mb-4 flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-sm font-semibold text-neutral-800">General</h2>
                        <p class="mt-0.5 text-xs text-neutral-500">Datos generales del convenio y la entidad.</p>
                    </div>
                    <span class="text-xs text-neutral-500">Paso 1 de 3</span>
                </div>

                <div class="space-y-3">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Título del convenio --}}
                        <div>
                            <x-input-label for="titulo" value="Título del convenio" />
                            <x-text-input
                                id="titulo"
                                name="titulo"
                                type="text"
                                class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                                placeholder="Nombre del título del convenio"
                                required
                                :value="old('titulo')"
                            />
                            <x-input-error :messages="$errors->get('titulo')" class="mt-1" />
                        </div>

                        {{-- Nro. de Transcripción de Resolución --}}
                        <div>
                            <x-input-label for="resolucion" value="Nro. de Transcripción de Resolución"/>
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

                    {{-- Tipo de convenio y Tipo de ámbito --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                </div>
            </div>
        </section>

        {{-- Detalles del Convenio (Paso 2) --}}
        <section class="space-y-3" x-show="step === 2" x-cloak data-step-section="2">
            <div class="rounded-lg border border-neutral-200 bg-white p-4 sm:p-5">
                <div class="mb-4 flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-sm font-semibold text-neutral-800">Detalles</h2>
                        <p class="mt-0.5 text-xs text-neutral-500">Beneficiarios, fechas y datos adicionales.</p>
                    </div>
                    <span class="text-xs text-neutral-500">Paso 2 de 3</span>
                </div>

                <div class="space-y-3">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        {{-- Dirigido a (beneficiarios) --}}
                        <div>
                            <x-input-label for="beneficiarios" value="Dirigido a" />
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
                                    id="beneficiarios"
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

                        {{-- Fecha de Inicio --}}
                        <div>
                            <x-input-label for="fecha_inicio" value="Fecha de inicio" />
                            <x-text-input
                                id="fecha_inicio"
                                name="fecha_inicio"
                                type="date"
                                class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                                required
                                :value="old('fecha_inicio')"
                            />
                            <x-input-error :messages="$errors->get('fecha_inicio')" class="mt-1" />
                        </div>

                        {{-- Fecha de Vencimiento --}}
                        <div>
                            <x-input-label for="fecha_fin" value="Fecha de vencimiento" />
                            <x-text-input
                                id="fecha_fin"
                                name="fecha_fin"
                                type="date"
                                class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                                :value="old('fecha_fin')"
                            />
                            <x-input-error :messages="$errors->get('fecha_fin')" class="mt-1" />
                        </div>
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
            <div class="rounded-lg border border-neutral-200 bg-white p-4 sm:p-5">
                <div class="mb-4 flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-sm font-semibold text-neutral-800">Documentación</h2>
                        <p class="mt-0.5 text-xs text-neutral-500">Adjunta los documentos requeridos (PDF).</p>
                    </div>
                    <span class="text-xs text-neutral-500">Paso 3 de 3</span>
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
    </form>
</x-admin.stepper>
