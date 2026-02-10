@php
	$objetivos = [
		[
			'title' => 'Convenio Internacional',
			'text' => 'Establecemos vínculos con universidades y centros de investigación de todo el mundo.',
		],
		[
			'title' => 'Movilidad Estudiantil',
			'text' => 'Facilitamos intercambios académicos y programas de doble titulación.',
		],
		[
			'title' => 'Gestión Administrativa',
			'text' => 'Administramos todos los aspectos legales y administrativos de los convenios.',
		],
		[
			'title' => 'Objetivos Estratégicos',
			'text' => 'Alineamos las alianzas con los objetivos institucionales de la universidad.',
		],
	];

	$miembros = [
		[
			'name' => 'Dra. María Pérez',
			'position' => 'Directora de Cooperación Técnica e Intercambio Académico',
			'image' => asset('assets/images/coordinador-universidad-foto-profesional.jpg'),
			'description' => 'Con más de 15 años de experiencia en gestión de convenios internacionales, lidera iniciativas estratégicas que fortalecen la presencia global de la UNS.',
		],
		[
			'name' => 'Ing. Carlos Ramírez',
			'position' => 'Coordinador de Convenios Internacionales',
			'image' => asset('assets/images/directora-universidad-foto-profesional.jpg'),
			'description' => 'Especialista en relaciones internacionales, gestiona alianzas académicas y culturales con instituciones de todo el mundo.',
		],
		[
			'name' => 'Lic. Ana Gómez',
			'position' => 'Especialista en Movilidad Estudiantil',
			'image' => asset('assets/images/especialista-universidad-foto-profesional.jpg'),
			'description' => 'Coordina programas de intercambio y doble titulación, facilitando experiencias internacionales para nuestros estudiantes.',
		],
	];
@endphp

<div
	x-data="{
		isMemberModalOpen: false,
		memberMode: 'create',
		memberForm: {
			name: '',
			position: '',
			description: '',
			imageFileName: '',
			imagePreviewUrl: ''
		},
		openMemberCreate() {
			this.memberMode = 'create';
			this.memberForm = { name: '', position: '', description: '', imageFileName: '', imagePreviewUrl: '' };
			this.isMemberModalOpen = true;
		},
		openMemberEdit(member) {
			this.memberMode = 'edit';
			this.memberForm = {
				name: member?.name ?? '',
				position: member?.position ?? '',
				description: member?.description ?? '',
				imageFileName: '',
				imagePreviewUrl: member?.image ?? ''
			};
			this.isMemberModalOpen = true;
		},
		closeMemberModal() {
			if (this.memberForm?.imagePreviewUrl && this.memberForm.imagePreviewUrl.startsWith('blob:')) {
				URL.revokeObjectURL(this.memberForm.imagePreviewUrl);
			}
			this.isMemberModalOpen = false;
		},
		onMemberImageChange(e) {
			const file = e?.target?.files?.[0] ?? null;
			this.memberForm.imageFileName = file?.name ?? '';
			if (this.memberForm.imagePreviewUrl && this.memberForm.imagePreviewUrl.startsWith('blob:')) {
				URL.revokeObjectURL(this.memberForm.imagePreviewUrl);
			}
			this.memberForm.imagePreviewUrl = file ? URL.createObjectURL(file) : (this.memberForm.imagePreviewUrl ?? '');
		}
	}"
	class="space-y-4"
