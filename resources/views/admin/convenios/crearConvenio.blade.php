<x-admin.stepper :steps="[
    ['key' => 'info', 'label' => 'Información básica'],
    ['key' => 'details', 'label' => 'Detalles del Convenio'],
    ['key' => 'docs', 'label' => 'Documentación adjunta'],
]" current="1">
    <form
        id="form-crear-convenio"
        method="POST"
        action="{{ route('admin.convenios.store') }}"
        enctype="multipart/form-data"
        class="space-y-4"
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
        <section class="space-y-3 mb-4" x-show="step === 1" x-cloak data-step-section="1">
            <div class="border border-red-100 rounded-lg bg-red-50/40">
                <header class="flex items-center gap-2 px-4 py-3 border-b border-red-100 bg-red-50">
                    <span
                        class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-red-100 text-red-600 text-sm font-semibold">1</span>
                    <h2 class="text-sm font-semibold text-red-700">Información básica</h2>
                </header>

                <div class="p-4 space-y-4">
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
        <section class="space-y-3 mb-4" x-show="step === 2" x-cloak data-step-section="2">
            <div class="border border-red-100 rounded-lg bg-red-50/40">
                <header class="flex items-center gap-2 px-4 py-3 border-b border-red-100 bg-red-50">
                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-red-100 text-red-600 text-sm font-semibold">2</span>
                    <h2 class="text-sm font-semibold text-red-700">Detalles del Convenio</h2>
                </header>

                <div class="p-4 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        {{-- Dirigido a (beneficiarios) --}}
                        <div>
                            <x-input-label for="beneficiarios" value="Dirigido a" />
                            <select
                                id="beneficiarios"
                                name="beneficiarios[]"
                                multiple
                                class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                            >
                                @foreach($beneficiarios as $beneficiario)
                                    <option
                                        value="{{ $beneficiario->id }}"
                                        @selected(collect(old('beneficiarios'))->contains($beneficiario->id))
                                    >
                                        {{ $beneficiario->nombre ?? $beneficiario->codigo_beneficiario ?? 'Beneficiario '.$beneficiario->id }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('beneficiarios')" class="mt-1" />
                        </div>

                        {{-- Fecha de Inicio --}}
                        <div>
                            <x-input-label for="fecha_inicio" value="Fecha de Inicio" />
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
                            <x-input-label for="fecha_fin" value="Fecha de Vencimiento" />
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

                    {{-- Objetivo (Solo para Específicos) --}}
                    <div>
                        <x-input-label for="objetivo_personalizado" value="Objetivo (Solo para Específicos)" />
                        <textarea
                            id="objetivo_personalizado"
                            name="objetivo_personalizado"
                            rows="3"
                            class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                            placeholder="Describe el objetivo del convenio específico."
                        >{{ old('objetivo_personalizado') }}</textarea>
                        <x-input-error :messages="$errors->get('objetivo_personalizado')" class="mt-1" />
                    </div>
                </div>
            </div>
        </section>

        {{-- Sección: Archivos PDF / Documentos (Paso 3) --}}
        <section class="space-y-3" x-show="step === 3" x-cloak data-step-section="3">
            <div class="border border-neutral-200 rounded-lg bg-white">
                <header
                    class="flex items-center gap-2 px-4 py-3 border-b border-neutral-200 bg-neutral-50 rounded-t-lg">
                    <span
                        class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-primary/10 text-primary text-xs font-semibold">3</span>
                    <h2 class="text-sm font-semibold text-neutral-800">Documentación adjunta</h2>
                </header>

                <div class="p-4 space-y-4">
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
                    <p class="text-sm text-gray-500">
                        Solo archivos PDF. Máximo 5 MB cada uno.
                    </p>
                </div>
            </div>
        </section>
    </form>
</x-admin.stepper>
