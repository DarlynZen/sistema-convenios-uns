<?php

namespace App\Http\Controllers;

use App\Models\Convenio;
use App\Services\ConvenioService;
use App\Repositories\ConvenioRepository;
use App\Http\Requests\StoreConvenioRequest;
use App\Http\Requests\UpdateConvenioRequest;

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
        try {
            $this->convenioService->create($request->validated());
            
            return redirect()->route('admin.convenios')
                ->with('success', 'Convenio creado exitosamente.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error al crear el convenio: ' . $e->getMessage());
        }
    }

    public function show(Convenio $convenio)
    {
        $convenio = $this->convenioRepository->loadAllRelations($convenio);
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
