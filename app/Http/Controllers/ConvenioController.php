<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConvenioRequest;
use App\Http\Requests\UpdateConvenioRequest;
use App\Models\Convenio;
use App\Services\ConvenioService;
use App\Repositories\ConvenioRepository;
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

    /*public function create()
    {
        $data = $this->convenioService->obtenerListado();
        return view('admin.convenios.create', $data);
    }*/

    public function store(StoreConvenioRequest $request)
    {
        try {
            $data = $request->validated();

            $beneficiarios = $data['beneficiarios'] ?? null;
            unset($data['beneficiarios']);

            // Crear convenio principal
            $convenio = $this->convenioService->crear($data, $beneficiarios);

            // Crear documentos asociados si se enviaron archivos
            if ($request->hasFile('archivo_uno')) {
                $this->documentoConvenioService->create($convenio, [
                    'documento'        => $request->file('archivo_uno'),
                    'nombre_documento' => 'Resolución 1',
                ]);
            }

            if ($request->hasFile('archivo_dos')) {
                $this->documentoConvenioService->create($convenio, [
                    'documento'        => $request->file('archivo_dos'),
                    'nombre_documento' => 'Resolución 2',
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
        $convenio = $this->convenioService->listarConvenios();
        return view('admin.convenios.show', compact('convenio'));
    }

    public function edit(Convenio $convenio)
    {
        $data = $this->convenioService->getEditFormData($convenio);
        return view('admin.convenios.edit', $data);
    }

    public function update(UpdateConvenioRequest $request, Convenio $convenio)
    {
        try {
            $this->convenioService->update($convenio, $request->validated());

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
            $this->convenioService->delete($convenio);
            return redirect()->route('admin.convenios')
                ->with('success', 'Convenio eliminado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el convenio: ' . $e->getMessage());
        }
    }
}