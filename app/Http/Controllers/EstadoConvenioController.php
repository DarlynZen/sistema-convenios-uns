<?php

namespace App\Http\Controllers;

use App\Models\EstadoConvenio;
use Illuminate\Http\Request;

class EstadoConvenioController extends Controller
{
    public function index()
    {
        $estadosConvenio = EstadoConvenio::latest()->paginate(15);
        return response()->json($estadosConvenio);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:estados_convenio,nombre',
            'descripcion' => 'nullable|string',
        ]);

        $estadoConvenio = EstadoConvenio::create($validated);
        return response()->json($estadoConvenio, 201);
    }

    public function show(EstadoConvenio $estadoConvenio)
    {
        return response()->json($estadoConvenio);
    }

    public function update(Request $request, EstadoConvenio $estadoConvenio)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:estado_convenios,nombre,' . $estadoConvenio->id,
            'descripcion' => 'nullable|string',
        ]);

        $estadoConvenio->update($validated);
        return response()->json($estadoConvenio);
    }

    public function destroy(EstadoConvenio $estadoConvenio)
    {
        if (!$estadoConvenio->canBeDeleted()) {
            return response()->json([
                'error' => 'No se puede eliminar un estado que tiene convenios asociados.'
            ], 422);
        }

        $estadoConvenio->delete();
        return response()->json(['message' => 'Estado eliminado exitosamente.'], 200);
    }
}
