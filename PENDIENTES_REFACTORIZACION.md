# Pendientes de refactorizacion y ajustes finales

## Contexto

Este documento consolida lo que todavia falta revisar o cambiar despues de comparar:

- `REFACTOR_ADMIN.md`
- `RESUMEN_VIOLACIONES.md`
- `ANALISIS_ARQUITECTURA.md`
- `CONVENIO_SERVICE_REPOSITORY_INSTRUCCIONES.md`
- El estado actual del codigo en `app/`

El proyecto ya avanzo bastante hacia el patron Service-Repository. Ya existen `ConvenioService`, `ConvenioRepository`, `DashboardService`, `CmsSeccionService`, `CmsSeccionRepository`, `DocumentoConvenioService`, `DocumentoConvenioRepository`, `ObservacionService`, `ObservacionRepository`, `FileService` y varios Form Requests.

Lo pendiente principal ya no es crear toda la arquitectura desde cero, sino terminar de limpiar controllers, alinear nombres de relaciones/modelos y corregir algunos puntos que pueden generar errores en runtime.

## Ya implementado

- `ConvenioController` ya usa `ConvenioRequest` y delega creacion, actualizacion, eliminacion y catalogos a `ConvenioService`.
- `ConvenioService` normaliza datos de formulario, calcula fechas por duracion y arma `detalles_coordinadores_json`.
- `ConvenioRepository` maneja persistencia y usa `DB::transaction()` en crear/actualizar, alineado con `CONVENIO_SERVICE_REPOSITORY_INSTRUCCIONES.md`.
- `DashboardService` reemplaza la antigua idea de `Convenio::getDashboardStats()`.
- `DocumentoConvenioController` ya usa `StoreDocumentoConvenioRequest`, `UpdateDocumentoConvenioRequest`, `DocumentoConvenioService` y `DocumentoConvenioRepository`.
- `ObservacionController` ya usa `StoreObservacionRequest`, `UpdateObservacionRequest`, `ObservacionService` y `ObservacionRepository`.
- `CmsSeccion` ya esta limpio de metodos estaticos tipo `getAll()` o `findBySlug()`.
- `Convenio` ya esta mucho mas limpio: no contiene `getAllWithRelations()`, `createWithBeneficiarios()`, `updateWithBeneficiarios()`, `deleteWithRelations()` ni `getDashboardStats()`.

## Pendientes criticos

### 1. Corregir relaciones de beneficiarios

Hay una inconsistencia importante entre el nombre de la relacion y como se usa.

En `App\Models\Convenio` existe:

```php
public function beneficiario(): BelongsToMany
```

Pero en `ConvenioController@show` se usa:

```php
$convenio->beneficiarios
```

Eso puede devolver `null` porque no existe una relacion `beneficiarios()` en el model `Convenio`.

Recomendacion:

- Renombrar la relacion de `Convenio::beneficiario()` a `Convenio::beneficiarios()`.
- Actualizar `ConvenioRepository` para usar `$convenio->beneficiarios()->sync(...)`.
- Actualizar `queryConRelaciones()` para cargar `beneficiarios`.
- Revisar todas las referencias a `beneficiario` y `beneficiarios`.

Tambien en `App\Models\Beneficiario` la relacion:

```php
return $this->belongsToMany(Convenio::class);
```

deberia declarar explicitamente la tabla pivote real:

```php
return $this->belongsToMany(Convenio::class, 'convenios_beneficiarios', 'beneficiario_id', 'convenio_id');
```

La migracion confirma que la tabla pivote se llama `convenios_beneficiarios`.

### 2. Corregir metodos `canBeDeleted()` usados pero no definidos

`AmbitoController` llama:

```php
$ambito->canBeDeleted()
```

`TipoConvenioController` llama:

```php
$tipoConvenio->canBeDeleted()
```

Pero los models `Ambito` y `TipoConvenio` actuales no tienen ese metodo. Esto puede romper al intentar eliminar esos registros.

Recomendacion:

- Agregar `canBeDeleted()` en `Ambito`.
- Agregar `canBeDeleted()` en `TipoConvenio`.
- Considerar agregarlo tambien en `Estado` si se implementa controller CRUD para estados.

