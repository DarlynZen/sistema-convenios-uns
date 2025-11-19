<?php

namespace App\Http\Controllers;

use App\Models\Beneficiario;
use Illuminate\Http\Request;

class BeneficiarioController extends Controller
{
    public function index()
    {
        $beneficiarios = Beneficiario::latest()->paginate(15);
        return response()->json($beneficiarios);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo_beneficiario' => 'nullable|string|max:100|unique:beneficiarios,codigo_beneficiario',
            'descripcion' => 'nullable|string',
        ]);

        $beneficiario = Beneficiario::create($validated);
        return response()->json($beneficiario, 201);
    }

    public function show(Beneficiario $beneficiario)
    {
        $beneficiario->load('convenios');
        return response()->json($beneficiario);
    }

    public function update(Request $request, Beneficiario $beneficiario)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo_beneficiario' => 'nullable|string|max:100|unique:beneficiarios,codigo_beneficiario,' . $beneficiario->id,
            'descripcion' => 'nullable|string',
        ]);

        $beneficiario->update($validated);
        return response()->json($beneficiario);
    }

    public function destroy(Beneficiario $beneficiario)
    {
        $beneficiario->convenios()->detach();
        $beneficiario->delete();
        return response()->json(['message' => 'Beneficiario eliminado exitosamente.'], 200);
    }
}
