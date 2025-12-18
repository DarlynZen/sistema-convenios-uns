# Análisis de Arquitectura - Violaciones MVC y SOLID

## 📋 Resumen Ejecutivo

Este documento identifica violaciones de los principios MVC y SOLID en el código, y propone una reestructuración hacia una arquitectura más limpia y mantenible.

---

## 🔴 VIOLACIONES IDENTIFICADAS

### 1. **ConvenioController** - Múltiples violaciones

#### ❌ Problemas encontrados:

**Ubicación:** `app/Http/Controllers/ConvenioController.php`

**Violaciones:**

1. **SRP (Single Responsibility Principle)**: El controller mezcla:
   - Validación (`validateConvenio()` línea 108-128)
   - Gestión de transacciones (líneas 39-41, 81-83)
   - Orquestación de lógica de negocio
   - Manejo de errores

2. **Violación MVC**: Acceso directo a la base de datos (`DB::beginTransaction()`) en el controller

3. **Acoplamiento**: Depende directamente de métodos del Model que contienen lógica de negocio

**Código problemático:**
```php
// Líneas 33-49, 73-92
public function store(Request $request) {
    $validated = $this->validateConvenio($request);  // Validación en controller
    $beneficiarios = $request->input('beneficiarios');

    try {
        DB::beginTransaction();  // Transacciones en controller
        Convenio::createWithBeneficiarios($validated, $beneficiarios);  // Lógica en Model
        DB::commit();
        // ...
    }
}

// Línea 108-128
private function validateConvenio(Request $request): array {
    return $request->validate([/*...*/]);  // Validación debería ser FormRequest
}
```

**Problema:** El controller debería solo orquestar, no contener lógica de negocio ni validación.

---

### 2. **AdminController** - Lógica de acceso a datos

#### ❌ Problemas encontrados:

**Ubicación:** `app/Http/Controllers/AdminController.php`

**Violaciones:**

1. **MVC**: Acceso directo a métodos del Model que deberían estar en Repository/Service
2. **DIP (Dependency Inversion Principle)**: Depende de implementación concreta del Model

**Código problemático:**
```php
// Línea 14
$stats = Convenio::getDashboardStats();  // Lógica de negocio en Model

// Línea 20
$convenios = Convenio::getAllWithRelations();  // Query compleja en Model

// Línea 26
$secciones = CmsSeccion::getAll();  // Método innecesario en Model
```

**Problema:** El controller debería depender de abstracciones (Services/Repositories), no de Models directamente.

---

### 3. **DocumentoConvenioController** - Lógica de archivos

#### ❌ Problemas encontrados:

**Ubicación:** `app/Http/Controllers/DocumentoConvenioController.php`

**Violaciones:**

1. **SRP**: Mezcla lógica de archivos, validación y gestión de entidades
2. **Violación MVC**: Lógica de almacenamiento de archivos en el controller
3. **Reusabilidad**: La lógica de archivos no es reutilizable

**Código problemático:**
```php
// Líneas 29, 62-66, 74-76
$ruta = $request->file('documento')->store('documentos/convenios', 'public');  // Storage en controller

if ($documentoConvenio->ruta_documento && Storage::disk('public')->exists(...)) {
    Storage::disk('public')->delete(...);  // Eliminación de archivos en controller
}
```

**Problema:** La gestión de archivos debería estar en un Service especializado.

---

### 4. **ObservacionController** - Lógica de cálculo

#### ❌ Problemas encontrados:

**Ubicación:** `app/Http/Controllers/ObservacionController.php`

**Violaciones:**

1. **SRP**: Cálculo de versión en el controller
2. **Lógica de negocio**: Determinación de versión debería estar en Service

**Código problemático:**
```php
// Líneas 24, 31
$ultimaVersion = $convenio->observaciones()->max('version') ?? 0;
$observacion = Observacion::create([
    'version' => $validated['version'] ?? ($ultimaVersion + 1),  // Lógica en controller
]);
```

**Problema:** La lógica de versionado debería estar encapsulada en un Service.

---