>
	{{-- Encabezado del tab --}}
	<div class="rounded-lg border border-neutral-200 bg-white">
		<div class="flex flex-col gap-2 border-b border-neutral-200 px-4 py-3 sm:flex-row sm:items-center sm:justify-between">
			<div class="flex items-center gap-2">
				<span class="inline-flex h-2 w-2 rounded-full bg-brand-600" aria-hidden="true"></span>
				<h2 class="text-sm font-bold text-neutral-700">Nosotros</h2>
				<span class="inline-flex items-center rounded-full bg-neutral-50 px-2 py-0.5 text-xs font-bold text-neutral-700 ring-1 ring-neutral-200">UI</span>
			</div>

			<div class="text-xs text-neutral-500">Diseño estático (sin guardado real)</div>
		</div>

		<div class="p-4 space-y-4">
			<div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
				<div>
					<x-input-label for="nosotros_titulo" value="Título descriptivo" />
					<x-text-input
						id="nosotros_titulo"
						name="nosotros_titulo"
						type="text"
						class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-brand-500 focus:ring-2 focus:ring-brand-100"
						placeholder="Ej: Acerca de la Dirección de Cooperación Técnica e Intercambio Académico"
						value="Acerca de la Dirección de Cooperación Técnica e Intercambio Académico"
					/>
					<p class="mt-1 text-xs text-neutral-500">Este texto aparece como encabezado del tab “Nosotros”.</p>
				</div>

				<div>
					<x-input-label for="nosotros_subtitulo" value="Descripción" />
					<textarea
						id="nosotros_subtitulo"
						name="nosotros_subtitulo"
						rows="5"
						class="mt-1 block w-full resize-y rounded-lg border border-neutral-200 px-3 py-2 text-[13px] text-neutral-800 placeholder:text-neutral-400 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100"
						placeholder="Escribe la descripción de la dirección..."
					>La Dirección de Cooperación Técnica e Intercambio Académico de la Universidad Nacional del Santa (UNS) fomenta el establecimiento de alianzas académicas, de investigación y culturales con instituciones del Perú y del extranjero, fortaleciendo nuestra misión educativa y potenciando el desarrollo regional.</textarea>
				</div>
			</div>

			<div class="rounded-lg border border-neutral-200 bg-neutral-50/60">
				<div class="flex items-center justify-between gap-3 border-b border-neutral-200/70 px-4 py-3">
					<div class="flex items-center gap-2">
						<span class="inline-flex h-2 w-2 rounded-full bg-brand-600" aria-hidden="true"></span>
						<h3 class="text-sm font-bold text-neutral-700">Objetivos</h3>
					</div>
					<button
						type="button"
						class="inline-flex items-center rounded-md border border-neutral-200 bg-white px-3 py-2 text-xs font-bold text-neutral-700 hover:bg-neutral-50"
					>+ Agregar objetivo</button>
				</div>

				<div class="p-4">
					<div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4">
						@foreach ($objetivos as $i => $obj)
							<div class="rounded-lg border border-neutral-200 bg-white p-3 shadow-sm">
								<div class="flex items-start justify-between gap-3">
									<p class="text-xs font-bold text-neutral-700">Objetivo {{ $i + 1 }}</p>
									<div class="flex items-center gap-2">
										<button type="button" class="text-neutral-600 hover:text-neutral-900" aria-label="Editar">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 256 256" fill="currentColor" aria-hidden="true">
												<path d="M227.31,73.37l-44.68-44.68a16,16,0,0,0-22.63,0L36.69,152a15.86,15.86,0,0,0-4.69,11.31V208a16,16,0,0,0,16,16H92.69A15.86,15.86,0,0,0,104,219.31L227.31,96A16,16,0,0,0,227.31,73.37ZM92.69,208H48V163.31l96-96L188.69,112ZM200,100.69,155.31,56l16-16L216,84.69Z"></path>
											</svg>
										</button>
										<button type="button" class="text-brand-600 hover:text-brand-700" aria-label="Eliminar">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 256 256" fill="currentColor" aria-hidden="true">
												<path d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16H48V208a24,24,0,0,0,24,24H184a24,24,0,0,0,24-24V64h8a8,8,0,0,0,0-16ZM96,40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96Zm96,168a8,8,0,0,1-8,8H72a8,8,0,0,1-8-8V64H192Z"></path>
											</svg>
										</button>
									</div>
								</div>

								<div class="mt-3 space-y-3">
									<div>
										<label class="block text-[11px] font-bold text-neutral-600">Título</label>
										<input
											type="text"
											value="{{ $obj['title'] }}"
											class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-brand-500 focus:ring-2 focus:ring-brand-100"
										/>
									</div>
									<div>
										<label class="block text-[11px] font-bold text-neutral-600">Descripción corta</label>
										<textarea
											rows="3"
											class="mt-1 block w-full resize-y rounded-lg border border-neutral-200 px-3 py-2 text-[13px] text-neutral-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100"
										>{{ $obj['text'] }}</textarea>
									</div>
								</div>
							</div>
						@endforeach
					</div>
				</div>
			</div>

			<div class="rounded-lg border border-neutral-200 bg-neutral-50/60">
				<div class="flex flex-col gap-2 border-b border-neutral-200/70 px-4 py-3 sm:flex-row sm:items-center sm:justify-between">
					<div class="flex items-center gap-2">
						<span class="inline-flex h-2 w-2 rounded-full bg-brand-600" aria-hidden="true"></span>
						<h3 class="text-sm font-bold text-neutral-700">Miembros del equipo</h3>
						<span class="inline-flex items-center rounded-full bg-brand-50 px-2 py-0.5 text-xs font-bold text-brand-700 ring-1 ring-brand-100">{{ count($miembros) }}</span>
					</div>

					<button
						type="button"
						class="inline-flex items-center justify-center rounded-md border border-neutral-200 bg-white px-4 py-2 text-sm font-semibold text-neutral-700 transition-colors duration-200 hover:bg-neutral-50"
						@click="openMemberCreate()"
					>+ Nuevo miembro</button>
				</div>

				<div class="p-4">
					<div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-3">
						@foreach ($miembros as $member)
							<div class="rounded-lg border border-neutral-200 bg-white p-3 shadow-sm">
								<div class="flex items-start gap-3">
									<div class="h-16 w-16 shrink-0 overflow-hidden rounded-md bg-neutral-100 ring-1 ring-neutral-200">
										<img src="{{ $member['image'] }}" alt="{{ $member['name'] }}" class="h-full w-full object-cover" loading="lazy" />
									</div>

									<div class="min-w-0 flex-1">
										<div class="flex items-start justify-between gap-3">
											<div class="min-w-0">
												<p class="truncate text-sm font-bold text-neutral-800">{{ $member['name'] }}</p>
												<p class="mt-0.5 line-clamp-2 text-xs font-semibold text-neutral-500">{{ $member['position'] }}</p>
											</div>
											<div class="flex items-center gap-2">
												<button type="button" class="text-neutral-600 hover:text-neutral-900" aria-label="Editar" @click='openMemberEdit(@js($member))'>
													<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 256 256" fill="currentColor" aria-hidden="true">
														<path d="M227.31,73.37l-44.68-44.68a16,16,0,0,0-22.63,0L36.69,152a15.86,15.86,0,0,0-4.69,11.31V208a16,16,0,0,0,16,16H92.69A15.86,15.86,0,0,0,104,219.31L227.31,96A16,16,0,0,0,227.31,73.37ZM92.69,208H48V163.31l96-96L188.69,112ZM200,100.69,155.31,56l16-16L216,84.69Z"></path>
													</svg>
												</button>
												<button type="button" class="text-brand-600 hover:text-brand-700" aria-label="Eliminar">
													<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 256 256" fill="currentColor" aria-hidden="true">
														<path d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16H48V208a24,24,0,0,0,24,24H184a24,24,0,0,0,24-24V64h8a8,8,0,0,0,0-16ZM96,40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96Zm96,168a8,8,0,0,1-8,8H72a8,8,0,0,1-8-8V64H192Z"></path>
													</svg>
												</button>
											</div>
										</div>

										<p class="mt-2 line-clamp-3 text-xs leading-5 text-neutral-600">{{ $member['description'] }}</p>
									</div>
								</div>
							</div>
						@endforeach
					</div>
				</div>
			</div>

			<div class="flex justify-end">
				<x-admin.confirm-button type="button">Guardar</x-admin.confirm-button>
			</div>
		</div>
	</div>

	{{-- Modal: Nuevo/Editar miembro (UI) --}}
	<div
		x-show="isMemberModalOpen"
		x-cloak
		class="fixed inset-0 z-50 flex items-end justify-center p-4 sm:items-center"
		aria-modal="true"
		role="dialog"
		@keydown.escape.window="closeMemberModal()"
	>
		<div class="fixed inset-0 bg-black/40" @click="closeMemberModal()"></div>

		<div class="relative w-full max-w-2xl rounded-xl border border-neutral-200 bg-white shadow-xl">
			<div class="flex items-start justify-between gap-3 border-b border-neutral-200 px-4 py-3">
				<div class="min-w-0">
					<p class="text-sm font-bold text-neutral-800" x-text="memberMode === 'create' ? 'Nuevo miembro' : 'Editar miembro'"></p>
					<p class="mt-0.5 text-xs text-neutral-500">Diseño estático (sin guardar real).</p>
				</div>
				<button type="button" class="rounded-md p-2 text-neutral-500 hover:bg-neutral-50" @click="closeMemberModal()" aria-label="Cerrar">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4">
						<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
					</svg>
				</button>
			</div>

			<div class="p-4 space-y-4">
				<div class="grid grid-cols-1 gap-4 md:grid-cols-2">
					<div>
						<label class="block text-xs font-semibold text-neutral-700">Nombre</label>
						<input type="text" x-model="memberForm.name" class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-brand-500 focus:ring-2 focus:ring-brand-100" placeholder="Ej: Dra. María Pérez" />
					</div>

					<div>
						<label class="block text-xs font-semibold text-neutral-700">Cargo</label>
						<input type="text" x-model="memberForm.position" class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-brand-500 focus:ring-2 focus:ring-brand-100" placeholder="Ej: Directora..." />
					</div>
				</div>

				<div>
					<label class="block text-xs font-semibold text-neutral-700">Descripción</label>
					<textarea x-model="memberForm.description" rows="4" class="mt-1 block w-full resize-y rounded-lg border border-neutral-200 px-3 py-2 text-[13px] text-neutral-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100" placeholder="Breve descripción del miembro..."></textarea>
				</div>

				<div class="grid grid-cols-1 gap-4 md:grid-cols-2 items-start">
					<div>
						<label class="block text-xs font-semibold text-neutral-700">Imagen</label>
						<input type="file" accept="image/*" @change="onMemberImageChange($event)" class="mt-1 block w-full text-[13px] text-neutral-700 file:mr-4 file:rounded-lg file:border-0 file:bg-neutral-100 file:px-3 file:py-2 file:text-[13px] file:font-medium file:text-neutral-700 hover:file:bg-neutral-200" />
						<p class="mt-1 text-xs text-neutral-500" x-text="memberForm.imageFileName ? ('Archivo: ' + memberForm.imageFileName) : 'Opcional: sube una foto del miembro.'"></p>
					</div>

					<div class="rounded-lg border border-neutral-200 bg-neutral-50 p-3">
						<p class="text-xs font-semibold text-neutral-700">Vista previa</p>
						<div class="mt-2 aspect-square w-full overflow-hidden rounded-lg bg-white ring-1 ring-neutral-200 flex items-center justify-center">
							<template x-if="memberForm.imagePreviewUrl">
								<img :src="memberForm.imagePreviewUrl" alt="Vista previa" class="h-full w-full object-cover" />
							</template>
							<template x-if="!memberForm.imagePreviewUrl">
								<span class="text-xs text-neutral-400">Sin imagen</span>
							</template>
						</div>
					</div>
				</div>
			</div>

			<div class="flex items-center justify-end gap-2 border-t border-neutral-200 px-4 py-3">
				<button type="button" class="rounded-md border border-neutral-200 bg-white px-4 py-2 text-sm font-semibold text-neutral-700 hover:bg-neutral-50" @click="closeMemberModal()">Cancelar</button>
				<x-admin.confirm-button type="button" @click="closeMemberModal()">Guardar</x-admin.confirm-button>
			</div>
		</div>
	</div>
</div>