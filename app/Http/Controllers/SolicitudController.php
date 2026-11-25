<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formulario;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

    public function cancelar($token) //segun el token que reciba
    {
        $resultado = DB::transaction(function () use ($token) {
            // Buscar la solicitud y bloquearla durante la operación
            $formulario = Formulario::with('fechas')->where(
                    'token_acceso',
                    hash('sha256', $token)
                )
                ->lockForUpdate() //para que no se puedan actualizar varios a la vez
                ->firstOrFail(); //si falla =>404

            // Comprobar si ya fue cancelada
            if ($formulario->estado === 'cancelado') {
                return [
                    'exito' => false,
                    'mensaje' => 'Esta solicitud ya fue cancelada.'
                ];
            }

            // Obtener la fecha actual
            $hoy = Carbon::today();

            // Buscar la fecha más próxima que todavía no pasó
            $fechaMasProxima = $formulario->fechas
                ->map(function ($fecha) {
                    return Carbon::parse($fecha->fecha)->startOfDay();
                })
                ->filter(function ($fecha) use ($hoy) {
                    return $fecha->greaterThanOrEqualTo($hoy);
                })
                ->sort()
                ->first();

            // Si no quedan fechas futuras ni de hoy
            if (!$fechaMasProxima) {
                return [
                    'exito' => false,
                    'mensaje' => 'No se puede cancelar: la actividad ya pasó o no tiene fechas pendientes.'
                ];
            }

            // Contar los días hábiles que quedan ENTRE hoy
            // y la fecha de la actividad.
            $diasHabiles = 0;

            $dia = $hoy->copy()->addDay();

            while ($dia->lessThan($fechaMasProxima)) {

                // isWeekday() devuelve true de lunes a viernes
                if ($dia->isWeekday()) {
                    $diasHabiles++;
                }

                $dia->addDay();
            }

            // Debe quedar al menos un día hábil completo
            if ($diasHabiles < 1) {
                return [
                    'exito' => false,
                    'mensaje' => 'No se puede cancelar: debe quedar al menos un día hábil antes de la actividad.'
                ];
            }

            // Si cumple las condiciones, cancelar
            $formulario->estado = 'cancelado';
            $formulario->save();

            return [
                'exito' => true,
                'mensaje' => 'La solicitud fue cancelada correctamente.'
            ];
        });

        // Volver a la pantalla de consulta mostrando el resultado
        return redirect()
            ->route('solicitud.consultar', ['token' => $token])
            ->with(
                $resultado['exito'] ? 'success' : 'error',
                $resultado['mensaje']
            );
    }
}