Ejemplo:

```php
public function canBeDeleted(): bool
{
    return !$this->convenios()->exists();
}
```

### 3. Limpiar `ConvenioController@show`

Aunque `ConvenioController` ya delega varias tareas al service, el metodo `show()` todavia arma demasiados datos de presentacion:

- filas de informacion
- filas de vigencia
- filas de entidad
- datos de coordinadores
- formato de documentos adjuntos
- calculo de tamanio de archivos
- construccion de URLs de storage

Esto no necesariamente es "logica de negocio", pero si hace que el controller vuelva a crecer mucho.

Recomendacion:

- Crear un metodo especifico para preparar la vista, por ejemplo en un presenter/view model:
  - `ConvenioShowViewData`
  - `ConvenioPresenter`
  - o un metodo privado temporal si se quiere una refactorizacion gradual.
- Si se mantiene el criterio de `CONVENIO_SERVICE_REPOSITORY_INSTRUCCIONES.md`, evitar meter nombres como `getShowViewData()` dentro de `ConvenioService`, porque ese documento indica que el service no debe tener metodos acoplados a pantallas.
- La alternativa mas ordenada seria una clase aparte de presentacion, no el service de negocio.

## Pendientes de prioridad alta

### 4. Crear Form Requests faltantes para controllers CRUD simples

Todavia hay validacion inline con `$request->validate()` en:

- `AdminController`
- `AmbitoController`
- `BeneficiarioController`
- `TipoConvenioController`
- `CmsSeccionController`

Recomendacion:

- `StoreAmbitoRequest`
- `UpdateAmbitoRequest`
- `StoreBeneficiarioRequest`
- `UpdateBeneficiarioRequest`
- `StoreTipoConvenioRequest`
- `UpdateTipoConvenioRequest`
- `StoreCmsSeccionRequest`
- `UpdateCmsSeccionRequest`
- Requests especificos para contenido admin:
  - `UpdateHeroRequest`
  - `UpdateContactoRequest`
  - `StoreFaqRequest`
  - `UpdateFaqRequest`
  - `DeleteFaqRequest`
  - `UpdateBeneficiarioCatalogoRequest`

Esto cerraria una de las violaciones principales detectadas en `RESUMEN_VIOLACIONES.md`: validacion inline en controllers.

### 5. Separar mejor el modulo de catalogo dentro de `AdminController`

`AdminController` todavia importa `App\Models\Beneficiario` y maneja directamente:

- listado de beneficiarios del catalogo
- actualizacion de descripcion/estado

Eso rompe parcialmente la idea de que `AdminController` solo orqueste con services/repositories.

Recomendacion:

- Crear `BeneficiarioRepository` para listar y actualizar.
- Crear `BeneficiarioService` si se requiere regla de negocio para activar/desactivar o eliminar.
- Mover la validacion a `UpdateBeneficiarioCatalogoRequest`.
- Considerar mover estas acciones a `BeneficiarioController` o a un `CatalogoController`, para que `AdminController` no concentre responsabilidades.

### 6. Completar `BeneficiarioService`

`BeneficiarioController@destroy` todavia hace:

```php
$beneficiario->convenios()->detach();
$beneficiario->delete();
```

Esto estaba marcado como pendiente en `ANALISIS_ARQUITECTURA.md`.

Recomendacion:

- Crear `BeneficiarioService`.
- Mover ahi la eliminacion con detach.
- Usar la relacion pivote explicita mencionada en el pendiente 1.

## Pendientes de prioridad media

### 7. Revisar responsabilidades de `CmsSeccionService`

`CmsSeccionService` funciona, pero tiene metodos claramente orientados a vistas:

- `getHeroAdminViewData()`
- `getContactoAdminViewData()`
- `getFaqAdminViewData()`
- `getHeroPublicViewData()`
- `getContactoPublicViewData()`
- `getFaqPublicViewData()`

Esto contradice parcialmente `CONVENIO_SERVICE_REPOSITORY_INSTRUCCIONES.md`, que dice que los services no deberian tener metodos acoplados a pantallas como `view`, `form`, `index`, `edit` o `show`.

Recomendacion:

