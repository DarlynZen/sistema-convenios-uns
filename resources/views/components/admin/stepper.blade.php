@props([
    'steps' => [], // [['key' => 'info', 'label' => 'Información básica'], ...]
    'current' => 1,
])

<div
    x-data="{
        step: {{ (int) $current }},
        requestStep(i){ $dispatch('step-requested', { step: i }); }
    }"
    x-on:step-changed.window="step = $event.detail.step"
    class="flex min-h-full flex-col sm:flex-row gap-3 sm:gap-5"
>
    {{-- Sidebar de secciones --}}
    <aside class="w-full sm:w-44 border-b sm:border-b-0 sm:border-r border-neutral-200 pb-3 sm:pb-0 sm:pr-4">
        <div class="sm:sticky sm:top-0 sm:bg-white sm:z-10">
            <p class="mb-3 py-1 text-xs font-semibold text-neutral-700">Pasos</p>
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
    <div class="flex-1 pr-1 sm:pr-2 pb-1 sm:pb-2">
        {{ $slot }}
    </div>
</div>