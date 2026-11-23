<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormularioRequest;
use App\Models\Formulario;
use App\Models\Estudiante;
use App\Models\Profesor;
use App\Models\Solicitante;
use Illuminate\Support\Facades\DB;

class FormularioController extends Controller
{
    // Muestra la vista del formulario
    public function create()
    {
        return view('solicitud');
    }

    // Procesa los datos y los guarda en sistema_seguros_bd
    public function store(StoreFormularioRequest $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                // 1) Gestionar el Solicitante en sistema_seguros_bd (columna correo_solicitante)
                $solicitante = Solicitante::firstOrCreate(
                    ['correo_solicitante' => $request->correo_solicitante]
                );

                // 2) Crear el Formulario principal
                $formulario = $solicitante->formularios()->create([
                    'materia'        => $request->materia,
                    'actividad'      => $request->actividad,
                    'carrera'        => $request->carrera,
                    'nom_lugar'      => $request->nom_lugar,
                    'dir_lugar'      => $request->dir_lugar,
                    'id_solicitante' => $solicitante->id_solicitante,
                    'estado'         => 'pendiente',
                ]);

                // 3) Procesar y vincular fechas (columnas fecha, hora_inicio, hora_fin de sistema_seguros_bd.sql)
                foreach ($request->fechas as $fecha) {
                    $formulario->fechas()->create([
                        'fecha'       => $fecha['fecha'],
                        'hora_inicio' => $fecha['hora_inicio'],
                        'hora_fin'    => $fecha['hora_fin'],
                    ]);
                }

                // 4) Procesar y vincular Profesores
                foreach ($request->profesores as $profesorData) {
                    $profesor = Profesor::updateOrCreate(
                        ['dni_profesor' => $profesorData[1]],
                        [
                            'nombre'    => $profesorData[0],
                            'domicilio' => $profesorData[2],
                        ]
                    );
                    $formulario->profesores()->syncWithoutDetaching([$profesor->dni_profesor]);
                }

                // 5) Procesar y vincular Estudiantes
                foreach ($request->estudiantes as $estudianteData) {
                    $estudiante = Estudiante::updateOrCreate(
                        ['dni_estudiante' => $estudianteData[1]],
                        [
                            'nombre'    => $estudianteData[0],
                            'domicilio' => $estudianteData[2],
                        ]
                    );
                    $formulario->estudiantes()->syncWithoutDetaching([$estudiante->dni_estudiante]);
                }

                // 6) Redireccionar según el rol activo (Operador de BE, Coordinador o Inicio)
                if (session()->has('operador_id')) {
                    return redirect()->route('operador.index')
                        ->with('success', 'Formulario enviado correctamente, estado: pendiente');
                }

                if (session()->has('coordinador_id')) {
                    return redirect()->route('coordinador.dashboard')
                        ->with('success', 'Formulario enviado correctamente, estado: pendiente');
                }

                return redirect()->route('inicio')
                    ->with('success', 'Formulario enviado correctamente, estado: pendiente');
            });
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getFile(), $e->getLine());
        }
    }
}
