@props([
    'steps' => [], // [['key' => 'info', 'label' => 'Información básica'], ...]
    'current' => 1,
])

<div
    x-data="{
        step: {{ (int) $current }},
        maxStep: {{ count($steps) }},
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
        setStep(to) {
            const next = Math.min(this.maxStep, Math.max(1, Number(to) || 1));
            this.step = next;
            this.$dispatch('step-changed', { step: next });
        },
        handleStepRequested(to) {
            const target = Number(to);
            if (!Number.isFinite(target)) return;

            if (target <= this.step) {
                this.setStep(target);
                return;
            }

            if (target !== this.step + 1) {
                return;
            }

            if (!this.validateStep(this.step, true)) {
                return;
            }

            this.setStep(target);
        },
        requestStep(i) {
            this.handleStepRequested(i);
        },
        next() {
            this.handleStepRequested(this.step + 1);
        },
        prev() {
            this.setStep(this.step - 1);
        }
    }"
    x-init="$nextTick(() => setStep(step))"
    x-on:step-requested.window="handleStepRequested($event.detail?.step)"
    x-on:wizard-next.window="next()"
    x-on:wizard-prev.window="prev()"
    class="flex min-h-full flex-col sm:flex-row gap-3 w-full"
>
    {{-- Sidebar de secciones --}}
    <aside class="w-full sm:w-44 border-b sm:border-b-0 sm:border-r border-neutral-200 pb-3 sm:pb-0 sm:pr-4">
        <div class="sm:sticky sm:top-0 sm:bg-white sm:z-10">
            <p class="mb-2 px-2.5 pt-4 text-xs font-semibold text-neutral-700">Pasos</p>
            <ol class="flex sm:block gap-2 sm:gap-1.5 text-sm overflow-x-auto pb-1">
                @foreach($steps as $index => $stepDef)
                    @php $i = $index + 1; @endphp
                    <li class="shrink-0">
                        <button
                            type="button"
                            @click="requestStep({{ $i }})"
                            class="w-full inline-flex items-center gap-2.5 text-left px-2.5 py-2 rounded-lg transition-colors"
                            :class="step === {{ $i }} ? 'bg-primary/10' : 'hover:bg-neutral-100'"
                        >
                            <span
                                class="inline-flex h-6 w-6 items-center justify-center rounded-full border text-[11px] font-semibold flex-none"
                                :class="step === {{ $i }}
                                    ? 'bg-primary text-neutral-700 border-primary'
                                    : 'border-neutral-300 bg-white text-neutral-700'"
                            >
                                {{ $i }}
                            </span>
                            <span
                                class="text-xs sm:text-sm font-medium truncate max-w-[10rem] sm:max-w-none"
                                :class="step === {{ $i }} ? 'text-neutral-900' : 'text-neutral-700'"
                            >
                                {{ $stepDef['label'] ?? 'Paso '.$i }}
                            </span>
                        </button>
                    </li>
                @endforeach
            </ol>
        </div>
    </aside>
    {{-- Contenedor para el contenido del paso --}}
    <div class="flex-1">
        {{ $slot }}
    </div>
</div>
