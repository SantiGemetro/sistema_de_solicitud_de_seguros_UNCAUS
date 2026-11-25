<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;  
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

use App\Models\Formulario;
use App\Models\VerificacionesCorreo;
use App\Mail\VerificarCorreoMail;
use App\Mail\ComprobanteMail;

use Carbon\Carbon;

class VerificacionCorreoController extends Controller
{
    //para enviar la verificacion de correo
    public function enviar($idFormulario)
    {
        // Cargamos el formulario y su solicitante asociado
        $formulario = Formulario::with(['solicitante', 'fechas']) //traemos fechas tmb para evitar consultar la bd a cada rato
            ->findOrFail($idFormulario); //si no lo encuentra va a tirar un 404

        $solicitante = $formulario->solicitante;

        // Generar código aleatorio
        $token = Str::random(64);

        // Crear una verificacion y guardar solamente el hash
        VerificacionesCorreo::create([
            'id_formulario' => $formulario->id_formulario,
            'token_hash' => hash('sha256', $token),
            'expira_at' => Carbon::now()->addHours(24)
        ]);

        // Crear enlace (se envia al blade verificar)
        $url = route('verificar.correo', [
            'id' => $formulario->id_formulario,
            'token' => $token
        ]);

        // Enviar correo
        Mail::to($solicitante->correo_solicitante)
            ->send(new VerificarCorreoMail($url));

        return back()->with(
            'success',
            'Se envió el enlace de verificación.'
        );
    }

    public function verificar($id, $token)
    {
        //comparar id recibido con columna
        $verificacion = VerificacionesCorreo::where(
            'id_formulario', //columna en bd
            $id //valor
        ) //lo mismo para el tokrn
        ->where(
            'token_hash',
            hash('sha256', $token)
        )
        ->whereNull('verificado_at') //que no este verificado
        ->where('expira_at', '>', Carbon::now()) //que no haya expirado
        ->first();

        if (!$verificacion) {//si no se encontro verif
            return response(
                'El enlace es inválido o ha expirado.',
                403
            );
        }


        $tokenAcceso = Str::random(64);

        DB::transaction(function () use (
            $verificacion,
            $id,
            $tokenAcceso
        ) {
            $verificacion->update([
                'verificado_at' => Carbon::now() //indicamos fecha en la que se verifico
            ]);

            $formulario = Formulario::with('solicitante')
                ->lockForUpdate()
                ->findOrFail($id);

            $formulario->solicitante->update([
                'verificacion_email_tiempo' => Carbon::now()
            ]);

            $formulario->update([
                'estado_seguro' => 'confirmado',
                'token_acceso' => hash('sha256', $tokenAcceso)
            ]);
            $urlConsulta = route('solicitud.consultar', [
                'token' => $tokenAcceso
            ]);
        });

        // Enviar comprobante fuera de la transacción
        $formulario = Formulario::with('solicitante')
            ->findOrFail($id);

        $urlConsulta = route('solicitud.consultar', [
            'token' => $tokenAcceso
        ]);

        Mail::to($formulario->solicitante->correo_solicitante)
            ->send(new ComprobanteMail(
                $formulario,
                $urlConsulta
            ));

        return view('emails.verif_completada');
    }

}