- Mantener en `CmsSeccionService` solo reglas de negocio y escritura de contenido.
- Mover preparacion de datos de pantalla a presenters, view models o al controller si son datos exclusivos de una vista.
- Si se decide conservarlo por simplicidad, documentarlo como excepcion consciente.

### 8. Crear repositorios para catalogos simples solo donde agreguen valor

Los documentos iniciales sugerian repositories para `TipoConvenio`, `Ambito` y otros catalogos. El documento de instrucciones posterior es mas pragmatico: no duplicar consultas si no aportan valor.

Recomendacion:

- No crear repositories solo para reemplazar `Model::all()` si no hay regla adicional.
- Si se necesitan en dashboard/catalogos, se puede crear un `CatalogoRepository` unico.
- Evitar que `ConvenioRepository` cuente tipos y ambitos si se quiere separar responsabilidades estrictamente.

Actualmente `ConvenioRepository` tiene:

- `contarTipos()`
- `contarAmbitos()`
- `obtenerCatalogos()`

Eso funciona, pero mezcla consultas de convenios con catalogos generales. Puede quedar asi por ahora, pero es candidato a limpieza.

### 9. Revisar nombres y consistencia de modelos de estado

Los documentos hablan de `EstadoConvenio` como model, pero el proyecto actual usa:

- `App\Models\Estado`
- `App\Enums\EstadoConvenio`
- tabla `estados_convenio`

Recomendacion:

- Mantener una convencion unica.
- Si el model queda como `Estado`, documentarlo y evitar crear otro model `EstadoConvenio`.
- Si se prefiere claridad de dominio, renombrar `Estado` a `EstadoConvenio` con cuidado, actualizando imports, relaciones, requests y seeders.

## Pendientes de prioridad baja

### 10. Eliminar o ajustar codigo no usado

En `ConvenioRepository` existe:

```php
public function contarRecientes($query, int $limit = 5)
```

No parece estar siendo usado y ademas recibe un `$query` externo, lo que rompe el estilo del resto del repository.

Recomendacion:

- Eliminarlo si no se usa.
- O renombrarlo/ajustarlo si realmente se necesita.

### 11. Revisar accessors del model `Convenio`

`Convenio::getDuracionAttribute()` usa:

```php
return $this->fecha_inicio
    ->locale('es')
    ->diffForHumans($this->fecha_fin, true);
```

Si `fecha_inicio` o `fecha_fin` son `null`, puede fallar.

Recomendacion:

- Hacerlo null-safe.
- Definir si `duracion` debe ser calculada desde fechas o desde `duracion_valor`/`duracion_unidad`.

### 12. Revisar comentarios temporales y nombres antiguos

Hay comentarios como:

- `//enum ver docs`
- `//obs de HasMany`

Recomendacion:

- Convertirlos en decisiones claras o eliminarlos.
- Si `convenioRenovado()` realmente representa convenios renovados por este convenio, deberia ser `HasMany`, no `BelongsTo`.

## Orden sugerido de trabajo

1. Corregir relaciones de beneficiarios y tabla pivote.
2. Agregar `canBeDeleted()` en models usados por controllers.
3. Crear Form Requests faltantes para `AdminController`, `AmbitoController`, `BeneficiarioController`, `TipoConvenioController` y `CmsSeccionController`.
4. Mover eliminacion de beneficiarios a `BeneficiarioService`.
5. Extraer la preparacion grande de `ConvenioController@show`.
6. Revisar `CmsSeccionService` y decidir si se queda como excepcion o si se separa en presenters/view data classes.
7. Revisar si `ConvenioRepository` debe seguir manejando catalogos y contadores de otros modelos.
8. Limpiar metodos no usados, comentarios temporales y accessors fragiles.

## Conclusiones

El refactor principal de convenios, documentos, observaciones y dashboard ya esta encaminado. Lo que falta ahora es cerrar inconsistencias y deuda secundaria.

Los cambios mas importantes no son crear mas capas por crear, sino:

- evitar errores reales de relaciones y metodos inexistentes;
- sacar validaciones inline que aun quedan;
- mantener los controllers pequenos;
- evitar que los services se conviertan en clases de preparacion de vistas;
- unificar nombres de relaciones y modelos.

