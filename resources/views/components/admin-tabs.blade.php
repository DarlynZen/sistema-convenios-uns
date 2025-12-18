@props([
    'tabs' => [],
    'active' => null,
])

@php
    $tabKeys = array_keys($tabs);
    $activeId = $active ?? ($tabKeys[0] ?? null);
@endphp

<div
    x-data="{ active: @js($activeId) }"
    class="w-full"
>
    {{-- Header de tabs --}}
    <div class="rounded bg-neutral-50 px-2 py-1 border border-neutral-400">
        <div class="flex flex-row gap-1 overflow-x-auto">
            @foreach($tabs as $id => $tab)
                @php
                    $label = is_array($tab) ? ($tab['label'] ?? $id) : $tab;
                    $icon  = is_array($tab) ? ($tab['icon'] ?? null) : null;
                @endphp
                <button
                    type="button"
                    class="inline-flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-semibold text-neutral-500 transition
                           border border-transparent
                           hover:text-primary-600 hover:bg-white"
                    :class="active === @js($id)
                        ? 'bg-white text-primary-700 border-primary-200 shadow-sm'
                        : ''"
                    @click="active = @js($id)"
                >
                    @if($icon)
                        <span class="text-primary-500" aria-hidden="true">
                            {!! $icon !!}
                        </span>
                    @endif
                    <span>{{ $label }}</span>
                </button>
            @endforeach
        </div>
    </div>

    {{-- Contenido --}}
    <div class="mt-4">
        @foreach($tabs as $id => $tab)
            <div x-show="active === @js($id)" x-cloak>
                {{ ${"slot_$id"} ?? '' }}
            </div>
        @endforeach
    </div>
</div>

