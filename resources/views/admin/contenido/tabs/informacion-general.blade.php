<div class="space-y-2">
    <div class="rounded-lg border border-neutral-200 bg-neutral-50/60">
        <div class="flex items-center gap-2 border-b border-neutral-200/70 px-4 py-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#D9324D" viewBox="0 0 256 256">
                <path d="M192,48V224l-64-40L64,224V48a8,8,0,0,1,8-8H184A8,8,0,0,1,192,48Z" opacity="0.2"></path>
                <path d="M184,32H72A16,16,0,0,0,56,48V224a8,8,0,0,0,12.24,6.78L128,193.43l59.77,37.35A8,8,0,0,0,200,224V48A16,16,0,0,0,184,32Zm0,177.57-51.77-32.35a8,8,0,0,0-8.48,0L72,209.57V48H184Z"></path>
            </svg>
            <h2 class="text-sm font-bold text-neutral-700">Sección del Hero</h2>
        </div>
        <div class="p-4">
            <form class="space-y-4" x-data="{ previewUrl: @js($heroImagenUrl ?? null) }" method="POST" action="{{ route('admin.contenido.hero.save') }}" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="hero_titulo" value="Título del hero" />
                        <x-text-input
                            id="hero_titulo"
                            name="hero_titulo"
                            type="text"
                            class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-brand-500 focus:ring-2 focus:ring-brand-100"
                            placeholder="Escribe el título principal"
                            value="{{ old('hero_titulo', $heroTitulo ?? '') }}" />
                    </div>

                    <div>
                        <x-input-label for="hero_subtitulo" value="Subtítulo del hero" />
                        <x-text-input
                            id="hero_subtitulo"
                            name="hero_subtitulo"
                            type="text"
                            class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-brand-500 focus:ring-2 focus:ring-brand-100"
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
        </div>
    </div>

    <div class="rounded-lg border border-neutral-200 bg-neutral-50/60">
        <div class="flex items-center gap-2 border-b border-neutral-200/70 px-4 py-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#D9324D" viewBox="0 0 256 256">
                <path d="M237.49,134.05,134.05,237.49a8.54,8.54,0,0,1-12.1,0L18.51,134.05a8.54,8.54,0,0,1,0-12.1L122,18.51a8.54,8.54,0,0,1,12.1,0L237.49,122A8.54,8.54,0,0,1,237.49,134.05Z" opacity="0.2"></path>
                <path d="M243.15,116.29,139.71,12.85a16.56,16.56,0,0,0-23.42,0L12.85,116.29a16.56,16.56,0,0,0,0,23.42L116.29,243.15h0a16.56,16.56,0,0,0,23.42,0L243.15,139.71a16.56,16.56,0,0,0,0-23.42Zm-11.31,12.1L128.39,231.84a.56.56,0,0,1-.78,0h0L24.16,128.39a.56.56,0,0,1,0-.78L127.61,24.16A.52.52,0,0,1,128,24a.58.58,0,0,1,.4.16L231.84,127.61a.56.56,0,0,1,0,.78Zm-58.18-14a8,8,0,0,1,0,11.32l-24,24a8,8,0,0,1-11.32-11.32L148.69,128H112a16,16,0,0,0-16,16v8a8,8,0,0,1-16,0v-8a32,32,0,0,1,32-32h36.69l-10.35-10.34a8,8,0,0,1,11.32-11.32Z"></path>
            </svg>
            <h2 class="text-sm font-bold text-neutral-700">Sección de Proceso de Convenio</h2>
        </div>
        <div class="p-4"></div>
    </div>

    <div class="rounded-lg border border-neutral-200 bg-neutral-50/60">
        <div class="flex items-center gap-2 border-b border-neutral-200/70 px-4 py-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#D9324D" viewBox="0 0 256 256">
                <path d="M213.09,172.48a96,96,0,0,1-80.41,51.41l3.17-16.44a8,8,0,0,0-2-6.95l-19.74-20.33a8,8,0,0,1-1.44-8.69l13.7-30.74a8,8,0,0,1,8.38-4.67l22.82,3.08a8.11,8.11,0,0,1,3.12,1.11ZM116.71,95,129,88.24a7.46,7.46,0,0,0,1.5-1.07l26.91-24.33A8,8,0,0,0,159,53l-10.5-18.81A96.62,96.62,0,0,0,128,32,95.61,95.61,0,0,0,67.78,53.23L56,81.08A8,8,0,0,0,55.88,87l11.5,30.67a8,8,0,0,0,5.81,5l2.69.58L89.2,100a8,8,0,0,1,6.94-4h16.71A7.9,7.9,0,0,0,116.71,95Z" opacity="0.2"></path>
                <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm88,104a87.62,87.62,0,0,1-6.4,32.94l-44.7-27.49a15.92,15.92,0,0,0-6.24-2.23l-22.82-3.08a16.11,16.11,0,0,0-16,7.86h-8.72l-3.8-7.86a15.91,15.91,0,0,0-11-8.67l-8-1.73L96.14,104h16.71a16.06,16.06,0,0,0,7.73-2l12.25-6.76a16.62,16.62,0,0,0,3-2.14l26.91-24.34A15.93,15.93,0,0,0,166,49.1l-.36-.65A88.11,88.11,0,0,1,216,128ZM143.31,41.34,152,56.9,125.09,81.24,112.85,88H96.14a16,16,0,0,0-13.88,8l-8.73,15.23L63.38,84.19,74.32,58.32a87.87,87.87,0,0,1,69-17ZM40,128a87.53,87.53,0,0,1,8.54-37.8l11.34,30.27a16,16,0,0,0,11.62,10l21.43,4.61L96.74,143a16.09,16.09,0,0,0,14.4,9h1.48l-7.23,16.23a16,16,0,0,0,2.86,17.37l.14.14L128,205.94l-1.94,10A88.11,88.11,0,0,1,40,128Zm102.58,86.78,1.13-5.81a16.09,16.09,0,0,0-4-13.9,1.85,1.85,0,0,1-.14-.14L120,174.74,133.7,144l22.82,3.08,45.72,28.12A88.18,88.18,0,0,1,142.58,214.78Z"></path>
            </svg>
            <h2 class="text-sm font-bold text-neutral-700">Sección de Mapa y Estadísticas</h2>
        </div>
        <div class="p-4">
            <div
                class="grid grid-cols-1 lg:grid-cols-2 gap-4"
                x-data="{
                    query: '',
                    selectedCountry: '',
                    convenioCount: '',
                    items: [
                        { country: 'Perú', count: 12 },
                        { country: 'Chile', count: 4 },
                    ],
                    countries: [
                        'Afganistán','Albania','Alemania','Andorra','Angola','Antigua y Barbuda','Arabia Saudita','Argelia','Argentina','Armenia','Australia','Austria','Azerbaiyán',
                        'Bahamas','Bangladés','Barbados','Baréin','Bélgica','Belice','Benín','Bielorrusia','Birmania (Myanmar)','Bolivia','Bosnia y Herzegovina','Botsuana','Brasil','Brunéi','Bulgaria','Burkina Faso','Burundi',
                        'Cabo Verde','Camboya','Camerún','Canadá','Catar','Chad','Chile','China','Chipre','Colombia','Comoras','Congo','Congo (Rep. Dem.)','Corea del Norte','Corea del Sur','Costa de Marfil','Costa Rica','Croacia','Cuba','Dinamarca','Dominica','Ecuador','Egipto','El Salvador','Emiratos Árabes Unidos','Eritrea','Eslovaquia','Eslovenia','España','Estados Unidos','Estonia','Etiopía',
                        'Fiyi','Filipinas','Finlandia','Francia','Gabón','Gambia','Georgia','Ghana','Granada','Grecia','Guatemala','Guinea','Guinea-Bisáu','Guinea Ecuatorial','Guyana',
                        'Haití','Honduras','Hungría','India','Indonesia','Irak','Irán','Irlanda','Islandia','Islas Marshall','Islas Salomón','Israel','Italia','Jamaica','Japón','Jordania',
                        'Kazajistán','Kenia','Kirguistán','Kiribati','Kuwait','Laos','Lesoto','Letonia','Líbano','Liberia','Libia','Liechtenstein','Lituania','Luxemburgo',
                        'Madagascar','Malasia','Malaui','Maldivas','Malí','Malta','Marruecos','Mauricio','Mauritania','México','Micronesia','Moldavia','Mónaco','Mongolia','Montenegro','Mozambique',
                        'Namibia','Nauru','Nepal','Nicaragua','Níger','Nigeria','Noruega','Nueva Zelanda','Omán',
                        'Países Bajos','Pakistán','Palaos','Panamá','Papúa Nueva Guinea','Paraguay','Perú','Polonia','Portugal','Reino Unido','República Centroafricana','República Checa','República Dominicana','Ruanda','Rumanía','Rusia',
                        'Samoa','San Cristóbal y Nieves','San Marino','San Vicente y las Granadinas','Santa Lucía','Santo Tomé y Príncipe','Senegal','Serbia','Seychelles','Sierra Leona','Singapur','Siria','Somalia','Sri Lanka','Suazilandia (Esuatini)','Sudáfrica','Sudán','Sudán del Sur','Suecia','Suiza','Surinam',
                        'Tailandia','Tanzania','Tayikistán','Timor Oriental','Togo','Tonga','Trinidad y Tobago','Túnez','Turkmenistán','Turquía','Tuvalu',
                        'Ucrania','Uganda','Uruguay','Uzbekistán','Vanuatu','Vaticano','Venezuela','Vietnam','Yemen','Yibuti','Zambia','Zimbabue'
                    ].sort(),
                    filteredCountries() {
                        const q = (this.query || '').trim().toLowerCase();
                        if (!q) return this.countries;
                        return this.countries.filter(c => c.toLowerCase().includes(q));
                    },
                    addItem() {
                        const country = (this.selectedCountry || '').trim();
                        const count = Number(this.convenioCount);
                        if (!country || !Number.isFinite(count) || count < 0) return;

                        const existingIndex = this.items.findIndex(i => i.country === country);
                        if (existingIndex >= 0) {
                            this.items[existingIndex].count = count;
                        } else {
                            this.items.push({ country, count });
                        }

                        this.items.sort((a, b) => a.country.localeCompare(b.country, 'es'));
                        this.selectedCountry = '';
                        this.convenioCount = '';
                    },
                    removeItem(country) {
                        this.items = this.items.filter(i => i.country !== country);
                    }
                }"
            >
                <div class="rounded-lg border border-neutral-200 bg-white p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h3 class="text-sm font-semibold text-neutral-800">Convenios por país</h3>
                            <p class="mt-1 text-xs text-neutral-500">Diseño preliminar: esto aún no guarda en la base de datos.</p>
                        </div>
                        <span class="inline-flex items-center rounded-full bg-neutral-100 px-2 py-1 text-[11px] font-semibold text-neutral-600">Borrador</span>
                    </div>

                    <div class="mt-4 grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-neutral-700">Buscar país</label>
                            <input
                                type="text"
                                x-model="query"
                                placeholder="Escribe para filtrar…"
                                class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-brand-500 focus:ring-2 focus:ring-brand-100"
                            />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-5 gap-3 items-end">
                            <div class="md:col-span-3">
                                <label class="block text-xs font-semibold text-neutral-700">País</label>
                                <select
                                    x-model="selectedCountry"
                                    class="mt-1 block w-full rounded-lg border border-neutral-200 bg-white px-3 py-2 text-[13px] focus:border-brand-500 focus:ring-2 focus:ring-brand-100"
                                >
                                    <option value="">Selecciona un país</option>
                                    <template x-for="country in filteredCountries()" :key="country">
                                        <option :value="country" x-text="country"></option>
                                    </template>
                                </select>
                            </div>

                            <div class="md:col-span-1">
                                <label class="block text-xs font-semibold text-neutral-700">Cantidad</label>
                                <input
                                    type="number"
                                    min="0"
                                    step="1"
                                    x-model="convenioCount"
                                    placeholder="0"
                                    class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-brand-500 focus:ring-2 focus:ring-brand-100"
                                />
                            </div>

                            <div class="md:col-span-1">
                                <button
                                    type="button"
                                    @click="addItem()"
                                    class="w-full inline-flex items-center justify-center gap-2 rounded-lg bg-brand-600 px-3 py-2 text-[13px] font-semibold text-white hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-200"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 256 256" aria-hidden="true">
                                        <path d="M224,128a8,8,0,0,1-8,8H136v80a8,8,0,0,1-16,0V136H40a8,8,0,0,1,0-16h80V40a8,8,0,0,1,16,0v80h80A8,8,0,0,1,224,128Z"></path>
                                    </svg>
                                    Agregar
                                </button>
                            </div>
                        </div>

                        <div class="rounded-lg border border-neutral-200 bg-neutral-50 p-3">
                            <div class="flex items-center justify-between gap-3">
                                <p class="text-xs font-semibold text-neutral-700">Tip</p>
                                <p class="text-xs text-neutral-600">Si un país ya existe, “Agregar” lo actualiza.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-lg border border-neutral-200 bg-white p-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-neutral-800">Listado</h3>
                        <p class="text-xs text-neutral-500" x-text="items.length + ' país(es)'">0 país(es)</p>
                    </div>

                    <div class="mt-3 overflow-hidden rounded-lg border border-neutral-200">
                        <table class="min-w-full bg-white">
                            <thead class="bg-neutral-50">
                                <tr>
                                    <th class="px-3 py-2 text-left text-[11px] font-bold text-neutral-600">País</th>
                                    <th class="px-3 py-2 text-right text-[11px] font-bold text-neutral-600">Convenios</th>
                                    <th class="px-3 py-2 text-center text-[11px] font-bold text-neutral-600 w-16">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-200">
                                <template x-if="items.length === 0">
                                    <tr>
                                        <td colspan="3" class="px-3 py-6 text-center text-xs text-neutral-500">
                                            Aún no agregas países. Selecciona uno y coloca su cantidad.
                                        </td>
                                    </tr>
                                </template>

                                <template x-for="row in items" :key="row.country">
                                    <tr class="hover:bg-neutral-50">
                                        <td class="px-3 py-2 text-[13px] text-neutral-800" x-text="row.country"></td>
                                        <td class="px-3 py-2 text-right text-[13px] font-semibold text-neutral-800" x-text="row.count"></td>
                                        <td class="px-3 py-2 text-center">
                                            <button
                                                type="button"
                                                @click="removeItem(row.country)"
                                                class="inline-flex items-center justify-center rounded-md border border-neutral-200 bg-white px-2 py-1 text-xs font-semibold text-neutral-700 hover:bg-neutral-100"
                                            >
                                                Quitar
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rounded-lg border border-neutral-200 bg-neutral-50/60">
        <div class="flex items-center gap-2 border-b border-neutral-200/70 px-4 py-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#D9324D" viewBox="0 0 256 256">
                <path d="M224,128a96,96,0,1,1-96-96A96,96,0,0,1,224,128Z" opacity="0.2"></path>
                <path d="M140,180a12,12,0,1,1-12-12A12,12,0,0,1,140,180ZM128,72c-22.06,0-40,16.15-40,36v4a8,8,0,0,0,16,0v-4c0-11,10.77-20,24-20s24,9,24,20-10.77,20-24,20a8,8,0,0,0-8,8v8a8,8,0,0,0,16,0v-.72c18.24-3.35,32-17.9,32-35.28C168,88.15,150.06,72,128,72Zm104,56A104,104,0,1,1,128,24,104.11,104.11,0,0,1,232,128Zm-16,0a88,88,0,1,0-88,88A88.1,88.1,0,0,0,216,128Z"></path>
            </svg>
            <h2 class="text-sm font-bold text-neutral-700">Sección de Preguntas Frecuentes</h2>
        </div>
        <div class="p-4"></div>
    </div>
</div>