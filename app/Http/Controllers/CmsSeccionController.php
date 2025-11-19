<?php

namespace App\Http\Controllers;

use App\Models\CmsSeccion;
use Illuminate\Http\Request;

class CmsSeccionController extends Controller
{
    public function index()
    {
        $secciones = CmsSeccion::latest()->paginate(15);
        return response()->json($secciones);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|max:255|unique:cms_seccion,slug',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'contenido_json' => 'nullable|array',
        ]);

        $seccion = CmsSeccion::create($validated);
        return response()->json($seccion, 201);
    }

    public function show(CmsSeccion $cmsSeccion)
    {
        return response()->json($cmsSeccion);
    }

    public function showBySlug(string $slug)
    {
        $seccion = CmsSeccion::findBySlug($slug);
        
        if (!$seccion) {
            return response()->json(['error' => 'Sección no encontrada.'], 404);
        }
        
        return response()->json($seccion);
    }

    public function update(Request $request, CmsSeccion $cmsSeccion)
    {
        $validated = $request->validate([
            'slug' => 'required|string|max:255|unique:cms_seccion,slug,' . $cmsSeccion->id,
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'contenido_json' => 'nullable|array',
        ]);

        $cmsSeccion->update($validated);
        return response()->json($cmsSeccion);
    }

    public function destroy(CmsSeccion $cmsSeccion)
    {
        $cmsSeccion->delete();
        return response()->json(['message' => 'Sección eliminada exitosamente.'], 200);
    }
}
