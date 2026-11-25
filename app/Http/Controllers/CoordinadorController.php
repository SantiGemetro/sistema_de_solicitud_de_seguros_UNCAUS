<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formulario;
use App\Models\Coordinador;
use App\Models\Operador;
use Illuminate\Support\Facades\Hash;

class CoordinadorController extends Controller
{

    /**
     * Agrega cabeceras anti-caché para impedir que el botón "Volver atrás"
     * del navegador muestre vistas protegidas tras cerrar sesión.
     */
    private function sinCache($vista)
    {
        return response($vista)
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT');
    }

    /**
     * Muestra la pantalla de login para el Coordinador.
     */
    public function showLogin()
    {
        if (session()->has('coordinador_id')) {
            return redirect()->route('coordinador.dashboard');
        }

        return $this->sinCache(view('coordinador.login'));
    }

    /**
     * Procesa el login del Coordinador por nombre de usuario y contraseña.
     */
    public function login(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'contraseña' => 'required|string',
        ]);

        $coordinador = Coordinador::where('nombre', $request->nombre)->first();

        $credencialesValidas = $coordinador && (
            $coordinador->contraseña === $request->contraseña ||
            (str_starts_with((string) $coordinador->contraseña, '$2y$') &&
                Hash::check($request->contraseña, $coordinador->contraseña))
        );

        if (!$credencialesValidas) {
            return back()
                ->withErrors(['nombre' => 'Nombre de usuario o contraseña incorrectos.'])
                ->withInput($request->only('nombre'));
        }

        session([
            'coordinador_id' => $coordinador->id_coordinador,
            'coordinador_nombre' => $coordinador->nombre,
            //para la logica de los casos de formulario
            'coordinador_tipo' => $coordinador->tipo,
            'coordinador_correo' => $coordinador->correo,
            'coordinador_carrera' => $coordinador->carrera
        ]);

        return redirect()->route('coordinador.dashboard');
    }

    /**
     * Cierra la sesión del Coordinador e invalida la sesión activa.
     */
    public function logout(Request $request)
    {
        session()->forget(['coordinador_id', 'coordinador_nombre']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('coordinador.login');
    }

    /**
     * Muestra la pantalla principal del coordinador (resources/views/coordinador/index.blade.php).
     */
    public function index()
    {
        if (!session()->has('coordinador_id')) {
            return redirect()->route('coordinador.login');
        }

        $coordinador = Coordinador::find(session('coordinador_id'));

        if (!$coordinador) {
            session()->forget(['coordinador_id', 'coordinador_nombre']);
            return redirect()->route('coordinador.login');
        }

        // Buscamos los formularios cuya carrera/área coincida con la del coordinador logueado
        $solicitudesPendientes = Formulario::where('carrera', $coordinador->carrera)->whereIn('estado', ['pendiente', 'avalado/listo'])->get();

        return $this->sinCache(view('coordinador.index', compact('coordinador', 'solicitudesPendientes')));    }

    /**
     * Muestra la pantalla de revisión de una solicitud específica por su ID.
     */
    public function show($id)
    {
        if (!session()->has('coordinador_id')) {
            return redirect()->route('coordinador.login');
        }

        $coordinador = Coordinador::find(session('coordinador_id'));

        if (!$coordinador) {
            session()->forget(['coordinador_id', 'coordinador_nombre']);
            return redirect()->route('coordinador.login');
        }

        $formulario = Formulario::with(['fechas', 'estudiantes', 'profesores', 'coordinador'])->findOrFail($id);

        return $this->sinCache(view('coordinador.revisar', compact('formulario', 'coordinador')));
    }

    /**
     * Aval y firma digital de la solicitud por parte del Coordinador.
     */
    public function confirmar(Request $request, $id)
    {
        if (!session()->has('coordinador_id')) {
            return redirect()->route('coordinador.login');
        }

        $formulario = Formulario::findOrFail($id);
        $coordinador = Coordinador::findOrFail(session('coordinador_id'));

        if ($formulario->estado === 'avalado/listo') {
            return redirect()->route('coordinador.dashboard')
                ->with('success', 'Esta solicitud ya se encuentra avalada.');
        }

        $formulario->estado = 'avalado/listo';
        $formulario->id_coordinador = $coordinador->id_coordinador;
        $formulario->save();

        return redirect()->route('coordinador.dashboard')
            ->with('success', '¡Solicitud avalada y firmada exitosamente!');
    }



    /**
     * Confirmación de solicitud por parte del Coordinador.
     * Forma antigua de confirmar la solicitud
     */
    // public function confirmar(Request $request, $id)
    // {
    //     if (!session()->has('coordinador_id')) {
    //         return redirect()->route('coordinador.login');
    //     }

    //     $formulario = Formulario::findOrFail($id);

    //     // CASO 1: DESAVALAR LA SOLICITUD
    //     if ($request->input('accion') === 'desavalar') {

    //         $formulario->estado = 'pendiente';
    //         $formulario->save();
    //         return redirect()->route('coordinador.dashboard')
    //                         ->with('success', 'La solicitud ha vuelto al estado pendiente.');
    //     }

    //     // CASO 2: AVALAR Y CONFIRMAR LA SOLICITUD (Requiere firma)
    //     $request->validate([
    //         'firma' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    //     ]);

    //     if ($request->hasFile('firma')) {
    //         $pathFirma = $request->file('firma')->store('firmas_coordinadores', 'public');
    //     }

    //     $formulario->estado = 'avalado/listo'; // Cambia a estado listo
    //     $formulario->save();

    //     return redirect()->route('coordinador.dashboard')
    //         ->with('success', '¡Solicitud confirmada y firmada exitosamente!');
    // }

    /**
     * Muestra la pantalla para registrar un nuevo Coordinador (desde el panel del Operador de BE).
     */
    public function registrar()
    {
        if (!session()->has('operador_id')) {
            return redirect()->route('operador.login');
        }

        $operador = Operador::find(session('operador_id'));

        if (!$operador) {
            session()->forget(['operador_id', 'operador_nombre']);
            return redirect()->route('operador.login');
        }

          return $this->sinCache(view('operador.registrar_coordinador', compact('operador')));
    }
    /**
     * Guarda un nuevo Coordinador en la tabla coordinador (ejecutado por el Operador de BE).
     */
    public function store(Request $request)
    {
        if (!session()->has('operador_id')) {
            return redirect()->route('operador.login');
        }

        $request->validate([
            'nombre' => 'required|string|max:155',
            'tipo' => 'required|in:area,carrera',
            'carrera' => 'required|string|max:155',
            'correo' => 'required|email|max:155',
            'contraseña' => 'required|string|min:3|max:255',
            'cod_area' => 'required|string|max:6',
            'prefijo' => 'required|string|max:6',
            'numero_final' => 'required|string|max:8',
            'firma_aclaracion' => 'nullable|image|mimes:jpeg,png,jpg|max:4096',
        ]);

        $telefonoCompleto = '+54 9 ' . trim($request->cod_area) . ' ' . trim($request->prefijo) . '-' . trim($request->numero_final);

        $pathFirma = $request->file('firma_aclaracion')->store('firmas_coordinadores', 'public');

        $nuevoCoordinador = Coordinador::create([
            'nombre' => $request->nombre,
            'tipo' => $request->tipo,
            'carrera' => $request->carrera,
            'correo' => $request->correo,
            'contraseña' => $request->contraseña,
            'telefono' => substr($telefonoCompleto, 0, 20),
            'firma_aclaracion' => $pathFirma,
        ]);

        return redirect()
            ->route('operador.index')
            ->with('success', "El perfil del coordinador {$nuevoCoordinador->nombre} ({$nuevoCoordinador->carrera}) fue registrado con éxito.");
    }
}
