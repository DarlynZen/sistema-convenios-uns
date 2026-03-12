<?php

namespace App\Http\Controllers;

use App\Repositories\CmsSeccionRepository;
use Illuminate\Http\Request;

class CmsSeccionController extends Controller
{
    public function __construct(private CmsSeccionRepository $repository) {
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|max:255|unique:cms_seccion,slug',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'contenido_json' => 'nullable|array',
        ]);

        $seccion = $this->repository->createArray($validated);
        return response()->json($seccion, 201);
    }

    public function show(int $id)
    {
        $seccion = $this->repository->findArrayById($id);

        if (!$seccion) {
            return response()->json(['error' => 'Sección no encontrada.'], 404);
        }

        return response()->json($seccion);
    }

    public function showBySlug(string $slug)
    {
        $seccion = $this->repository->findArrayBySlug($slug);
        
        if (!$seccion) {
            return response()->json(['error' => 'Sección no encontrada.'], 404);
        }
        
        return response()->json($seccion);
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'slug' => 'required|string|max:255|unique:cms_seccion,slug,' . $id,
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'contenido_json' => 'nullable|array',
        ]);

        $seccion = $this->repository->updateById($id, $validated);
        if (!$seccion) {
            return response()->json(['error' => 'Sección no encontrada.'], 404);
        }

        return response()->json($seccion);
    }
}
