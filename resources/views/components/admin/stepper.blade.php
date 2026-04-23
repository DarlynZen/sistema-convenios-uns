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
    <aside class="w-full sm:w-[17rem] border-b sm:border-b-0 sm:border-r border-neutral-300 px-4 py-4">
        <div class="sm:sticky sm:top-0 sm:bg-white sm:z-10">
            <p class="mb-3 px-1 text-xs font-semibold uppercase tracking-wide text-neutral-500">Pasos</p>
            <ol class="flex gap-3 overflow-x-auto pb-1 text-sm sm:block sm:space-y-3 sm:overflow-visible sm:pb-0">
                @foreach($steps as $index => $stepDef)
                    @php $i = $index + 1; @endphp
                    <li class="shrink-0 sm:shrink">
                        <button
                            type="button"
                            @click="requestStep({{ $i }})"
                            class="flex w-full min-w-[16rem] items-start gap-3 rounded border px-4 py-3 text-left transition-colors sm:min-w-0"
                            :class="step === {{ $i }}
                                ? 'border-brand-600/25 bg-brand-25'
                                : 'border-neutral-300 bg-white hover:bg-neutral-50'"
                        >
                            <span class="flex h-8 w-8 flex-none items-center justify-center rounded-full border text-[12px] font-semibold"
                                :class="step === {{ $i }}
                                    ? 'border-brand-600 bg-brand-600 text-white'
                                    : 'border-neutral-300 bg-white text-neutral-500'">
                                {{ $i }}
                            </span>

                            <span class="min-w-0 flex-1">
                                <span class="flex items-center gap-2">
                                    @if (!empty($stepDef['icon']))
                                        <span
                                            class="inline-flex flex-none items-center justify-center [&>svg]:h-[1em] [&>svg]:w-[1em] [&>svg]:fill-current"
                                            :class="step === {{ $i }} ? 'text-brand-600' : 'text-neutral-500'">
                                            {!! $stepDef['icon'] !!}
                                        </span>
                                    @endif

                                    <span class="block text-sm font-semibold leading-5"
                                        :class="step === {{ $i }} ? 'text-brand-600' : 'text-neutral-800'">
                                        {{ $stepDef['label'] ?? 'Paso '.$i }}
                                    </span>
                                </span>
                                <span class="mt-0.5 block text-xs leading-4 text-neutral-500">
                                    {{ $stepDef['description'] ?? '' }}
                                </span>
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
