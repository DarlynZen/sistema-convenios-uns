@php
	$sampleNoticia = [
		'href' => '#',
		'image' => asset('assets/images/portada.jpg'),
		'category' => 'Becas',
		'title' => 'Convocatoria Abierta: Becas de Intercambio 2025',
		'excerpt' => 'Se encuentra abierta la convocatoria para becas de intercambio estudiantil para el año académico 2025. Conoce los requisitos y destinos disponibles. Aplica ahora y amplía tus horizontes académicos.',
		'date' => '10 de julio de 2024',
		'author' => 'Dra. Ana Martínez',
		'tags' => ['Intercambio', 'Becas'],
	];

	$noticias = [
		$sampleNoticia,
		[
			'href' => '#',
			'image' => asset('assets/images/portada.jpg'),
			'category' => 'Convenios',
			'title' => 'UNS firma alianza estratégica con institución internacional',
			'excerpt' => 'La Universidad Nacional del Santa fortalece su proyección académica y científica a través de un nuevo convenio de cooperación.',
			'date' => '02 de agosto de 2024',
			'author' => 'Oficina de Convenios',
			'tags' => ['Alianzas', 'Cooperación'],
		],
		[
			'href' => '#',
			'image' => asset('assets/images/portada.jpg'),
			'category' => 'Eventos',
			'title' => 'Charla informativa: oportunidades de movilidad estudiantil',
			'excerpt' => 'Participa en la charla y conoce las convocatorias vigentes, requisitos y recomendaciones para postular.',
			'date' => '18 de septiembre de 2024',
			'author' => 'Equipo DCTIA',
			'tags' => ['Movilidad', 'Charlas'],
		],
	];
@endphp

<div
	x-data="{
		isModalOpen: false,
		mode: 'create',
		maxExcerptWords: 50,
		form: {
			category: '',
			date: '',
			title: '',
			excerpt: '',
			author: '',
			href: '',
			imageFile: null,
			imageFileName: '',
			imagePreviewUrl: '',
			tags: ''
		},
		countWords(text) {
			if (!text) return 0;
			return text
				.trim()
				.split(/\s+/)
				.filter(Boolean).length;
		},
		trimToMaxWords(text, maxWords) {
			if (!text) return '';
			const words = text.trim().split(/\s+/).filter(Boolean);
			if (words.length <= maxWords) return text;
			return words.slice(0, maxWords).join(' ');
		},
		onExcerptInput(e) {
			const raw = e?.target?.value ?? '';
			const trimmed = this.trimToMaxWords(raw, this.maxExcerptWords);
			this.form.excerpt = trimmed;
			e.target.value = trimmed;
		},
		get excerptWordsCount() {
			return this.countWords(this.form.excerpt);
		},
		onImageChange(e) {
			const file = e?.target?.files?.[0] ?? null;
			this.form.imageFile = file;
			this.form.imageFileName = file?.name ?? '';

			if (this.form.imagePreviewUrl && this.form.imagePreviewUrl.startsWith('blob:')) {
				URL.revokeObjectURL(this.form.imagePreviewUrl);
			}
			this.form.imagePreviewUrl = file ? URL.createObjectURL(file) : '';
		},
		openCreate() {
			this.mode = 'create';
			this.form = {
				category: '',
				date: '',
				title: '',
				excerpt: '',
				author: '',
				href: '',
				imageFile: null,
				imageFileName: '',
				imagePreviewUrl: '',
				tags: ''
			};
			this.isModalOpen = true;
		},
		openEdit(item) {
			this.mode = 'edit';
			this.form = {
				category: item.category || '',
				date: item.date || '',
				title: item.title || '',
				excerpt: this.trimToMaxWords(item.excerpt || '', this.maxExcerptWords),
				author: item.author || '',
				href: item.href || '',
				imageFile: null,
				imageFileName: '',
				imagePreviewUrl: item.image || '',
				tags: (item.tags || []).join(', ')
			};
			this.isModalOpen = true;
		},
		closeModal() {
			if (this.form?.imagePreviewUrl && this.form.imagePreviewUrl.startsWith('blob:')) {
				URL.revokeObjectURL(this.form.imagePreviewUrl);
			}
			this.isModalOpen = false;
		}
	}"
	class="space-y-4"
