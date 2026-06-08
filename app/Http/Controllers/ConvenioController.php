<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConvenioRequest;
use App\Models\Convenio;
use App\Services\ConvenioService;
use App\Services\DocumentoConvenioService;
use Illuminate\Support\Facades\Storage;

class ConvenioController extends Controller
{
    public function __construct(
        private ConvenioService $convenioService,
        private DocumentoConvenioService $documentoConvenioService,
    ) {}

    public function index()
    {
        return view('admin.convenios.index', array_merge(
            ['convenios' => $this->convenioService->listarConRelaciones()],
            $this->convenioService->obtenerCatalogos()
        ));
    }

    public function create()
    {
        $data = $this->convenioService->obtenerCatalogos();
        return view('admin.convenios.crearConvenio', $data);
    }

    public function store(ConvenioRequest $request)
    {
        try {
            $convenio = $this->convenioService->crear($request->validated());

            if ($request->hasFile('transcripcion_resolucion')) {
                $this->documentoConvenioService->create($convenio, [
                    'documento'        => $request->file('transcripcion_resolucion'),
                    'nombre_documento' => 'Transcripción de Resolución',
                ]);
            }

            if ($request->hasFile('anexo_convenio')) {
                $this->documentoConvenioService->create($convenio, [
                    'documento'        => $request->file('anexo_convenio'),
                    'nombre_documento' => 'Anexo de Convenio',
                ]);
            }

            return redirect()
                ->route('admin.convenios.index')
                ->with('toast', [
                    'type' => 'success',
                    'title' => 'Convenio creado',
                    'message' => 'El convenio se creó exitosamente.',
                ]);
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('toast', [
                    'type' => 'error',
                    'title' => 'No se pudo crear',
                    'message' => 'Error al crear el convenio: ' . $e->getMessage(),
                ]);
        }
    }

