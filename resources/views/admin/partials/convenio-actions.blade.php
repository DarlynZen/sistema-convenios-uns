@props(['row'])

<div class="flex items-center gap-2">
    <button type="button" class="px-2 py-1 bg-blue-600 text-white rounded text-sm" @click.prevent="console.log('Editar', {{ json_encode($row) }})">Editar</button>
    <button type="button" class="px-2 py-1 bg-gray-200 text-gray-700 rounded text-sm" @click.prevent="console.log('Ver detalle', {{ json_encode($row) }})">Ver Detalle</button>
    <button type="button" class="px-2 py-1 bg-red-600 text-white rounded text-sm" @click.prevent="console.log('Eliminar', {{ json_encode($row) }})">Eliminar</button>
</div>
