<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use App\Services\ConvenioService;
use App\Services\CmsSeccionService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService,
        private CmsSeccionService $cmsSeccionService
    ) {}

    public function dashboard()
    {
        $stats = $this->dashboardService->getStats();
        return view('admin.dashboard', $stats);
    }

    public function contenido()
    {
        $heroViewData = $this->cmsSeccionService->getHeroAdminViewData();
        $contactoViewData = $this->cmsSeccionService->getContactoAdminViewData();
        return view('admin.contenido.index', array_merge($heroViewData, $contactoViewData));
    }

    public function guardarHero(Request $request)
    {
        $validated = $request->validate([
            'hero_titulo' => 'required|string|max:255',
            'hero_subtitulo' => 'nullable|string|max:255',
            'hero_imagen' => 'nullable|image|max:4096',
        ]);

        $this->cmsSeccionService->upsertHero(
            titulo: $validated['hero_titulo'],
            subtitulo: $validated['hero_subtitulo'] ?? null,
            imagen: $request->file('hero_imagen')
        );

        return redirect()
            ->route('admin.contenido.index', ['tab' => 'infogeneral'])
            ->with('status', 'Sección Hero actualizada.');
    }

    public function guardarContacto(Request $request)
    {
        $validated = $request->validate([
            'contacto_nombre_direccion' => 'nullable|string|max:120',
            'contacto_ubicacion' => 'nullable|string|max:255',
            'contacto_telefono' => 'nullable|string|max:80',
            'contacto_correo' => 'nullable|email|max:120',
        ]);

        $this->cmsSeccionService->upsertContacto(
            nombreDireccion: ($validated['contacto_nombre_direccion'] ?? null) ?: null,
            ubicacion: ($validated['contacto_ubicacion'] ?? null) ?: null,
            telefono: ($validated['contacto_telefono'] ?? null) ?: null,
            correo: ($validated['contacto_correo'] ?? null) ?: null,
        );

        return redirect()
            ->route('admin.contenido.index', ['tab' => 'contacto'])
            ->with('status', 'Información de contacto actualizada.');
    }

    public function catalogo()
    {
        return view('admin.catalogo.index');
    }

    public function profile()
    {
        return view('admin.profile');
    }
}
