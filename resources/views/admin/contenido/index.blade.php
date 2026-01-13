<x-admin-layout>
    <div class="space-y-4">
        <x-admin.block>
            <div class="flex flex-col space-y-1">
                <h1 class="text-neutral-600 text-2xl font-bold">Editor de Contenido</h1>
                <p class="text-neutral-600 text-sm"></p>
            </div>
        </x-admin.block>

        <x-admin.block>
            <x-admin-tabs :tabs='[
                "hero" => [
                    "label" => "Hero",
                    "icon" => "<svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-4 w-4\" viewBox=\"0 0 20 20\" fill=\"currentColor\"><path d=\"M10.707 1.293a1 1 0 00-1.414 0l-7 7A1 1 0 003 10h1v6a1 1 0 001 1h3v-4h2v4h3a1 1 0 001-1v-6h1a1 1 0 00.707-1.707l-7-7z\" /></svg>",
                ],
                "nosotros" => [
                    "label" => "Nosotros",
                    "icon" => "<svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-4 w-4\" viewBox=\"0 0 20 20\" fill=\"currentColor\"><path d=\"M13 7a3 3 0 11-6 0 3 3 0 016 0z\" /><path fill-rule=\"evenodd\" d=\"M2 13a4 4 0 014-4h8a4 4 0 014 4v1a1 1 0 11-2 0v-1a2 2 0 00-2-2H6a2 2 0 00-2 2v1a1 1 0 11-2 0v-1z\" clip-rule=\"evenodd\" /></svg>",
                ],
                "proceso" => [
                    "label" => "Proceso",
                    "icon" => "<svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-4 w-4\" viewBox=\"0 0 20 20\" fill=\"currentColor\"><path fill-rule=\"evenodd\" d=\"M10 2a1 1 0 01.894.553l3 6A1 1 0 0113 10H7a1 1 0 01-.894-1.447l3-6A1 1 0 0110 2zm-3 9a1 1 0 000 2h6a1 1 0 100-2H7zm-2 4a1 1 0 100 2h10a1 1 0 100-2H5z\" clip-rule=\"evenodd\" /></svg>",
                ],
                "faq" => [
                    "label" => "FAQ",
                    "icon" => "<svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-4 w-4\" viewBox=\"0 0 20 20\" fill=\"currentColor\"><path fill-rule=\"evenodd\" d=\"M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a2 2 0 00-1.995 1.85L8 9h2a1 1 0 110 2H9a1 1 0 100 2h1a1 1 0 100-2h1a2 2 0 000-4zm0 8a1 1 0 100-2 1 1 0 000 2z\" clip-rule=\"evenodd\" /></svg>",
                ],
                "contacto" => [
                    "label" => "Contacto",
                    "icon" => "<svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-4 w-4\" viewBox=\"0 0 20 20\" fill=\"currentColor\"><path d=\"M2.94 6.94a1.5 1.5 0 012.12 0L10 11.879l4.94-4.94a1.5 1.5 0 112.12 2.122l-6 6a1.5 1.5 0 01-2.12 0l-6-6a1.5 1.5 0 010-2.122z\"/></svg>",
                ],
            ]'>
                <x-slot name="slot_hero">
                    <div class="space-y-4" x-data="{ previewUrl: null }">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="hero_titulo" value="Título del hero" />
                                <x-text-input
                                    id="hero_titulo"
                                    name="hero_titulo"
                                    type="text"
                                    class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                                    placeholder="Escribe el título principal"
                                />
                            </div>

                            <div>
                                <x-input-label for="hero_subtitulo" value="Subtítulo del hero" />
                                <x-text-input
                                    id="hero_subtitulo"
                                    name="hero_subtitulo"
                                    type="text"
                                    class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-red-400 focus:ring-2 focus:ring-red-200"
                                    placeholder="Escribe un subtítulo o descripción corta"
                                />
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
                                    @change="previewUrl = $event.target.files?.[0] ? URL.createObjectURL($event.target.files[0]) : null"
                                />
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
                            <x-admin.confirm-button type="button">Guardar</x-admin.confirm-button>
                        </div>
                    </div>
                </x-slot>

                <x-slot name="slot_nosotros">
                    <p>Hola 1</p>
                </x-slot>

                <x-slot name="slot_proceso">
                    <p>Hola 2</p>
                </x-slot>

                <x-slot name="slot_faq">
                    <p>Hola</p>
                </x-slot>

                <x-slot name="slot_contacto">
                    <p>Hola</p>
                </x-slot>
            </x-admin-tabs>
        </x-admin.block>
    </div>
</x-admin-layout>
