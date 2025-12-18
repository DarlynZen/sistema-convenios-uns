<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use App\Services\ConvenioService;
use App\Repositories\CmsSeccionRepository;

class AdminController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService,
        private CmsSeccionRepository $cmsSeccionRepository
    ) {}

    public function dashboard()
    {
        /*$stats = $this->dashboardService->getStats();*/
        return view('admin.dashboard');
    }

    public function contenido()
    {
        $secciones = $this->cmsSeccionRepository->getAll();
        return view('admin.contenido.index', compact('secciones'));
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