    public function show(Convenio $convenio)
    {
        $convenio = $this->convenioService->obtenerConRelaciones($convenio->id);
        $convenioAnterior = $convenio->convenioAnterior;
        $renovacionTexto = $convenioAnterior
            ? ($convenioAnterior->resolucion ?: ($convenioAnterior->titulo ?: ('Convenio #' . $convenioAnterior->id)))
            : 'No es una renovación';
        $resolucion = $convenio->resolucion ?? 'Sin resolución';
        preg_match('/\b(19|20)\d{2}\b/', (string) $resolucion, $matches);

        $informacionRows = [
            ['label' => 'N° Resolución', 'value' => $resolucion],
            ['label' => 'Año de Resolución', 'value' => $matches[0] ?? '-'],
            ['label' => 'Título', 'value' => $convenio->titulo ?? 'Convenio sin título'],
            ['label' => 'Tipo de convenio', 'value' => data_get($convenio, 'tipoConvenio.nombre', 'Sin tipo')],
            ['label' => 'Estado', 'value' => data_get($convenio, 'estadoConvenio.nombre', 'Sin estado')],
            ['label' => 'Ámbito', 'value' => data_get($convenio, 'ambito.nombre', 'Sin ámbito')],
            ['label' => 'Dirigido a', 'value' => ($beneficiarios = collect($convenio->beneficiarios ?? []))
                ->pluck('codigo_beneficiario')
                ->filter()
                ->join(', ') ?: '-'],
        ];

        $vigenciaRows = [
            ['label' => 'Fecha de inicio', 'value' => optional($convenio->fecha_inicio)->format('d/m/Y') ?? '-'],
            ['label' => 'Duración', 'value' => $convenio->duracion ?? '-'],
            ['label' => 'Fecha de fin', 'value' => optional($convenio->fecha_fin)->format('d/m/Y') ?? '-'],
            ['label' => 'Plazo de prórroga', 'value' => trim(($convenio->plazo_prorroga_valor ?? '-') . ' ' . ($convenio->plazo_prorroga_unidad ?? ''))],
            ['label' => 'Observaciones', 'value' => $convenio->observaciones_prorroga ?? data_get($convenio, 'observaciones_prorroga', '-')],
        ];

        $entidadLogo = $convenio->entidad_logo ?? null;
        $entidadRows = [
            [
                'institución/entidad/organismo' => $convenio->entidad_nombre ?? '-',
                'tipo de entidad' => $convenio->entidad_tipo ?? '-',
                'nacionalidad' => $convenio->nacionalidad ?? '-',
                'logo' => filled($entidadLogo)
                    ? (preg_match('/^https?:\/\//', $entidadLogo) ? $entidadLogo : asset('storage/' . ltrim($entidadLogo, '/')))
                    : null,
            ],
        ];
        $entidadColumns = [
            ['key' => 'institución/entidad/organismo', 'label' => 'Institución/Entidad/Organismo', 'classes' => 'w-[42%]'],
            ['key' => 'tipo de entidad', 'label' => 'Tipo de entidad', 'classes' => 'w-[18%]'],
            ['key' => 'nacionalidad', 'label' => 'Nacionalidad', 'classes' => 'w-[15%]'],
            ['key' => 'logo', 'label' => 'Logo', 'type' => 'image', 'classes' => 'w-[15%]', 'cellClasses' => 'align-middle'],
        ];

        $renovacionRows = [
            ['label' => 'Convenio renovado de', 'value' => $renovacionTexto],
        ];

        $coordinadoresJson = data_get($convenio, 'detalles_coordinadores_json', []);
        $coordinadoresUns = collect(data_get($coordinadoresJson, 'coordinador_uns', []))->filter()->values();
        $coordinadoresInst = collect(data_get($coordinadoresJson, 'coordinador_institucion', []))->filter()->values();
        $mostrarCoordinadores = filled(data_get($convenio, 'detalles_coordinadores_json.coordinador_uns'))
            || filled(data_get($convenio, 'detalles_coordinadores_json.coordinador_institucion'))
            || data_get($convenio, 'detalles_coordinadores_json.no_se_menciona');
        $entidadEtiqueta = data_get($convenio, 'entidad_nombre', 'Institucion');
        /** @var \Illuminate\Filesystem\FilesystemAdapter $storage */
        $storage = Storage::disk('public');
        $formatSize = function (?int $bytes): string {
            if (!is_int($bytes) || $bytes <= 0) {
                return '-';
            }
            $units = ['B', 'KB', 'MB', 'GB'];
            $index = (int) floor(log($bytes, 1024));
            $index = min($index, count($units) - 1);
            $value = $bytes / (1024 ** $index);
            return number_format($value, $index === 0 ? 0 : 1) . ' ' . $units[$index];
        };
        $documentosAdjuntos = collect($convenio->documento)
            ->filter(fn($documento) => (bool) ($documento->activo ?? false))
            ->map(function ($documento) use ($storage, $formatSize) {
                $ruta = $documento->ruta_archivo ?? $documento->ruta_documento;
                $hasFile = filled($ruta) && $storage->exists($ruta);
                $fechaLabel = optional($documento->created_at)
                    ->locale('es')
                    ->translatedFormat('d \\d\\e F \\d\\e Y');

                return [
                    'nombre' => $documento->nombre_archivo
                        ?? $documento->nombre_documento
                        ?? $documento->tipo_documento
                        ?? 'Documento',
                    'sizeLabel' => $hasFile ? $formatSize($storage->size($ruta)) : '-',
                    'fechaLabel' => $fechaLabel ?: '-',
                    'downloadUrl' => $hasFile ? $storage->url($ruta) : '#',
                    'hasFile' => $hasFile,
                ];
            })
            ->values();

        return view('admin.convenios.verConvenio', [
            'convenio' => $convenio,
            'renovacionTexto' => $renovacionTexto,
            'informacionRows' => $informacionRows,
            'vigenciaRows' => $vigenciaRows,
            'entidadRows' => $entidadRows,
            'entidadColumns' => $entidadColumns,
            'renovacionRows' => $renovacionRows,
            'coordinadoresUns' => $coordinadoresUns,
            'coordinadoresInst' => $coordinadoresInst,
            'mostrarCoordinadores' => $mostrarCoordinadores,
            'entidadEtiqueta' => $entidadEtiqueta,
            'tipoNombre' => data_get($convenio, 'tipoConvenio.nombre', 'Sin tipo'),
            'ambitoNombre' => data_get($convenio, 'ambito.nombre', 'Sin ámbito'),
            'estadoNombre' => data_get($convenio, 'estadoConvenio.nombre', 'Sin estado'),
            'resolucion' => $resolucion,
            'anioResolucion' => $matches[0] ?? '-',
            'titulo' => $convenio->titulo ?? 'Convenio sin título',
            'beneficiariosTexto' => ($beneficiarios = collect($convenio->beneficiarios ?? []))
                ->pluck('codigo_beneficiario')
                ->filter()
                ->join(', ') ?: '-',
            'observacionProrroga' => $convenio->observaciones_prorroga ?? data_get($convenio, 'observaciones_prorroga', '-'),
            'entidadLogoUrl' => filled($entidadLogo)
                ? (preg_match('/^https?:\/\//', $entidadLogo) ? $entidadLogo : asset('storage/' . ltrim($entidadLogo, '/')))
                : null,
            'documentosAdjuntos' => $documentosAdjuntos,
        ]);
    }

    public function edit(Convenio $convenio)
    {
        return view('admin.convenios.editarConvenio', array_merge(
            [
                'convenio' => $this->convenioService->obtenerConRelaciones($convenio->id),
            ],
            $this->convenioService->obtenerCatalogos()
        ));
    }

    public function update(ConvenioRequest $request, Convenio $convenio)
    {
        try {
            $this->convenioService->actualizar($convenio->id, $request->validated());

            return redirect()->route('admin.convenios.index')
                ->with('toast', [
                    'type' => 'success',
                    'title' => 'Convenio actualizado',
                    'message' => 'Los cambios del convenio se guardaron correctamente.',
                ]);
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('toast', [
                    'type' => 'error',
                    'title' => 'No se pudo actualizar',
                    'message' => 'Error al actualizar el convenio: ' . $e->getMessage(),
                ]);
        }
    }

    public function destroy(Convenio $convenio)
    {
        try {
            $this->convenioService->eliminar($convenio->id);
            return redirect()->route('admin.convenios.index')
                ->with('toast', [
                    'type' => 'success',
                    'title' => 'Convenio eliminado',
                    'message' => 'El convenio se eliminó exitosamente.',
                ]);
        } catch (\Exception $e) {
            return back()->with('toast', [
                'type' => 'error',
                'title' => 'No se pudo eliminar',
                'message' => 'Error al eliminar el convenio: ' . $e->getMessage(),
            ]);
        }
    }
}
