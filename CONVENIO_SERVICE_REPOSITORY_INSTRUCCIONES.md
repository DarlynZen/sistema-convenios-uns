# Instrucciones para trabajar con el patrón Service-Repository

## Objetivo
Mantener una separación clara entre:
- **Controller**: recibe la petición y arma la respuesta.
- **Service**: contiene reglas de negocio y orquestación.
- **Repository**: ejecuta acceso a datos y transacciones.

## Responsabilidades

### Controller
- Recibe `Request` validado.
- Decide qué vista devolver o qué redirect hacer.
- Compone los datos de cada pantalla usando métodos neutros del service/repository.
- No debe contener lógica de negocio ni consultas complejas.

### Service
- Aplica reglas de negocio.
- Normaliza o transforma datos antes de persistirlos.
- Reutiliza métodos neutros del repository.
- No debe tener métodos acoplados a pantallas como `index`, `edit`, `show`, `form`, `view`.
- No debe manejar transacciones de BD.

### Repository
- Encapsula consultas, relaciones y persistencia.
- Maneja `DB::transaction()` cuando una operación debe ser atómica.
- Ejecuta `create`, `update`, `delete`, `findOrFail`, `with`, `sync` y similares.
- Puede exponer métodos de carga neutros como:
  - `obtenerPorId(int $id)`
  - `obtenerConRelaciones(int $id)`
  - `listarConRelaciones()`
  - `obtenerCatalogos()`

## Reglas de diseño

1. Usar nombres neutros y reutilizables.
2. Evitar métodos orientados a vista en el service.
3. Mantener la lógica de negocio cerca del service.
4. Mantener la persistencia y transacciones en el repository.
5. No duplicar transformaciones ni consultas.
6. Preferir métodos pequeños y con una sola responsabilidad.
7. Si un dato solo sirve para una vista, componerlo en el controller.
8. Si un dato afecta el guardado, procesarlo en el service o repository según corresponda.

## Flujo recomendado

### Para guardar o actualizar
1. El controller recibe el request validado.
2. El service normaliza datos:
   - calcula fechas
   - arma estructuras JSON
   - separa relaciones como beneficiarios
3. El repository persiste todo dentro de una transacción.
4. El controller responde con redirect/toast/flash.

### Para mostrar o editar
1. El controller solicita al service/repository el modelo o colección.
2. El controller carga catálogos y datos extra necesarios.
3. La vista solo renderiza datos, sin lógica de negocio pesada.

## Convenciones de nombres

- `obtenerPorId()`: trae un registro simple.
- `obtenerConRelaciones()`: trae un registro con relaciones.
- `listarConRelaciones()`: trae listado con relaciones.
- `obtenerCatalogos()`: trae datos de apoyo para formularios.
- `validarDatosFormulario()`: prepara datos antes de persistir.
- `calcularFechaConDuracion()`: calcula fechas a partir de duración.
- `generarDetallesCoordinadores()`: arma la estructura de coordinadores.

## Qué evitar

- `getEditFormData()`
- `getShowViewData()`
- `obtenerDatosIndex()`
- lógica de HTML o Blade dentro del service
- transacciones en el service
- consultas repetidas entre service y repository

## Criterio de mantenimiento

Si una función:
- depende de una pantalla, va al controller.
- transforma datos de negocio, va al service.
- consulta o guarda en BD, va al repository.

