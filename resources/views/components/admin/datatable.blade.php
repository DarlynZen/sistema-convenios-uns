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
        class="w-full max-w-full overflow-x-hidden rounded border border-gray-200 bg-white shadow-sm ring-1 ring-slate-900/5">
        <div class="w-full max-w-full overflow-x-auto">
            <div class="max-h-[500px] overflow-y-auto">
                <table class="w-full table-auto bg-white text-sm text-[#393939]">
                    <thead class="sticky top-0 z-20 bg-neutral-50 text-xs md:text-sm tracking-wide text-neutral-800">
                    <tr class="text-left">
                        @foreach($columns as $col)
                            <th class="px-4 py-3 font-bold bg-neutral-50/95 {{ $col['classes'] ?? '' }}">
                                {{ $col['label'] }}
                            </th>
                        @endforeach
                        @if($actions)
                            <th class="px-4 py-3 text-right font-bold bg-neutral-50/95">Acciones</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 align-top">
                    @forelse($rows as $row)
                        <tr class="group transition hover:bg-slate-50">
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
                                <td class="px-4 py-3 align-top text-xs md:text-sm">
                                    <div class="flex flex-wrap items-center justify-end gap-2">
                                        @if(is_string($actions))
                                            @includeIf($actions, ['row' => $row])
                                        @elseif(is_array($actions))
                                            @foreach($actions as $act)
                                                <button type="button"
                                                        class="px-2 py-1 text-[11px] md:text-xs font-medium uppercase tracking-wide text-slate-500 hover:text-slate-700 border border-slate-200 rounded-full"
                                                        @click.prevent>
                                                    {{ $act['label'] ?? 'Acción' }}
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
