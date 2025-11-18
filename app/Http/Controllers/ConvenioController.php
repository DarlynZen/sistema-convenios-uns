<?php

namespace App\Http\Controllers;

use App\Models\Convenio;
use Illuminate\Http\Request;

class ConvenioController extends Controller
{
        public function index()
    {
        $convenios = Convenio::all();
        return view('admin.convenios.index', compact('convenios'));
    }
}
