<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormularioController extends Controller
{
    public function create()
    {
        $coordinadores = DB::table('coordinador')->orderBy('nombre', 'asc')->get();
        
    }
}
