<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formulario;

class SolicitudController extends Controller
{
    //este script sirve para solicitantes que quieren consultar los datos de su solicitud o cancelarla
    public function consultar($token) //segun el token que reciba
    {
        $formulario = Formulario::with([ //carga su formulario correspondiente, con todos los datos que necesita mostrar
            'solicitante',
            'fechas',
            'estudiantes',
            'profesores'
        ])
        ->where( //compara que el atributo token_acceso de la tabla formulario sea igual al hash del token que reciba
            'token_acceso',
            hash('sha256', $token)
        )
        ->firstOrFail();

        return view('solicitante.consultar', [
            'formulario' => $formulario,
            'token' => $token //para enviarselo al blade. Vamos a necesitarlo para cancelar
        ]);
    }
}