### 5. **Controllers CRUD simples** - Validación en controllers

#### ❌ Problemas encontrados:

**Ubicación:** 
- `app/Http/Controllers/AmbitoController.php`
- `app/Http/Controllers/BeneficiarioController.php`
- `app/Http/Controllers/TipoConvenioController.php`
- `app/Http/Controllers/EstadoConvenioController.php`
- `app/Http/Controllers/CmsSeccionController.php`

**Violaciones:**

1. **SRP**: Validación mezclada con orquestación
2. **Reusabilidad**: Las reglas de validación no son reutilizables
3. **Mantenibilidad**: Cambios en validación requieren modificar controllers

**Código problemático:**
```php
// Ejemplo en AmbitoController línea 18-21
$validated = $request->validate([
    'nombre' => 'required|string|max:255|unique:ambitos,nombre',
    'descripcion' => 'nullable|string',
]);
```

**Problema:** Debería usar Form Request classes para validación.

---

### 6. **Model Convenio** - Fat Model (Modelo Gordo)

#### ❌ Problemas encontrados:

**Ubicación:** `app/Models/Convenio.php`

**Violaciones:**

1. **SRP**: El Model contiene:
   - Representación de datos (correcto)
   - Relaciones (correcto)
   - Queries complejas (incorrecto - línea 102-107)
   - Lógica de negocio (incorrecto - líneas 127-161)
   - Estadísticas (incorrecto - líneas 182-191)

2. **Fat Model Anti-pattern**: Demasiada responsabilidad en el Model

**Código problemático:**
```php
// Líneas 102-107: Query compleja
public static function getAllWithRelations() {
    return self::with(['tipoConvenio', 'ambito', 'estadoConvenio'])
        ->latest()
        ->paginate(15);
}

// Líneas 127-136: Lógica de negocio
public static function createWithBeneficiarios(array $data, ?array $beneficiarios = null) {
    $convenio = self::create($data);
    if ($beneficiarios) {
        $convenio->beneficiario()->sync($beneficiarios);
    }
    return $convenio;
}

// Líneas 182-191: Estadísticas (depende de otros Models)
public static function getDashboardStats(): array {
    return [
        'total_convenios' => self::count(),
        'convenios_activos' => self::activos()->count(),
        'tipos_convenio' => TipoConvenio::count(),  // Depende de otro Model
        'ambitos' => Ambito::count(),  // Depende de otro Model
        // ...
    ];
}
```

**Problema:** El Model debería solo representar la entidad y sus relaciones. Las queries complejas y lógica de negocio deberían estar en Repository/Service.

---

### 7. **Models simples** - Métodos innecesarios

#### ❌ Problemas encontrados:

**Ubicación:**
- `app/Models/Ambito.php` (línea 30-33)
- `app/Models/Beneficiario.php` (línea 31-34)
- `app/Models/TipoConvenio.php` (línea 30-33)
- `app/Models/EstadoConvenio.php` (línea 30-33)
- `app/Models/CmsSeccion.php` (líneas 33-36, 41-44)

**Violaciones:**

