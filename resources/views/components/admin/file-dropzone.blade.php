@props([
    'label',
    'name',
    'required' => false,
    'maxSizeText' => 'Solo PDF · máx. 5 MB',
    'emptyIcon' => null,
    'selectedIcon' => null,
])

@php
    $defaultEmptyIcon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor" class="h-6 w-6"><path d="M224,144v64a8,8,0,0,1-8,8H40a8,8,0,0,1-8-8V144a8,8,0,0,1,16,0v56H208V144a8,8,0,0,1,16,0ZM93.66,77.66,120,51.31V144a8,8,0,0,0,16,0V51.31l26.34,26.35a8,8,0,0,0,11.32-11.32l-40-40a8,8,0,0,0-11.32,0l-40,40A8,8,0,0,0,93.66,77.66Z"></path></svg>';
    $defaultSelectedIcon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor" class="h-5 w-5"><path d="M224,152a8,8,0,0,1-8,8H192v16h16a8,8,0,0,1,0,16H192v16a8,8,0,0,1-16,0V152a8,8,0,0,1,8-8h32A8,8,0,0,1,224,152ZM92,172a28,28,0,0,1-28,28H56v8a8,8,0,0,1-16,0V152a8,8,0,0,1,8-8H64A28,28,0,0,1,92,172Zm-16,0a12,12,0,0,0-12-12H56v24h8A12,12,0,0,0,76,172Zm88,8a36,36,0,0,1-36,36H112a8,8,0,0,1-8-8V152a8,8,0,0,1,8-8h16A36,36,0,0,1,164,180Zm-16,0a20,20,0,0,0-20-20h-8v40h8A20,20,0,0,0,148,180ZM40,112V40A16,16,0,0,1,56,24h96a8,8,0,0,1,5.66,2.34l56,56A8,8,0,0,1,216,88v24a8,8,0,0,1-16,0V96H152a8,8,0,0,1-8-8V40H56v72a8,8,0,0,1-16,0ZM160,80h28.69L160,51.31Z"></path></svg>';
@endphp

<div x-data="{
    file: null,
    fileName: '',
    fileSize: '',
    onFileChange(event) {
        const selected = event.target.files?.[0] ?? null;
        this.file = selected;
        this.fileName = selected ? selected.name : '';
        this.fileSize = selected ? this.formatSize(selected.size) : '';
    },
    clearFile() {
        this.file = null;
        this.fileName = '';
        this.fileSize = '';
        this.$refs.input.value = '';
    },
    formatSize(bytes) {
        return bytes >= 1048576
            ? (bytes / 1048576).toFixed(1) + ' MB'
            : (bytes / 1024).toFixed(1) + ' KB';
    }
}" class="group">
    <div class="flex w-full flex-col gap-3 text-left"
        role="button" tabindex="0"
        @click="$refs.input.click()"
        @keydown.enter.prevent="$refs.input.click()"
        @keydown.space.prevent="$refs.input.click()">
        <span class="text-sm font-medium text-neutral-800">{{ $label }}</span>

        <span x-show="!file" x-cloak
            class="flex min-h-44 flex-col items-center justify-center rounded border border-dashed border-neutral-300 bg-white px-4 py-6 text-center transition-colors group-hover:border-brand-600/40">
            <span class="mb-3 inline-flex h-12 w-12 items-center justify-center rounded text-brand-600">
                {!! $emptyIcon ?? $defaultEmptyIcon !!}
            </span>
            <span class="text-sm font-semibold text-neutral-800">Haz clic para subir</span>
            <span class="mt-1 text-xs text-neutral-500">{{ $maxSizeText }}</span>
        </span>

        <span x-show="file" x-cloak
            class="flex h-full items-start gap-3 rounded border border-neutral-300 bg-white px-3 py-3 transition-colors">
            <span class="inline-flex h-10 w-10 flex-none items-center justify-center rounded text-brand-600">
                {!! $selectedIcon ?? $defaultSelectedIcon !!}
            </span>
            <div class="min-w-0 flex-1">
                <p class="whitespace-normal break-words text-sm font-normal leading-4 text-neutral-800"
                    x-text="fileName"></p>
                <p class="mt-1 text-xs text-neutral-500" x-text="fileSize"></p>
            </div>
            <button type="button" @click.stop.prevent="clearFile()"
                class="inline-flex h-8 w-8 flex-none items-center justify-center rounded-full border border-red-200 bg-white text-red-600 transition-colors hover:bg-red-50 hover:text-red-700"
                aria-label="Quitar archivo">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor" class="h-4 w-4">
                    <path d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16h8V208a16,16,0,0,0,16,16H192a16,16,0,0,0,16-16V64h8a8,8,0,0,0,0-16ZM96,40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96Zm96,168H64V64H192ZM112,104v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Zm48,0v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Z"></path>
                </svg>
            </button>
        </span>
    </div>

    <input x-ref="input" type="file" name="{{ $name }}" accept="application/pdf" {{ $required ? 'required' : '' }}
        class="sr-only" @change="onFileChange($event)">
</div>
