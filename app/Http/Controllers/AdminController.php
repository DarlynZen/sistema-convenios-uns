<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function convenios()
    {
        return view('admin.gestion-convenios');
    }

    public function cms()
    {
        return view('admin.editor-contenido');
    }

    public function profile()
    {
        return view('admin.profile');
    }
}
