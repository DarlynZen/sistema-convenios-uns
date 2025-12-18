@props([
    'steps' => [], // [['key' => 'info', 'label' => 'Información básica'], ...]
    'current' => 1,
])

<div
    x-data="{
        step: {{ (int) $current }},
        selectStep(i){ this.step = i; $dispatch('step-changed', { step: i }); }
    }"
    class="flex flex-col sm:flex-row gap-4 sm:gap-6 max-h-[540px]"
>
    {{-- Sidebar de secciones --}}
    <aside class="w-full sm:w-48 shrink-0 border-b sm:border-b-0 sm:border-r border-neutral-200 pb-2 sm:pb-0 sm:pr-4">
        <p class="mb-3 text-sm font-semibold text-neutral-700">Pasos</p>
        <ol class="flex sm:block gap-2 sm:gap-2 text-sm overflow-x-auto">
            @foreach($steps as $index => $stepDef)
                @php $i = $index + 1; @endphp
                <li class="shrink-0">
                    <button type="button"
                            @click="selectStep({{ $i }})"
                            class="w-full flex items-center gap-2 text-left px-3 py-2 rounded-lg transition-colors"
                            :class="step === {{ $i }} ? 'bg-primary/10 ring-1 ring-primary/20' : 'hover:bg-neutral-100'">
                        <span class="inline-flex h-6 w-6 items-center justify-center rounded-full border text-xs font-semibold"
                              :class="step === {{ $i }} ? 'border-primary bg-primary text-white' : 'border-neutral-300 bg-white text-neutral-700'">
                            {{ $i }}
                        </span>
                        <span class="text-xs sm:text-sm font-medium"
                              :class="step === {{ $i }} ? 'text-neutral-900' : 'text-neutral-700'">
                            {{ $stepDef['label'] ?? 'Paso '.$i }}
                        </span>
                    </button>
                </li>
            @endforeach
        </ol>
    </aside>

    {{-- Contenedor para el contenido del paso --}}
    <div class="flex-1 overflow-y-auto pr-1 sm:pr-2">
        {{ $slot }}
    </div>
</div>

