<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use App\Repositories\ConvenioRepository;
use App\Repositories\CmsSeccionRepository;

class AdminController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService,
        private ConvenioRepository $convenioRepository,
        private CmsSeccionRepository $cmsSeccionRepository
    ) {}

    public function dashboard()
    {
        /*$stats = $this->dashboardService->getStats();*/
        return view('admin.dashboard');
    }

    public function convenios()
    {
        $convenios = $this->convenioRepository->obtenerTodoConRelaciones();
        return view('admin.gestion-convenios', compact('convenios'));
    }

    public function cms()
    {
        $secciones = $this->cmsSeccionRepository->getAll();
        return view('admin.editor-contenido', compact('secciones'));
    }

    public function catalogo()
    {
        return view('admin.catalogo');
    }

    public function profile()
    {
        return view('admin.profile');
    }
}
