<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConvenioRequest;
use App\Models\Convenio;
use App\Services\ConvenioService;
use App\Services\DocumentoConvenioService;

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
        $resolucion = $convenio->resolucion ?? 'Sin resolución';
        preg_match('/\b(19|20)\d{2}\b/', (string) $resolucion, $matches);

        $entidadLogo = $convenio->entidad_logo ?? null;

        return view('admin.convenios.verConvenio', [
            'convenio' => $convenio,
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
        ]);
    }

    public function edit(Convenio $convenio)
    {
        return view('admin.convenios.edit', array_merge(
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
