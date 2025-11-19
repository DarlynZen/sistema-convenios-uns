<?php

namespace App\Http\Controllers;

use App\Models\Convenio;
use App\Models\TipoConvenio;
use App\Models\Ambito;
use App\Models\CmsSeccion;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = Convenio::getDashboardStats();
        return view('admin.dashboard', compact('stats'));
    }

    public function convenios()
    {
        $convenios = Convenio::getAllWithRelations();
        return view('admin.gestion-convenios', compact('convenios'));
    }

    public function cms()
    {
        $secciones = CmsSeccion::getAll();
        return view('admin.editor-contenido', compact('secciones'));
    }

    public function profile()
    {
        return view('admin.profile');
    }
}
