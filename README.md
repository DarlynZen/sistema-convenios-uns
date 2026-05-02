# Sistema de Convenios UNS

Plataforma web para la gestion de convenios institucionales de la UNS. Ofrece un sitio publico con informacion de convenios y un panel de administracion seguro para gestionar contenido, catalogos y documentos.

## Destacado

- Publicacion de convenios al publico con contenido institucional.
- Panel de administracion para crear, consultar y eliminar convenios.
- Gestion de documentos vinculados a cada convenio.
- Catalogos y contenido editable (hero, contacto, FAQ).

## Stack tecnologico

- Laravel
- Livewire
- Vite + Tailwind CSS
- Pest / PHPUnit

## Estructura general (arbol de carpetas)

```
app/
|-- Enums/
|-- Http/
|   |-- Controllers/
|   `-- Requests/
|-- Livewire/
|   |-- Actions/
|   `-- Forms/
|-- Models/
|-- Repositories/
|-- Services/
resources/
`-- views/
routes/
database/
public/
tests/
```

## Modulos principales

- Convenios: altas, listado, detalle y eliminacion.
- Documentos de convenio: adjuntos y gestion de archivos.
- Contenido institucional: hero, contacto y FAQ.
- Catalogos: beneficiarios y datos auxiliares.

## Rutas clave

- Publico: `/inicio`, `/nuestros-convenios`
- Admin: `/admin` (requiere autenticacion)

## Configuracion rapida

1. Clonar el repositorio.
2. Instalar dependencias: `composer install` y `npm install`.
3. Crear `.env` desde `.env.example` y configurar base de datos.
4. Generar clave: `php artisan key:generate`.
5. Ejecutar migraciones: `php artisan migrate`.
6. Compilar assets: `npm run dev`.

## Licencia

Uso interno. Revisar politicas institucionales antes de redistribuir.
