<div class="rounded-lg border border-neutral-200 bg-neutral-50/60">
	<div class="flex flex-col gap-1 border-b border-neutral-200/70 px-4 py-3 sm:flex-row sm:items-center sm:justify-between">
		<div class="flex items-center gap-2">
			<span class="inline-flex h-2 w-2 rounded-full bg-brand-600" aria-hidden="true"></span>
			<h2 class="text-sm font-bold text-neutral-700">Información de contacto</h2>
		</div>
	</div>

	<div class="p-4">
		<form class="space-y-4" method="POST" action="{{ route('admin.contenido.contacto.save') }}">
			@csrf

			<div class="grid grid-cols-1 gap-4 md:grid-cols-2">
				<div>
					<x-input-label for="contacto_nombre_direccion" value="Nombre de la dirección" />
					<x-text-input
						id="contacto_nombre_direccion"
						name="contacto_nombre_direccion"
						type="text"
						class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-brand-500 focus:ring-2 focus:ring-brand-100"
						placeholder="Ej: Rectorado - 1er piso"
						value="{{ old('contacto_nombre_direccion', $contactoNombreDireccion ?? '') }}"
					/>
					@error('contacto_nombre_direccion')
						<p class="mt-1 text-xs text-red-600">{{ $message }}</p>
					@enderror
				</div>

				<div>
					<x-input-label for="contacto_telefono" value="Nro telefónico" />
					<x-text-input
						id="contacto_telefono"
						name="contacto_telefono"
						type="text"
						class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-brand-500 focus:ring-2 focus:ring-brand-100"
						placeholder="Ej: (+51) 123 456 189"
						value="{{ old('contacto_telefono', $contactoTelefono ?? '') }}"
					/>
					@error('contacto_telefono')
						<p class="mt-1 text-xs text-red-600">{{ $message }}</p>
					@enderror
				</div>
			</div>

			<div>
				<x-input-label for="contacto_ubicacion" value="Ubicación" />
				<textarea
					id="contacto_ubicacion"
					name="contacto_ubicacion"
					rows="3"
					class="mt-1 block w-full resize-y rounded-lg border border-neutral-200 px-3 py-2 text-[13px] text-neutral-800 placeholder:text-neutral-400 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100"
					placeholder="Ej: Av. Universitaria S/N - Nuevo Chimbote - Campus I - UNS."
				>{{ old('contacto_ubicacion', $contactoUbicacion ?? '') }}</textarea>
				@error('contacto_ubicacion')
					<p class="mt-1 text-xs text-red-600">{{ $message }}</p>
				@enderror
			</div>

			<div>
				<x-input-label for="contacto_correo" value="Correo" />
				<x-text-input
					id="contacto_correo"
					name="contacto_correo"
					type="email"
					class="mt-1 block w-full rounded-lg border border-neutral-200 px-3 py-2 text-[13px] focus:border-brand-500 focus:ring-2 focus:ring-brand-100"
					placeholder="Ej: oficinaconvenios@uns.edu.pe"
					value="{{ old('contacto_correo', $contactoCorreo ?? '') }}"
				/>
				@error('contacto_correo')
					<p class="mt-1 text-xs text-red-600">{{ $message }}</p>
				@enderror
			</div>

			<div class="flex justify-end pt-1">
				<x-admin.confirm-button type="submit">Guardar</x-admin.confirm-button>
			</div>
		</form>
	</div>
</div>