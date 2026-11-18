<?php

namespace App\Http\Controllers;

use App\Models\Formulario;
use App\Models\Operador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OperadorController extends Controller
{
    /**
     * Se muestra pantalla login para Operador de Bienestar Estudiantil.
     */
    public function showLogin()
    {
        if (session()->has('operador_id')) {
            return redirect()->route('operador.index');
        }
        return view('operador.login');
    }

    /**
     * Se procesa el login del Operador de Bienestar Estudiantil.
     */
    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'contraseña' => 'required|string',
        ]);

        $operador = Operador::where('correo', $request->correo)->first();

        $credencialesValidas = $operador && (
            $operador->contraseña === $request->contraseña ||
            (str_starts_with($operador->contraseña, '$2y$') &&
            Hash::check($request->contraseña, $operador->contraseña))
        );
        // if ($operador && Hash::check($request->password, $operador->password)) {
        //     session(['operador_id' => $operador->id]);
        //     return redirect()->route('operador.index');
        // }

        if(!$credencialesValidas) {
            return back()
            ->withErrors(['correo' => 'Correo o contraseña incorrectos.'])
            ->withInput($request->only('correo'));
        }
        session([
            'operador_id' => $operador->id_operador_de_BE,
            'operador_nombre' => $operador->nombre,
        ]);

        return redirect()->route('operador.index');

    }

    /**
     * Cierra la sesión del Operador de Bienestar Estudiantil.
     */
    public function logout()
    {
        session()->forget(['operador_id', 'operador_nombre']);
        return redirect()->route('operador.login');
    }

    /**
     * Muestra el formulario para registrar un nuevo perfil de Operador de BE.
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

        return view('operador.registrar', compact('operador'));
    }


    /**
     * Alias por compatibilidad si se llama a create().
     */
    public function create()
    {
        return $this->registrar();
    }


    /**
     * Guarda un nuevo perfil de Operador de BE en la tabla operador_de_be.
     */
    public function store(Request $request)
    {
        if (!session()->has('operador_id')) {
            return redirect()->route('operador.login');
        }

        $request->validate([
            'nombre' => 'required|string|max:155',
            'correo' => 'required|email|max:155|unique:operador_de_be,correo',
            'contraseña' => 'required|string|min:3|max:255',
        ], [
            'correo.unique' => 'Ya existe un operador registrado con ese correo electrónico.',
        ]);

        $nuevoOperador = Operador::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'contraseña' => $request->contraseña,
        ]);

        return redirect()
            ->route('operador.index')
            ->with('success', "El perfil del operador {$nuevoOperador->nombre} fue registrado con éxito.");
    }



    /**
     * Panel principal del Operador de Bienestar Estudiantil.
     */
    public function index(Request $request)
    {
        // Agrego verificación de sesión para el operador
        if (!session()->has('operador_id')) {
            return redirect()->route('operador.login');
        }

        $operador = Operador::find(session('operador_id'));

        if (!$operador) {
            session()->forget(['operador_id', 'operador_nombre']);
            return redirect()->route('operador.login');
        }

        // Captura el término de búsqueda desde la solicitud
        $busqueda = $request->input('buscar');

        // 1. Solicitudes en curso (Pendientes de aval o ya avaladas/listas para revisar)
        $pendientes = Formulario::with(['solicitante'])
            ->withCount(['estudiantes', 'profesores'])
            ->whereIn('estado', ['PENDIENTE_AVAL', 'AVALADO'])
            ->orderBy('id_formulario', 'desc')
            ->get();

        // 2. Historial de solicitudes admitidas (Aceptadas o Rechazadas) con filtro de búsqueda
        $historialQuery = Formulario::with(['solicitante', 'fechas'])
            ->withCount(['estudiantes', 'profesores'])
            ->whereIn('estado', ['ACEPTADO', 'RECHAZADO']);

        if (!empty($busqueda)) {
            $historialQuery->where(function ($q) use ($busqueda) {
                $q->where('carrera', 'LIKE', "%{$busqueda}%")
                  ->orWhere('actividad', 'LIKE', "%{$busqueda}%")
                  ->orWhereHas('solicitante', function ($sq) use ($busqueda) {
                      $sq->where('correo', 'LIKE', "%{$busqueda}%");
                  })
                  ->orWhereHas('fechas', function ($fq) use ($busqueda) {
                      $fq->where('fecha_inicio', 'LIKE', "%{$busqueda}%");
                  });
            });
        }

        $historial = $historialQuery->orderBy('id_formulario', 'desc')->get();

        return view('operador.index', compact('pendientes', 'historial', 'busqueda', 'operador'));

    }

    /**
     * Muestra todos los datos detallados de un formulario específico.
     */
    public function show($id)
    {
        // Agrego verificación de sesión para el operador
        if (!session()->has('operador_id')) {
            return redirect()->route('operador.login');
        }

        $operador = Operador::find(session('operador_id'));

        if (!$operador) {
            session()->forget(['operador_id', 'operador_nombre']);
            return redirect()->route('operador.login');
        }

        $formulario = Formulario::with([
            'solicitante',
            'coordinadorAvala',
            'fechas',
            'estudiantes',
            'profesores'
        ])->findOrFail($id);

        return view('operador.show', compact('formulario', 'operador'));
    }

    /**
     * Actualiza el estado del formulario (Aceptar / Rechazar).
     */
    public function actualizarEstado(Request $request, $id)
    {
        // Agrego verificación de sesión para el operador
        if (!session()->has('operador_id')) {
            return redirect()->route('operador.login');
        }

        $request->validate([
            'estado' => 'required|in:ACEPTADO,RECHAZADO,PENDIENTE_AVAL,AVALADO',
        ]);

        $formulario = Formulario::findOrFail($id);
        $formulario->estado = $request->estado;
        $formulario->save();

        return redirect()
            ->route('operador.index')
            ->with('success', "El estado de la solicitud {$formulario->codigo} fue actualizado a {$request->estado}.");
    }
}
