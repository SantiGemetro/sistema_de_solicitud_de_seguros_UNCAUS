<?php

namespace App\Http\Controllers;

use App\Models\Coordinador;
use App\Models\Operador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private function sinCache($vista)
    {
        return response($vista)
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT');
    }

    private function passwordValida(string $ingresada, ?string $guardada): bool
    {
        if ($guardada === null) {
            return false;
        }

        return $guardada === $ingresada ||
            (str_starts_with($guardada, '$2y$') && Hash::check($ingresada, $guardada));
    }

    /**
     * Muestra la pantalla única de inicio de sesión para Operadores de BE y Coordinadores.
     */
    public function showLogin()
    {
        if (session()->has('operador_id')) {
            return redirect()->route('operador.index');
        }

        if (session()->has('coordinador_id')) {
            return redirect()->route('coordinador.dashboard');
        }

        return $this->sinCache(view('login'));
    }

    /**
     * Procesa el login unificado por nombre de usuario y contraseña,
     * redirigiendo automáticamente según el rol (Operador de BE o Coordinador).
     */
    public function login(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'contraseña' => 'required|string',
        ]);

        $nombre = trim($request->nombre);
        $password = $request->contraseña;

        // 1. Verificar si corresponde a un Operador de Bienestar Estudiantil (por nombre de usuario)
        $operador = Operador::where('nombre', $nombre)->first();
        if ($operador && $this->passwordValida($password, $operador->contraseña)) {
            $request->session()->regenerate();
            session()->forget([
                'coordinador_id',
                'coordinador_nombre',
                'coordinador_tipo',
                'coordinador_correo',
                'coordinador_carrera',
            ]);
            session([
                'operador_id' => $operador->id_operador_de_BE,
                'operador_nombre' => $operador->nombre,
            ]);

            return redirect()->route('operador.index');
        }

        // 2. Verificar si corresponde a un Coordinador (de carrera o de área)
        $coordinador = Coordinador::where('nombre', $nombre)->first();
        if ($coordinador && $this->passwordValida($password, $coordinador->contraseña)) {
            $request->session()->regenerate();
            session()->forget(['operador_id', 'operador_nombre']);
            session([
                'coordinador_id' => $coordinador->id_coordinador,
                'coordinador_nombre' => $coordinador->nombre,
                'coordinador_tipo' => $coordinador->tipo,
                'coordinador_correo' => $coordinador->correo,
                'coordinador_carrera' => $coordinador->carrera,
            ]);

            return redirect()->route('coordinador.dashboard');
        }

        return back()
            ->withErrors(['nombre' => 'Nombre de usuario o contraseña incorrectos.'])
            ->withInput($request->only('nombre'));
    }
}
