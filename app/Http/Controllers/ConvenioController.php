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
        return view('admin.convenios.index', $this->convenioService->obtenerDatosIndex());
    }

    public function create()
    {
        $data = $this->convenioService->obtenerCatalogos();
        return view('admin.convenios.create', $data);
    }

    public function store(ConvenioRequest $request)
    {
        try {
            $data = $request->validated();

            $beneficiarios = $data['beneficiarios'] ?? null;
            unset($data['beneficiarios']);

            $convenio = $this->convenioService->crear($data, $beneficiarios);

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
                ->with('success', 'Convenio creado exitosamente.');
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al crear el convenio: ' . $e->getMessage());
        }
    }

    public function show(Convenio $convenio)
    {
        return view('admin.convenios.show', $this->convenioService->getShowViewData($convenio->id));
    }

    public function edit(Convenio $convenio)
    {
        $data = $this->convenioService->getEditFormData($convenio);
        return view('admin.convenios.edit', $data);
    }

    public function update(ConvenioRequest $request, Convenio $convenio)
    {
        try {
            $beneficiarios = $request->exists('beneficiarios')
                ? $request->input('beneficiarios', [])
                : null;

            $this->convenioService->actualizar($convenio->id, $request->validated(), $beneficiarios);

            return redirect()->route('admin.convenios')
                ->with('success', 'Convenio actualizado exitosamente.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error al actualizar el convenio: ' . $e->getMessage());
        }
    }

    public function destroy(Convenio $convenio)
    {
        try {
            $this->convenioService->eliminar($convenio->id);
            return redirect()->route('admin.convenios')
                ->with('success', 'Convenio eliminado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el convenio: ' . $e->getMessage());
        }
    }
}