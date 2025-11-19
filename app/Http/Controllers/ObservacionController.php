<?php

namespace App\Http\Controllers;

use App\Models\Observacion;
use App\Models\Convenio;
use Illuminate\Http\Request;

class ObservacionController extends Controller
{
    public function index(Convenio $convenio)
    {
        $observaciones = $convenio->observaciones()->latest()->get();
        return response()->json($observaciones);
    }

    public function store(Request $request, Convenio $convenio)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string',
            'version' => 'nullable|integer|min:1',
        ]);

        $ultimaVersion = $convenio->observaciones()->max('version') ?? 0;

        $observacion = Observacion::create([
            'convenio_id' => $convenio->id,
            'descripcion' => $validated['descripcion'],
            'fecha_creacion' => now(),
            'fecha_actualizacion' => now(),
            'version' => $validated['version'] ?? ($ultimaVersion + 1),
        ]);

        return response()->json($observacion, 201);
    }

    public function show(Observacion $observacion)
    {
        $observacion->load('convenio');
        return response()->json($observacion);
    }

    public function update(Request $request, Observacion $observacion)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string',
            'version' => 'nullable|integer|min:1',
        ]);

        $observacion->update([
            'descripcion' => $validated['descripcion'],
            'fecha_actualizacion' => now(),
            'version' => $validated['version'] ?? $observacion->version,
        ]);

        return response()->json($observacion);
    }

    public function destroy(Observacion $observacion)
    {
        $observacion->delete();
        return response()->json(['message' => 'Observación eliminada exitosamente.'], 200);
    }
}