1. **YAGNI (You Aren't Gonna Need It)**: Métodos innecesarios que solo llaman a `all()`
2. **Violación de encapsulamiento**: No agregan valor

**Código problemático:**
```php
// Ejemplo en Ambito.php
public static function getAll() {
    return self::all();  // Método innecesario
}

// CmsSeccion.php
public static function findBySlug(string $slug) {
    return self::where('slug', $slug)->first();  // Debería ser scope o estar en Repository
}
```

**Problema:** Estos métodos no agregan valor. Mejor usar scopes o mover a Repository.

---

### 8. **BeneficiarioController** - Lógica de eliminación

#### ❌ Problemas encontrados:

**Ubicación:** `app/Http/Controllers/BeneficiarioController.php` (línea 48)

**Violaciones:**

1. **Violación MVC**: Lógica de relación many-to-many en el controller

**Código problemático:**
```php
// Línea 48
$beneficiario->convenios()->detach();  // Lógica de relaciones en controller
```

**Problema:** La gestión de relaciones debería estar en un Service.

---

## 🎯 PROPUESTA DE REESTRUCTURACIÓN

### Arquitectura propuesta: **Service Layer + Repository Pattern**

```
app/
├── Http/
│   ├── Controllers/          # Solo orquestación
│   └── Requests/             # Validación (Form Requests)
├── Services/                 # Lógica de negocio
├── Repositories/             # Acceso a datos
└── Models/                   # Solo representación + relaciones + scopes
```

---

## 📁 REESTRUCTURACIÓN DETALLADA

### 1. **ConvenioController** → Controller limpio

**Archivo nuevo:** `app/Http/Requests/StoreConvenioRequest.php`
**Archivo nuevo:** `app/Http/Requests/UpdateConvenioRequest.php`
**Archivo nuevo:** `app/Services/ConvenioService.php`
**Archivo nuevo:** `app/Repositories/ConvenioRepository.php`

**Cómo debe quedar el Controller:**
```php
class ConvenioController extends Controller
{
    public function __construct(
        private ConvenioService $convenioService,
        private ConvenioRepository $convenioRepository
    ) {}

    public function index()
    {
        $convenios = $this->convenioRepository->getAllWithRelations();
        return view('admin.gestion-convenios', compact('convenios'));
    }

    public function create()
    {
        $data = $this->convenioService->getCreateFormData();
        return view('admin.convenios.create', $data);
    }

    public function store(StoreConvenioRequest $request)
    {
        $convenio = $this->convenioService->create($request->validated());
        
        return redirect()
            ->route('admin.convenios')
            ->with('success', 'Convenio creado exitosamente.');
    }

    public function show(Convenio $convenio)
    {
        $convenio = $this->convenioRepository->findWithAllRelations($convenio->id);
        return view('admin.convenios.show', compact('convenio'));
    }

    public function edit(Convenio $convenio)
    {
        $data = $this->convenioService->getEditFormData($convenio);
        return view('admin.convenios.edit', $data);
    }

    public function update(UpdateConvenioRequest $request, Convenio $convenio)
    {
        $this->convenioService->update($convenio, $request->validated());
        
        return redirect()
            ->route('admin.convenios')
            ->with('success', 'Convenio actualizado exitosamente.');
    }

    public function destroy(Convenio $convenio)
    {
        $this->convenioService->delete($convenio);
        
        return redirect()
            ->route('admin.convenios')
            ->with('success', 'Convenio eliminado exitosamente.');
    }
}
```

**Archivo nuevo: `app/Services/ConvenioService.php`**
```php
class ConvenioService
{
    public function __construct(
        private ConvenioRepository $repository
    ) {}

    public function create(array $data): Convenio
    {
        return DB::transaction(function () use ($data) {
            $beneficiarios = $data['beneficiarios'] ?? null;
            unset($data['beneficiarios']);
            
            return $this->repository->createWithBeneficiarios($data, $beneficiarios);
        });
    }

    public function update(Convenio $convenio, array $data): Convenio
    {
        return DB::transaction(function () use ($convenio, $data) {
            $beneficiarios = $data['beneficiarios'] ?? null;
            unset($data['beneficiarios']);
            
            return $this->repository->updateWithBeneficiarios($convenio, $data, $beneficiarios);
        });
    }

    public function delete(Convenio $convenio): void
    {
        $this->repository->deleteWithRelations($convenio);
    }

    public function getCreateFormData(): array
    {
        return [
            'tiposConvenio' => TipoConvenio::all(),
            'ambitos' => Ambito::all(),
            'estadosConvenio' => EstadoConvenio::all(),
            'beneficiarios' => Beneficiario::all(),
        ];
    }

    public function getEditFormData(Convenio $convenio): array
    {
        return [
            'convenio' => $convenio->load('beneficiario'),
            'tiposConvenio' => TipoConvenio::all(),
            'ambitos' => Ambito::all(),
            'estadosConvenio' => EstadoConvenio::all(),
            'beneficiarios' => Beneficiario::all(),
        ];
    }
}
```

**Archivo nuevo: `app/Repositories/ConvenioRepository.php`**
```php
class ConvenioRepository
{
    public function getAllWithRelations()
    {
        return Convenio::with(['tipoConvenio', 'ambito', 'estadoConvenio'])
            ->latest()
            ->paginate(15);
    }

    public function findWithAllRelations(int $id): Convenio
    {
        return Convenio::with([
            'tipoConvenio',
            'ambito',
            'estadoConvenio',
            'beneficiario',
            'documento',
            'convenioAnterior'
        ])->findOrFail($id);
    }

    public function createWithBeneficiarios(array $data, ?array $beneficiarios = null): Convenio
    {
        $convenio = Convenio::create($data);
        
        if ($beneficiarios) {
            $convenio->beneficiario()->sync($beneficiarios);
        }
        
        return $convenio;
    }

    public function updateWithBeneficiarios(
        Convenio $convenio, 
        array $data, 
        ?array $beneficiarios = null
    ): Convenio {
        $convenio->update($data);
        
        if ($beneficiarios !== null) {
            $convenio->beneficiario()->sync($beneficiarios);
        } else {
            $convenio->beneficiario()->detach();
        }
        
        return $convenio->fresh();
    }

    public function deleteWithRelations(Convenio $convenio): bool
    {
        $convenio->beneficiario()->detach();
        return $convenio->delete();
    }
}
```

**Archivo nuevo: `app/Http/Requests/StoreConvenioRequest.php`**
```php
class StoreConvenioRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'tipo_convenio_id' => 'required|exists:tipos_convenio,id',
            'ambito_id' => 'required|exists:ambitos,id',
            'estado_convenio_id' => 'required|exists:estados_convenio,id',
            'resolucion' => 'nullable|string|max:255',
            'titulo' => 'required|string|max:500',
            'objetivo_personalizado' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'plazo_prorroga_valor' => 'nullable|integer',
            'plazo_prorroga_unidad' => 'nullable|string|max:50',
            'entidad_nombre' => 'required|string|max:255',
            'entidad_logo' => 'nullable|string|max:500',
            'entidad_tipo' => 'nullable|string|max:100',
            'nacionalidad' => 'nullable|string|max:100',
            'beneficiarios' => 'nullable|array',
            'beneficiarios.*' => 'exists:beneficiarios,id',
        ];
    }
}
```

---

### 2. **AdminController** → Service para Dashboard

**Archivo nuevo:** `app/Services/DashboardService.php`

**Cómo debe quedar:**
```php
class AdminController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService,
        private ConvenioRepository $convenioRepository
    ) {}

    public function dashboard()
    {
        $stats = $this->dashboardService->getStats();
        return view('admin.dashboard', compact('stats'));
    }

    public function convenios()
    {
        $convenios = $this->convenioRepository->getAllWithRelations();
        return view('admin.gestion-convenios', compact('convenios'));
    }

    public function cms()
    {
        $secciones = app(CmsSeccionRepository::class)->getAll();
        return view('admin.contenido-contenido', compact('secciones'));
    }

    public function profile()
    {
        return view('admin.profile');
    }
}
```

**Archivo nuevo: `app/Services/DashboardService.php`**
```php
class DashboardService
{
    public function __construct(
        private ConvenioRepository $convenioRepository,
        private TipoConvenioRepository $tipoConvenioRepository,
        private AmbitoRepository $ambitoRepository
    ) {}

    public function getStats(): array
    {
        return [
            'total_convenios' => Convenio::count(),
            'convenios_activos' => Convenio::activos()->count(),
            'tipos_convenio' => $this->tipoConvenioRepository->count(),
            'ambitos' => $this->ambitoRepository->count(),
            'recientes' => $this->convenioRepository->getRecent(5),
        ];
    }
}
```

---

### 3. **DocumentoConvenioController** → FileService

**Archivo nuevo:** `app/Services/FileService.php`
**Archivo nuevo:** `app/Services/DocumentoConvenioService.php`

**Cómo debe quedar el Controller:**
```php
class DocumentoConvenioController extends Controller
{
    public function __construct(
        private DocumentoConvenioService $documentoService
    ) {}

    public function store(StoreDocumentoConvenioRequest $request, Convenio $convenio)
    {
        $documento = $this->documentoService->create($convenio, $request->validated());
        return response()->json($documento, 201);
    }

    public function destroy(DocumentoConvenio $documentoConvenio)
    {
        $this->documentoService->delete($documentoConvenio);
        return response()->json(['message' => 'Documento eliminado exitosamente.'], 200);
    }

    public function download(DocumentoConvenio $documentoConvenio)
    {
        return $this->documentoService->download($documentoConvenio);
    }
}
```

**Archivo nuevo: `app/Services/FileService.php`**
```php
class FileService
{
    public function store(UploadedFile $file, string $directory = 'documentos'): string
    {
        return $file->store($directory, 'public');
    }

    public function delete(string $path): bool
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
        return false;
    }

    public function exists(string $path): bool
    {
        return Storage::disk('public')->exists($path);
    }

    public function download(string $path, string $filename): Response
    {
        if (!$this->exists($path)) {
            abort(404, 'Archivo no encontrado.');
        }
        
        return response()->download(
            Storage::disk('public')->path($path),
            $filename
        );
    }
}
```

**Archivo nuevo: `app/Services/DocumentoConvenioService.php`**
```php
class DocumentoConvenioService
{
    public function __construct(
        private FileService $fileService
    ) {}

    public function create(Convenio $convenio, array $data): DocumentoConvenio
    {
        if (isset($data['documento'])) {
            $data['ruta_documento'] = $this->fileService->store(
                $data['documento'],
                'documentos/convenios'
            );
            unset($data['documento']);
        }

        return DocumentoConvenio::create([
            'convenio_id' => $convenio->id,
            ...$data,
            'version' => $data['version'] ?? 1,
            'activo' => $data['activo'] ?? true,
        ]);
    }

    public function update(DocumentoConvenio $documento, array $data): DocumentoConvenio
    {
        if (isset($data['documento'])) {
            if ($documento->ruta_documento) {
                $this->fileService->delete($documento->ruta_documento);
            }
            $data['ruta_documento'] = $this->fileService->store(
                $data['documento'],
                'documentos/convenios'
            );
            unset($data['documento']);
        }

        $documento->update($data);
        return $documento;
    }

    public function delete(DocumentoConvenio $documento): void
    {
        if ($documento->ruta_documento) {
            $this->fileService->delete($documento->ruta_documento);
        }
        $documento->delete();
    }

    public function download(DocumentoConvenio $documento): Response
    {
        return $this->fileService->download(
            $documento->ruta_documento,
            $documento->nombre_documento
        );
    }
}
```

---

### 4. **ObservacionController** → VersionService

**Archivo nuevo:** `app/Services/ObservacionService.php`

**Cómo debe quedar:**
```php
class ObservacionController extends Controller
{
    public function __construct(
        private ObservacionService $observacionService
    ) {}

    public function store(StoreObservacionRequest $request, Convenio $convenio)
    {
        $observacion = $this->observacionService->create($convenio, $request->validated());
        return response()->json($observacion, 201);
    }

    // ... otros métodos
}
```

**Archivo nuevo: `app/Services/ObservacionService.php`**
```php
class ObservacionService
{
    public function create(Convenio $convenio, array $data): Observacion
    {
        $version = $data['version'] ?? $this->getNextVersion($convenio);

        return Observacion::create([
            'convenio_id' => $convenio->id,
            'descripcion' => $data['descripcion'],
            'version' => $version,
            'fecha_creacion' => now(),
            'fecha_actualizacion' => now(),
        ]);
    }

    private function getNextVersion(Convenio $convenio): int
    {
        $ultimaVersion = $convenio->observaciones()->max('version') ?? 0;
        return $ultimaVersion + 1;
    }
}
```

---

### 5. **Controllers CRUD** → Form Requests

**Archivo nuevo:** `app/Http/Requests/StoreAmbitoRequest.php`
**Archivo nuevo:** `app/Http/Requests/UpdateAmbitoRequest.php`
(Similar para Beneficiario, TipoConvenio, EstadoConvenio, CmsSeccion)

**Cómo debe quedar AmbitoController:**
```php
class AmbitoController extends Controller
{
    public function store(StoreAmbitoRequest $request)
    {
        $ambito = Ambito::create($request->validated());
        return response()->json($ambito, 201);
    }

    public function update(UpdateAmbitoRequest $request, Ambito $ambito)
    {
        $ambito->update($request->validated());
        return response()->json($ambito);
    }

    public function destroy(Ambito $ambito)
    {
        if (!$ambito->canBeDeleted()) {
            return response()->json([
                'error' => 'No se puede eliminar un ámbito que tiene convenios asociados.'
            ], 422);
        }

        $ambito->delete();
        return response()->json(['message' => 'Ámbito eliminado exitosamente.'], 200);
    }
}
```

---

### 6. **Model Convenio** → Solo representación

**Cómo debe quedar:**
```php
class Convenio extends Model
{
    // ... fillable, casts, hidden (igual)

    // ✅ Relaciones (mantener)
    public function tipoConvenio(): BelongsTo { /* ... */ }
    public function ambito(): BelongsTo { /* ... */ }
    // ... todas las relaciones

    // ✅ Scopes (mantener)
    public function scopeActivos($query) { /* ... */ }
    public function scopeRecientes($query, int $limit = 5) { /* ... */ }

    // ❌ ELIMINAR:
    // - getAllWithRelations() → Mover a ConvenioRepository
    // - loadAllRelations() → Mover a ConvenioRepository
    // - createWithBeneficiarios() → Mover a ConvenioRepository
    // - updateWithBeneficiarios() → Mover a ConvenioRepository
    // - deleteWithRelations() → Mover a ConvenioRepository
    // - getDashboardStats() → Mover a DashboardService
}
```

---

### 7. **Models simples** → Limpiar métodos innecesarios

**Cómo debe quedar Ambito:**
```php
class Ambito extends Model
{
    // ... fillable, hidden (igual)

    // ✅ Relaciones (mantener)
    public function convenios(): HasMany { /* ... */ }

    // ✅ Lógica del dominio (mantener)
    public function canBeDeleted(): bool { /* ... */ }

    // ❌ ELIMINAR:
    // - getAll() → Usar Ambito::all() directamente o crear scope si es necesario
}
```

**Para CmsSeccion:**
```php
class CmsSeccion extends Model
{
    // ✅ Agregar scope en lugar de método estático
    public function scopeBySlug($query, string $slug)
    {
        return $query->where('slug', $slug);
    }

    // ❌ ELIMINAR:
    // - getAll() → Usar CmsSeccion::latest()->get()
    // - findBySlug() → Usar CmsSeccion::bySlug($slug)->first() o mover a Repository
}
```

---

### 8. **BeneficiarioController** → Service

**Archivo nuevo:** `app/Services/BeneficiarioService.php`

**Cómo debe quedar:**
```php
class BeneficiarioController extends Controller
{
    public function __construct(
        private BeneficiarioService $beneficiarioService
    ) {}

    public function destroy(Beneficiario $beneficiario)
    {
        $this->beneficiarioService->delete($beneficiario);
        return response()->json(['message' => 'Beneficiario eliminado exitosamente.'], 200);
    }
}
```

**Archivo nuevo: `app/Services/BeneficiarioService.php`**
```php
class BeneficiarioService
{
    public function delete(Beneficiario $beneficiario): void
    {
        $beneficiario->convenios()->detach();
        $beneficiario->delete();
    }
}
```

---

## 📊 ESTRUCTURA FINAL PROPUESTA

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AdminController.php          # ✅ Limpio, solo orquestación
│   │   ├── ConvenioController.php       # ✅ Limpio, solo orquestación
│   │   ├── AmbitoController.php         # ✅ Limpio, solo orquestación
│   │   ├── BeneficiarioController.php   # ✅ Limpio, solo orquestación
│   │   ├── TipoConvenioController.php   # ✅ Limpio, solo orquestación
│   │   ├── EstadoConvenioController.php # ✅ Limpio, solo orquestación
│   │   ├── CmsSeccionController.php     # ✅ Limpio, solo orquestación
│   │   ├── DocumentoConvenioController.php # ✅ Limpio, solo orquestación
│   │   └── ObservacionController.php    # ✅ Limpio, solo orquestación
│   └── Requests/
│       ├── StoreConvenioRequest.php
│       ├── UpdateConvenioRequest.php
│       ├── StoreAmbitoRequest.php
│       ├── UpdateAmbitoRequest.php
│       └── ... (Form Requests para todos los recursos)
├── Services/
│   ├── ConvenioService.php              # ✅ Lógica de negocio de Convenios
│   ├── DashboardService.php             # ✅ Lógica de estadísticas
│   ├── DocumentoConvenioService.php     # ✅ Lógica de documentos
│   ├── ObservacionService.php           # ✅ Lógica de observaciones
│   ├── BeneficiarioService.php          # ✅ Lógica de beneficiarios
│   └── FileService.php                  # ✅ Gestión de archivos (reutilizable)
├── Repositories/
│   ├── ConvenioRepository.php           # ✅ Queries y acceso a datos
│   ├── CmsSeccionRepository.php         # ✅ Queries de CMS
│   ├── TipoConvenioRepository.php       # ✅ Queries de tipos
│   └── AmbitoRepository.php             # ✅ Queries de ámbitos
└── Models/
    ├── Convenio.php                     # ✅ Solo representación + relaciones + scopes
    ├── Ambito.php                       # ✅ Solo representación + relaciones + canBeDeleted()
    ├── Beneficiario.php                 # ✅ Solo representación + relaciones
    ├── TipoConvenio.php                 # ✅ Solo representación + relaciones + canBeDeleted()
    ├── EstadoConvenio.php               # ✅ Solo representación + relaciones + canBeDeleted()
    ├── CmsSeccion.php                   # ✅ Solo representación + scopes
    ├── DocumentoConvenio.php            # ✅ Solo representación + relaciones
    └── Observacion.php                  # ✅ Solo representación + relaciones
```

---

## ✅ BENEFICIOS DE LA REESTRUCTURACIÓN

1. **Separación de responsabilidades**: Cada clase tiene una sola razón para cambiar
2. **Testabilidad**: Services y Repositories son fácilmente testeables
3. **Reusabilidad**: Lógica de negocio reutilizable entre diferentes controllers
4. **Mantenibilidad**: Cambios localizados en clases específicas
5. **Cumplimiento SOLID**: 
   - ✅ **SRP**: Cada clase una responsabilidad
   - ✅ **OCP**: Extensible sin modificar código existente
   - ✅ **LSP**: Polimorfismo a través de interfaces (opcional)
   - ✅ **ISP**: Interfaces específicas (opcional)
   - ✅ **DIP**: Dependencia de abstracciones (Services/Repositories)
6. **Cumplimiento MVC**: 
   - ✅ Controllers solo orquestan
   - ✅ Models solo representan
   - ✅ Lógica de negocio en Services
   - ✅ Acceso a datos en Repositories

---

## 🚀 PASOS DE IMPLEMENTACIÓN RECOMENDADOS

1. **Fase 1**: Crear Repositories (sin cambiar controllers)
2. **Fase 2**: Crear Form Requests y actualizar controllers
3. **Fase 3**: Crear Services y migrar lógica de negocio
4. **Fase 4**: Limpiar Models (eliminar métodos de negocio)
5. **Fase 5**: Refactorizar controllers para usar Services/Repositories
6. **Fase 6**: Testing completo

---

## 📝 NOTAS ADICIONALES

- Considerar usar **Interfaces** para Repositories si se planea cambiar de ORM
- Los **Services** pueden inyectar múltiples Repositories
- La **validación** puede ser más compleja en Form Requests (custom messages, after hooks)
- Considerar **Actions** (single-use services) para operaciones muy específicas
- Los **Repositories** pueden implementar interfaces para mejor testabilidad

