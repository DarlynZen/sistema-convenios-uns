<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CmsSeccionService;

class SiteController extends Controller
{
    public function __construct(
        private CmsSeccionService $cmsSeccionService
    ) {
    }

    public function inicio(Request $request)
    {
        $tab = $request->query('tab', 'inicio');
        $heroViewData = $this->cmsSeccionService->getHeroPublicViewData();
        $contactoViewData = $this->cmsSeccionService->getContactoPublicViewData();
        return view('site.convenios.welcome', array_merge(compact('tab'), $heroViewData, $contactoViewData));
    }

    public function nuestrosConvenios(Request $request)
    {
        $tab = $request->query('tab', 'nuestros-convenios');
        $heroViewData = $this->cmsSeccionService->getHeroPublicViewData();
        $contactoViewData = $this->cmsSeccionService->getContactoPublicViewData();
        return view('site.convenios.welcome', array_merge(compact('tab'), $heroViewData, $contactoViewData));
    }

    public function nosotros(Request $request)
    {
        $tab = $request->query('tab', 'nosotros');
        $heroViewData = $this->cmsSeccionService->getHeroPublicViewData();
        $contactoViewData = $this->cmsSeccionService->getContactoPublicViewData();
        return view('site.convenios.welcome', array_merge(compact('tab'), $heroViewData, $contactoViewData));
    }
}
