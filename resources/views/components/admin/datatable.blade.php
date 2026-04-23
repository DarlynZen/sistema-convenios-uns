@props([
    'columns',
    'rows',
    'actions' => null,
    'emptyState' => 'No hay datos disponibles.',
    'rowKey' => 'id',
])

@php
    $get = fn($row, $key) => data_get($row, $key);
    $isIterable = function($v) { return is_array($v) || $v instanceof \Illuminate\Contracts\Support\Arrayable || $v instanceof \Traversable; };
@endphp

<div x-data>
    <div
        class="w-full max-w-full overflow-x-hidden rounded border border-neutral-400 bg-white shadow-sm">
        <div class="w-full max-w-full overflow-x-auto">
            <div class="max-h-[500px] overflow-y-auto">
                <table class="w-full table-auto bg-white text-sm text-[#393939]">
                    <thead class="sticky top-0 z-20 border-b border-neutral-300 bg-neutral-50 text-xs md:text-sm tracking-wide text-neutral-700">
                    <tr class="text-left">
                        @foreach($columns as $col)
                            <th class="px-4 py-3 font-bold bg-neutral-50/95 {{ $col['classes'] ?? '' }}">
                                {{ $col['label'] }}
                            </th>
                        @endforeach
                        @if($actions)
                            <th
                                class="sticky right-0 px-4 py-3 text-center font-bold bg-neutral-50/95 z-30 relative before:content-[''] before:pointer-events-none before:absolute before:inset-y-0 before:left-0 before:w-4 before:bg-gradient-to-r before:from-neutral-400/70 before:to-transparent"
                            >Acciones</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-300 align-top">
                    @forelse($rows as $row)
                        <tr class="group transition hover:bg-neutral-100">
                            @foreach($columns as $col)
                                @php $val = $get($row, $col['key'] ?? ''); @endphp
                                <td class="px-4 py-3 align-top text-xs md:text-sm break-words {{ $col['cellClasses'] ?? '' }}">
                                    @if(isset($col['type']) && $col['type'] === 'image')
                                        @if($val)
                                            <img src="{{ $val }}" alt="" class="h-10 w-10 rounded object-contain"/>
                                        @else
                                            <span class="text-xs text-gray-400">-</span>
                                        @endif
                                    @elseif(isset($col['type']) && $col['type'] === 'badge')
                                        @if(isset($col['badgeComponent']) && $col['badgeComponent'])
                                            @includeIf($col['badgeComponent'], ['estadoId' => $val, 'fallback' => $get($row, $col['fallback'] ?? '')])
                                        @else
                                            <span
                                                class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-[11px] font-medium text-gray-800">
                                                    {{ $get($row, $col['fallback'] ?? $col['key']) }}
                                                </span>
                                        @endif
                                    @elseif(isset($col['type']) && $col['type'] === 'join')
                                        @php $pluck = $col['pluck'] ?? null; @endphp
                                        @if($isIterable($val))
                                            @if($pluck)
                                                {{ is_array($val) ? implode(', ', array_column($val, $pluck)) : $val->pluck($pluck)->join(', ') }}
                                            @else
                                                {{ is_array($val) ? implode(', ', $val) : $val->join(', ') }}
                                            @endif
                                        @else
                                            {{ $val ?? '-' }}
                                        @endif
                                    @else
                                        {{ $val ?? '-' }}
                                    @endif
                                </td>
                            @endforeach

                            @if($actions)
                                <td
                                    class="sticky right-0 px-4 py-3 align-top text-xs md:text-sm bg-white group-hover:bg-neutral-50 z-10 relative before:content-[''] before:pointer-events-none before:absolute before:inset-y-0 before:left-0 before:w-1 before:bg-gradient-to-r before:from-neutral-300/80 before:to-transparent"
                                >
                                    <div class="flex flex-wrap items-center justify-center gap-2">
                                        @if(is_string($actions))
                                            @includeIf($actions, ['row' => $row])
                                        @elseif(is_array($actions))
                                            @foreach($actions as $act)
                                                @php
                                                    $label = $act['label'] ?? 'Acción';
                                                    $icon = $act['icon'] ?? null;
                                                    $btnClasses = $act['classes']
                                                        ?? ($icon
                                                            ? 'inline-flex items-center justify-center h-8 w-8 rounded-full border border-slate-200 bg-white text-slate-600 hover:text-slate-800 hover:bg-slate-50'
                                                            : 'px-2 py-1 text-[11px] md:text-xs font-medium uppercase tracking-wide text-slate-500 hover:text-slate-700 border border-slate-200 rounded-full');
                                                @endphp

                                                <button type="button" class="{{ $btnClasses }}" @click.prevent>
                                                    @if($icon)
                                                        <span class="sr-only">{{ $label }}</span>
                                                        {!! $icon !!}
                                                    @else
                                                        {{ $label }}
                                                    @endif
                                                </button>
                                            @endforeach
                                        @else
                                            <span class="text-xs text-gray-400">Sin acciones</span>
                                        @endif
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($columns) + ($actions ? 1 : 0) }}"
                                class="px-4 py-10 text-center text-sm text-slate-500">
                                {{ $emptyState }}
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