>
	{{-- Header + acciones --}}
	<div class="rounded-lg border border-neutral-200 bg-white">
		<div class="flex flex-col gap-3 border-b border-neutral-200 px-4 py-3 sm:flex-row sm:items-center sm:justify-between">
			<div class="flex items-center gap-2">
				<span class="inline-flex h-2 w-2 rounded-full bg-brand-600" aria-hidden="true"></span>
				<h2 class="text-sm font-bold text-neutral-700">Noticias</h2>
				<span class="inline-flex items-center rounded-full bg-brand-50 px-2 py-0.5 text-xs font-bold text-brand-700 ring-1 ring-brand-100">
					{{ count($noticias) }}
				</span>
			</div>

			<div class="flex flex-col gap-2 sm:flex-row sm:items-center">
				<div class="relative">
					<input
						type="text"
						placeholder="Buscar (UI)"
						class="w-full rounded-md border border-neutral-200 bg-white py-2 pl-9 pr-3 text-sm text-neutral-700 placeholder:text-neutral-400 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100 sm:w-64"
					/>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-neutral-400">
						<path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.3-4.3" />
						<path stroke-linecap="round" stroke-linejoin="round" d="M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" />
					</svg>
				</div>

				<button
					type="button"
					class="inline-flex items-center justify-center rounded-md border border-neutral-200 bg-white px-4 py-2 text-sm font-semibold text-neutral-700 transition-colors duration-200 hover:bg-neutral-50"
				>Filtrar</button>

				<x-admin.confirm-button type="button" @click="openCreate()">Nueva noticia</x-admin.confirm-button>
			</div>
		</div>

		<div class="p-4">
			<div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-3">
				@foreach($noticias as $i => $item)
					@php
						$payload = [
							'href' => $item['href'] ?? '#',
							'image' => $item['image'] ?? null,
							'category' => $item['category'] ?? null,
							'title' => $item['title'] ?? '',
							'excerpt' => $item['excerpt'] ?? '',
							'date' => $item['date'] ?? null,
							'author' => $item['author'] ?? null,
							'tags' => $item['tags'] ?? [],
						];
					@endphp

					<div class="rounded-lg border border-neutral-200 bg-white p-3 shadow-sm">
						<div class="flex items-start gap-3">
							<div class="h-16 w-20 shrink-0 overflow-hidden rounded-md bg-neutral-100 ring-1 ring-neutral-200">
								@if (!empty($payload['image']))
									<img src="{{ $payload['image'] }}" alt="{{ $payload['title'] }}" class="h-full w-full object-cover" loading="lazy" />
								@else
									<div class="flex h-full w-full items-center justify-center text-xs text-neutral-400">Sin imagen</div>
								@endif
							</div>

							<div class="min-w-0 flex-1">
								<div class="flex flex-wrap items-center gap-2">
									@if (!empty($payload['category']))
										<span class="inline-flex items-center rounded-full bg-brand-50 px-2 py-0.5 text-[11px] font-bold text-brand-700 ring-1 ring-brand-100">
											{{ $payload['category'] }}
										</span>
									@endif
									@if (!empty($payload['date']))
										<span class="text-[11px] font-semibold text-neutral-500">{{ $payload['date'] }}</span>
									@endif
								</div>

								<p class="mt-1 line-clamp-2 text-sm font-bold text-neutral-800">{{ $payload['title'] }}</p>
								@if (!empty($payload['excerpt']))
									<p class="mt-1 line-clamp-2 text-xs leading-5 text-neutral-600">{{ $payload['excerpt'] }}</p>
								@endif

								<div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-1 text-[11px] text-neutral-500">
									@if (!empty($payload['author']))
										<span class="font-semibold text-neutral-700">{{ $payload['author'] }}</span>
									@endif
									@if (!empty($payload['href']))
										<span class="truncate">{{ $payload['href'] }}</span>
									@endif
								</div>
							</div>
						</div>

						@if (!empty($payload['tags']))
							<div class="mt-3 flex flex-wrap gap-2">
								@foreach(($payload['tags'] ?? []) as $tag)
									<span class="inline-flex items-center rounded bg-neutral-50 px-2 py-1 text-[11px] font-semibold text-neutral-700 ring-1 ring-neutral-200">
										{{ $tag }}
									</span>
								@endforeach
							</div>
						@endif

						<div class="mt-3 flex flex-col gap-2 sm:flex-row sm:justify-end">
							<button
								type="button"
								class="inline-flex items-center justify-center rounded-md border border-neutral-200 bg-white px-3 py-2 text-xs font-bold text-neutral-700 transition-colors duration-200 hover:bg-neutral-50"
								@click='openEdit(@js($payload))'
							>Editar</button>
							<button
								type="button"
								class="inline-flex items-center justify-center rounded-md border border-brand-100 bg-brand-50 px-3 py-2 text-xs font-bold text-brand-700 transition-colors duration-200 hover:bg-brand-100"
							>Eliminar</button>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>

	{{-- Modal: crear/editar (UI estática) --}}
	<div
		x-show="isModalOpen"
		x-cloak
		class="fixed inset-0 z-50 flex items-end justify-center p-4 sm:items-center"
		aria-modal="true"
		role="dialog"
		@keydown.escape.window="closeModal()"
	>
		<div class="absolute inset-0 bg-black/40" @click="closeModal()"></div>

		<div class="relative w-full max-w-2xl rounded-xl border border-neutral-200 bg-white shadow-xl">
			<div class="flex items-start justify-between gap-3 border-b border-neutral-200 px-4 py-3">
				<div class="min-w-0">
					<p class="text-sm font-bold text-neutral-800" x-text="mode === 'create' ? 'Nueva noticia' : 'Editar noticia'"></p>
					<p class="mt-0.5 text-xs text-neutral-500">Por ahora es un diseño estático (sin guardar real).</p>
				</div>
				<button type="button" class="rounded-md p-2 text-neutral-500 hover:bg-neutral-50" @click="closeModal()" aria-label="Cerrar">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4">
						<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
					</svg>
				</button>
			</div>

			<form class="space-y-4 px-4 py-4" action="#" method="POST" enctype="multipart/form-data" onsubmit="return false">
				@csrf
				<div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
					<div>
						<x-input-label for="modal_news_category" value="Categoría" />
						<input
							id="modal_news_category"
							x-model="form.category"
							type="text"
							class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100"
							placeholder="Ej: Becas"
						/>
					</div>

					<div>
						<x-input-label for="modal_news_date" value="Fecha" />
						<input
							id="modal_news_date"
							x-model="form.date"
							type="text"
							readonly
							class="hs-datepicker mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100"
							data-hs-datepicker='{"mode":"custom-select","dateFormat":"YYYY-MM-DD","dateLocale":"es-ES"}'
							placeholder="YYYY-MM-DD"
						/>
					</div>
				</div>

				<div>
					<x-input-label for="modal_news_title" value="Título" />
					<input
						id="modal_news_title"
						x-model="form.title"
						type="text"
						class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100"
						placeholder="Título de la noticia"
					/>
				</div>

				<div>
					<x-input-label for="modal_news_excerpt" value="Resumen" />
					<textarea
						id="modal_news_excerpt"
						x-model="form.excerpt"
						@input="onExcerptInput($event)"
						rows="4"
						class="mt-1 block w-full resize-y rounded-lg border border-neutral-200 px-3 py-2 text-[13px] text-neutral-800 placeholder:text-neutral-400 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100"
						placeholder="Breve descripción..."
					></textarea>
					<div class="mt-1 flex items-start justify-between gap-3 text-xs text-neutral-500">
						<p>Solo admite como máximo 50 palabras.</p>
						<p class="shrink-0" :class="excerptWordsCount >= maxExcerptWords ? 'font-semibold text-neutral-700' : ''">
							<span x-text="excerptWordsCount"></span>/<span x-text="maxExcerptWords"></span> palabras
						</p>
					</div>
				</div>

				<div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
					<div>
						<x-input-label for="modal_news_author" value="Autor" />
						<input
							id="modal_news_author"
							x-model="form.author"
							type="text"
							class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100"
							placeholder="Ej: Dra. Ana Martínez"
						/>
					</div>

					<div>
						<x-input-label for="modal_news_href" value="Enlace (href)" />
						<input
							id="modal_news_href"
							x-model="form.href"
							type="text"
							class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100"
							placeholder="# o URL"
						/>
					</div>
				</div>

				<div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
					<div>
						<x-input-label for="modal_news_image" value="Imagen (subir archivo)" />
						<div class="mt-1 space-y-2">
							<input
								id="modal_news_image"
								type="file"
								accept="image/*"
								@change="onImageChange($event)"
								class="block w-full rounded-lg border border-neutral-200 bg-white px-3 py-2 text-[13px] text-neutral-700 file:mr-3 file:rounded-md file:border-0 file:bg-neutral-100 file:px-3 file:py-2 file:text-[12px] file:font-semibold file:text-neutral-700 hover:file:bg-neutral-200 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100"
							/>
							<p class="text-xs text-neutral-500" x-show="form.imageFileName" x-text="form.imageFileName"></p>

							<div class="h-24 w-full overflow-hidden rounded-lg border border-neutral-200 bg-neutral-50" x-show="form.imagePreviewUrl">
								<img :src="form.imagePreviewUrl" alt="Previsualización" class="h-full w-full object-cover" />
							</div>
							<p class="text-xs text-neutral-500" x-show="!form.imagePreviewUrl">Aún no se ha seleccionado una imagen.</p>
						</div>
					</div>

					<div>
						<x-input-label for="modal_news_tags" value="Tags (separadas por coma)" />
						<input
							id="modal_news_tags"
							x-model="form.tags"
							type="text"
							class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100"
							placeholder="Intercambio, Becas"
						/>
					</div>
				</div>

				<div class="flex flex-col gap-2 border-t border-neutral-200 pt-4 sm:flex-row sm:justify-end">
					<button
						type="button"
						class="inline-flex items-center justify-center rounded-md border border-neutral-200 bg-white px-4 py-2 text-sm font-semibold text-neutral-700 transition-colors duration-200 hover:bg-neutral-50"
						@click="closeModal()"
					>Cancelar</button>
					<x-admin.confirm-button type="submit">Guardar</x-admin.confirm-button>
				</div>
			</form>
		</div>
	</div>
</div>