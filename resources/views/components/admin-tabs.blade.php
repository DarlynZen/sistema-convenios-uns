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
    <div class="rounded-lg border border-neutral-200 bg-neutral-50 p-1">
        {{-- Mobile: dropdown --}}
        <div class="md:hidden">
            <label class="sr-only" for="admin-tabs-select">Sección</label>
            <select
                id="admin-tabs-select"
                x-model="active"
                class="w-full rounded-md border border-neutral-200 bg-white px-3 py-2 text-sm font-semibold text-neutral-700 shadow-sm focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand-200"
            >
                @foreach($tabs as $id => $tab)
                    @php
                        $label = is_array($tab) ? ($tab['label'] ?? $id) : $tab;
                    @endphp
                    <option value="{{ $id }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        {{-- Desktop: pill tabs (scrollable if needed) --}}
        <div
            class="hidden md:flex md:flex-nowrap md:items-stretch md:gap-1 md:overflow-x-auto"
            role="tablist"
            aria-label="Secciones"
        >
            @foreach($tabs as $id => $tab)
                @php
                    $label = is_array($tab) ? ($tab['label'] ?? $id) : $tab;
                    $icon  = is_array($tab) ? ($tab['icon'] ?? null) : null;
                @endphp
                <button
                    type="button"
                    role="tab"
                    :aria-selected="active === @js($id)"
                    class="flex-none inline-flex items-center justify-center gap-2 rounded-md px-4 py-2 text-sm font-semibold text-neutral-600 transition
                           border border-transparent
                           hover:bg-white hover:text-brand-600 focus:outline-none"
                    :class="active === @js($id)
                        ? 'bg-white text-brand-600 border-brand-200 shadow-sm'
                        : ''"
                    @click="active = @js($id)"
                >
                    @if($icon)
                        <span class="text-brand-600" aria-hidden="true">
                            {!! $icon !!}
                        </span>
                    @endif
                    <span class="whitespace-nowrap">{{ $label }}</span>
                </button>
            @endforeach
        </div>
    </div>

    {{-- Contenido --}}
    <div class="mt-4">
        @foreach($tabs as $id => $tab)
            <div x-show="active === @js($id)" x-cloak role="tabpanel">
                {{ ${"slot_$id"} ?? '' }}
            </div>
        @endforeach
    </div>
</div>

