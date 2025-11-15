<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function inicio(Request $request)
    {
        $tab = $request->query('tab', 'inicio');
        return view('site.convenios.welcome', compact('tab'));
    }

    public function nuestrosConvenios(Request $request)
    {
        $tab = $request->query('tab', 'nuestros-convenios');
        return view('site.convenios.welcome', compact('tab'));
    }

    public function nosotros(Request $request)
    {
        $tab = $request->query('tab', 'nosotros');
        return view('site.convenios.welcome', compact('tab'));
    }
}
