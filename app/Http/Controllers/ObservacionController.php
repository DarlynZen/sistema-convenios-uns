<?php

namespace App\Http\Controllers;

use App\Models\Observacion;
use App\Models\Convenio;
use App\Services\ObservacionService;
use App\Repositories\ObservacionRepository;
use App\Http\Requests\StoreObservacionRequest;
use App\Http\Requests\UpdateObservacionRequest;

class ObservacionController extends Controller
{
    public function __construct(
        private ObservacionService $observacionService,
        private ObservacionRepository $observacionRepository
    ) {}

    public function index(Convenio $convenio)
    {
        $observaciones = $this->observacionRepository->getByConvenio($convenio);
        return response()->json($observaciones);
    }

    public function store(StoreObservacionRequest $request, Convenio $convenio)
    {
        $observacion = $this->observacionService->create($convenio, $request->validated());
        return response()->json($observacion, 201);
    }

    public function show(Observacion $observacion)
    {
        $observacion = $this->observacionRepository->findWithConvenio($observacion->id);
        return response()->json($observacion);
    }

    public function update(UpdateObservacionRequest $request, Observacion $observacion)
    {
        $observacion = $this->observacionService->update($observacion, $request->validated());
        return response()->json($observacion);
    }

    public function destroy(Observacion $observacion)
    {
        $this->observacionService->delete($observacion);
        return response()->json(['message' => 'Observación eliminada exitosamente.'], 200);
    }
}
