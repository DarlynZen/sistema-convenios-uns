<form class="space-y-4" x-data="{ previewUrl: @js($heroImagenUrl ?? null) }" method="POST" action="{{ route('admin.contenido.hero.save') }}" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <x-input-label for="hero_titulo" value="Título del hero" />
            <x-text-input
                id="hero_titulo"
                name="hero_titulo"
                type="text"
                class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                placeholder="Escribe el título principal"
                value="{{ old('hero_titulo', $heroTitulo ?? '') }}" />
        </div>

        <div>
            <x-input-label for="hero_subtitulo" value="Subtítulo del hero" />
            <x-text-input
                id="hero_subtitulo"
                name="hero_subtitulo"
                type="text"
                class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                placeholder="Escribe un subtítulo o descripción corta"
                value="{{ old('hero_subtitulo', $heroSubtitulo ?? '') }}" />
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
        <div>
            <x-input-label for="hero_imagen" value="Imagen del hero" />
            <input
                id="hero_imagen"
                name="hero_imagen"
                type="file"
                accept="image/*"
                class="mt-1 block w-full text-[13px] text-neutral-700 file:mr-4 file:rounded-lg file:border-0 file:bg-neutral-100 file:px-3 file:py-2 file:text-[13px] file:font-medium file:text-neutral-700 hover:file:bg-neutral-200"
                @change="previewUrl = $event.target.files?.[0] ? URL.createObjectURL($event.target.files[0]) : null" />
            <p class="mt-1 text-xs text-neutral-500">Formatos recomendados: JPG/PNG. Ideal 1600×900.</p>
        </div>

        <div class="rounded-lg border border-neutral-200 bg-white p-3">
            <p class="text-xs font-medium text-neutral-600 mb-2">Vista previa</p>
            <div class="aspect-[16/9] w-full overflow-hidden rounded-lg bg-neutral-50 border border-neutral-100 flex items-center justify-center">
                <template x-if="previewUrl">
                    <img :src="previewUrl" alt="Vista previa" class="h-full w-full object-cover" />
                </template>
                <template x-if="!previewUrl">
                    <span class="text-xs text-neutral-400">Selecciona una imagen para ver la vista previa</span>
                </template>
            </div>
        </div>
    </div>

    <div class="flex justify-end pt-1">
        <x-admin.confirm-button type="submit">Guardar</x-admin.confirm-button>
    </div>
</form>