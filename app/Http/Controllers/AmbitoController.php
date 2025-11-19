<?php

namespace App\Http\Controllers;

use App\Models\Ambito;
use Illuminate\Http\Request;

class AmbitoController extends Controller
{
    public function index()
    {
        $ambitos = Ambito::latest()->paginate(15);
        return response()->json($ambitos);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:ambitos,nombre',
            'descripcion' => 'nullable|string',
        ]);

        $ambito = Ambito::create($validated);
        return response()->json($ambito, 201);
    }

    public function show(Ambito $ambito)
    {
        return response()->json($ambito);
    }

    public function update(Request $request, Ambito $ambito)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:ambitos,nombre,' . $ambito->id,
            'descripcion' => 'nullable|string',
        ]);

        $ambito->update($validated);
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
