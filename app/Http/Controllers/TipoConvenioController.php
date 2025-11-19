<?php

namespace App\Http\Controllers;

use App\Models\TipoConvenio;
use Illuminate\Http\Request;

class TipoConvenioController extends Controller
{
    public function index()
    {
        $tiposConvenio = TipoConvenio::latest()->paginate(15);
        return response()->json($tiposConvenio);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:tipos_convenio,nombre',
            'descripcion' => 'nullable|string',
        ]);

        $tipoConvenio = TipoConvenio::create($validated);
        return response()->json($tipoConvenio, 201);
    }

    public function show(TipoConvenio $tipoConvenio)
    {
        return response()->json($tipoConvenio);
    }

    public function update(Request $request, TipoConvenio $tipoConvenio)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:tipos_convenio,nombre,' . $tipoConvenio->id,
            'descripcion' => 'nullable|string',
        ]);

        $tipoConvenio->update($validated);
        return response()->json($tipoConvenio);
    }

    public function destroy(TipoConvenio $tipoConvenio)
    {
        if (!$tipoConvenio->canBeDeleted()) {
            return response()->json([
                'error' => 'No se puede eliminar un tipo de convenio que tiene convenios asociados.'
            ], 422);
        }

        $tipoConvenio->delete();
        return response()->json(['message' => 'Tipo de convenio eliminado exitosamente.'], 200);
    }
}
