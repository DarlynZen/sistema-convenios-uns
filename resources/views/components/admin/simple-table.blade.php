@props([
    'columns',
    'rows',
    'emptyState' => 'No hay datos disponibles.',
    'showHeader' => true,
    'columnWidths' => [],
    'tableMinWidth' => null,
])

@php
    $get = fn($row, $key) => data_get($row, $key);
    $isIterable = function ($value) {
        return is_array($value)
            || $value instanceof \Illuminate\Contracts\Support\Arrayable
            || $value instanceof \Traversable;
    };
@endphp

<div class="w-full max-w-full overflow-x-hidden rounded border border-neutral-400 bg-white shadow-sm">
    <div class="w-full max-w-full overflow-x-auto">
        <div class="max-h-[500px] overflow-y-auto">
            <table @class([
                'w-full bg-white text-sm text-[#393939]',
                'table-auto' => $showHeader,
                'table-fixed' => ! $showHeader,
            ]) @style(['min-width: ' . $tableMinWidth => filled($tableMinWidth)])>
                @if ($showHeader)
                    <thead class="sticky top-0 z-20 border-b border-neutral-300 bg-neutral-50 text-xs tracking-wide text-neutral-700 md:text-sm">
                        <tr class="text-left">
                            @foreach ($columns as $col)
                                <th class="bg-neutral-50/95 px-4 py-3 font-bold {{ $col['classes'] ?? '' }}">
                                    {{ $col['label'] }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                @else
                    <thead class="sticky top-0 z-20 border-b border-neutral-300 bg-neutral-50 text-xs tracking-wide text-neutral-700 md:text-sm">
                        <tr class="text-left">
                            @foreach ($rows as $index => $row)
                                <th class="bg-neutral-50/95 px-4 py-2 text-left font-bold text-sm text-neutral-500 align-middle break-words leading-tight {{ $columnWidths[$index] ?? '' }}">
                                    {{ $get($row, 'label') }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                @endif

                <tbody class="divide-y divide-neutral-300 align-top">
                    @if ($showHeader)
                        @forelse ($rows as $row)
                            <tr class="group transition">
                                @foreach ($columns as $col)
                                    @php
                                        $val = $get($row, $col['key'] ?? '');
                                        $type = $col['type'] ?? null;
                                    @endphp
                                    <td class="break-words px-4 py-3 align-top text-xs md:text-sm {{ $col['cellClasses'] ?? '' }}">
                                        @if ($type === 'image')
                                            @if ($val)
                                                <img src="{{ $val }}" alt="" class="h-10 w-10 rounded object-contain">
                                            @else
                                                <span class="text-xs text-gray-400">-</span>
                                            @endif
                                        @elseif ($type === 'badge')
                                            @if (!empty($col['badgeComponent']))
                                                @includeIf($col['badgeComponent'], [
                                                    'estadoId' => $val,
                                                    'fallback' => $get($row, $col['fallback'] ?? ''),
                                                ])
                                            @else
                                                <span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-[11px] font-medium text-gray-800">
                                                    {{ $get($row, $col['fallback'] ?? $col['key']) }}
                                                </span>
                                            @endif
                                        @elseif ($type === 'join')
                                            @php
                                                $pluck = $col['pluck'] ?? null;
                                            @endphp
                                            @if ($isIterable($val))
                                                @if ($pluck)
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($columns) }}" class="px-4 py-10 text-center text-sm text-slate-500">
                                    {{ $emptyState }}
                                </td>
                            </tr>
                        @endforelse
                    @else
                        @if (count($rows))
                            <tr class="group transition">
                                @foreach ($rows as $index => $row)
                                    <td class="break-words px-4 py-3 align-top text-xs text-neutral-800 md:text-sm {{ $columnWidths[$index] ?? '' }}">
                                        {{ $get($row, 'value') }}
                                    </td>
                                @endforeach
                            </tr>
                        @else
                            <tr>
                                <td colspan="1" class="px-4 py-10 text-center text-sm text-slate-500">
                                    {{ $emptyState }}
                                </td>
                            </tr>
                        @endif
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
