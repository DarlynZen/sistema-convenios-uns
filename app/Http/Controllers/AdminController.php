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
        /*$stats = $this->dashboardService->getStats();*/
        return view('admin.dashboard');
    }

    public function contenido()
    {
        $heroViewData = $this->cmsSeccionService->getHeroAdminViewData();
        return view('admin.contenido.index', $heroViewData);
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
            ->route('admin.contenido.index')
            ->with('status', 'Sección Hero actualizada.');
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
