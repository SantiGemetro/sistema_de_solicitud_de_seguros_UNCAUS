<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormularioRequest;
use App\Models\Formulario;
use App\Models\Estudiante;
use App\Models\Profesor;
use App\Models\Solicitante;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\VerificacionCorreoController;

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
            $resultado = DB::transaction(function () use ($request) {
                $esCoordinador = session()->has('coordinador_id');
                $esOperador = session()->has('operador_id');

                // Definir estado inicial según el rol activo
                $estadoInicial = $esCoordinador ? 'avalado/listo' : 'pendiente';
                $estadoSeguroInicial = $esCoordinador ? 'confirmado' : 'pendiente_verificacion';
                $correoSolicitante = $esCoordinador
                    ? ($request->correo_solicitante ?: session('coordinador_correo'))
                    : $request->correo_solicitante;

                // 1) Gestionar el Solicitante en sistema_seguros_bd (columna correo_solicitante)
                $solicitante = Solicitante::firstOrCreate(
                    ['correo_solicitante' => $correoSolicitante]
                );

                // 2) Crear el Formulario principal
                $formulario = $solicitante->formularios()->create([
                    'materia'        => $request->materia,
                    'actividad'      => $request->actividad,
                    'carrera'        => $request->carrera,
                    'nom_lugar'      => $request->nom_lugar,
                    'dir_lugar'      => $request->dir_lugar,
                    'id_solicitante' => $solicitante->id_solicitante,
                    'id_coordinador' => $esCoordinador ? session('coordinador_id') : null,
                    'estado'         => $estadoInicial,
                    'estado_seguro'  => $estadoSeguroInicial,
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

                // 6) Crear y enviar la verificación dentro de la transacción para que,
                // si falla la BD o el envío del correo, se haga rollback y no queden formularios duplicados
                if (!$esCoordinador) {
                    app(VerificacionCorreoController::class)
                        ->enviar($formulario->id_formulario);
                }

                return [
                    'idFormulario'  => $formulario->id_formulario,
                    'esCoordinador' => $esCoordinador,
                    'esOperador'    => $esOperador,
                ];
            });

            // 7) Redireccionar según el rol activo (Coordinador, Operador de BE o Inicio)
            if ($resultado['esCoordinador']) {
                return redirect()->route('coordinador.dashboard')
                    ->with('success', '¡Solicitud guardada y avalada con éxito!');
            }

            if ($resultado['esOperador']) {
                return redirect()->route('operador.index')
                    ->with('success', 'Formulario enviado correctamente. Se envió el enlace de verificación al correo del solicitante.');
            }

            return redirect()->route('inicio')
                ->with('success', 'Formulario enviado correctamente. Revisá tu correo para verificarlo.');
        } catch (\Throwable $e) {
            dd($e->getMessage(), $e->getFile(), $e->getLine());
        }
    }
}
