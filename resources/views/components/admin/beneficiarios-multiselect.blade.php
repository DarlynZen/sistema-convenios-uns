@props([
    'label' => 'Dirigido a',
    'name' => 'beneficiarios',
    'options' => [],
    'selected' => [],
    'errorMessages' => [],
    'placeholder' => 'Selecciona beneficiarios',
])

<div class="w-full">
    <x-input-label for="{{ $name }}_general" value="{{ $label }}" />

    <div class="relative mt-1" x-data="{
        open: false,
        options: @js($options),
        selected: @js($selected),

        isSelected(id) { return this.selected.includes(Number(id)); },
        toggle(id) {
            id = Number(id);
            if (this.isSelected(id)) {
                this.selected = this.selected.filter((v) => v !== id);
            } else {
                this.selected = [...this.selected, id];
            }
        },
        remove(id) {
            id = Number(id);
            this.selected = this.selected.filter((v) => v !== id);
        },
        labelFor(id) {
            id = Number(id);
            const opt = this.options.find((o) => Number(o.id) === id);
            return opt ? opt.label : id;
        },
    }">
        <div id="{{ $name }}_general" role="combobox" aria-haspopup="listbox"
            x-bind:aria-expanded="open" tabindex="0" @click="open = true"
            @keydown.enter.prevent="open = !open" @keydown.escape.prevent="open = false"
            class="min-h-[42px] w-full rounded-lg border border-neutral-300 bg-white px-3 py-2 text-[13px] focus-within:border-red-400 focus-within:ring-2 focus-within:ring-red-200">
            <div class="flex flex-wrap items-center gap-1.5">
                <template x-for="id in selected" :key="id">
                    <span class="inline-flex items-center gap-1 rounded-lg bg-neutral-200 px-2 py-1 text-[12px] text-neutral-700">
                        <span x-text="labelFor(id)"></span>
                        <button type="button"
                            class="ml-0.5 inline-flex h-5 w-5 items-center justify-center rounded-lg text-neutral-500 hover:text-neutral-700"
                            @click.stop="remove(id)" aria-label="Quitar">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor" class="h-3 w-3">
                                <path d="M205.66,194.34a8,8,0,0,1-11.32,11.32L128,139.31,61.66,205.66a8,8,0,0,1-11.32-11.32L116.69,128,50.34,61.66A8,8,0,0,1,61.66,50.34L128,116.69l66.34-66.35a8,8,0,0,1,11.32,11.32L139.31,128Z"></path>
                            </svg>
                        </button>
                    </span>
                </template>

                <span x-show="selected.length === 0" class="text-neutral-400">{{ $placeholder }}</span>
            </div>
        </div>

        <div x-show="open" x-transition.origin.top x-cloak @click.outside="open = false"
            class="absolute z-50 mt-1 w-full rounded-lg border border-neutral-300 bg-white shadow-sm" role="listbox">
            <ul class="max-h-52 overflow-y-auto py-1">
                <template x-for="opt in options" :key="opt.id">
                    <li>
                        <button type="button"
                            class="flex w-full items-center justify-between px-3 py-2 text-left text-sm hover:bg-neutral-300"
                            :class="isSelected(opt.id) ? 'bg-neutral-200' : ''"
                            @click="toggle(opt.id)">
                            <span class="text-neutral-700" x-text="opt.label"></span>
                            <span class="text-xs text-neutral-400" x-show="isSelected(opt.id)">✓</span>
                        </button>
                    </li>
                </template>
            </ul>
        </div>

        <template x-for="id in selected" :key="'hidden-' + id">
            <input type="hidden" name="{{ $name }}[]" :value="id" />
        </template>
    </div>

    @if (!empty($errorMessages))
        <x-input-error :messages="$errorMessages" class="mt-1" />
    @endif
</div>
