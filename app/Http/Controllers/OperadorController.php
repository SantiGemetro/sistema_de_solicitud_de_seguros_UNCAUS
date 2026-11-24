<?php

namespace App\Http\Controllers;

use App\Models\Formulario;
use App\Models\Operador;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OperadorController extends Controller
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
     * Se muestra pantalla login para Operador de Bienestar Estudiantil.
     */
    public function showLogin()
    {
        if (session()->has('operador_id')) {
            return redirect()->route('operador.index');
        }
        return $this->sinCache(view('operador.login'));
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
            (str_starts_with((string) $operador->contraseña, '$2y$') &&
            Hash::check($request->contraseña, $operador->contraseña))
        );

        if (!$credencialesValidas) {
            return back()
                ->withErrors(['correo' => 'Correo o contraseña incorrectos.'])
                ->withInput($request->only('correo'));
        }

        $request->session()->regenerate();
        session([
            'operador_id' => $operador->id_operador_de_BE,
            'operador_nombre' => $operador->nombre,
        ]);

        return redirect()->route('operador.index');
    }

    /**
     * Cierra la sesión del Operador de Bienestar Estudiantil e invalida la sesión.
     */
    public function logout(Request $request)
    {
        session()->forget(['operador_id', 'operador_nombre']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

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

        return $this->sinCache(view('operador.registrar', compact('operador')));
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
        if (!session()->has('operador_id')) {
            return redirect()->route('operador.login');
        }

        $operador = Operador::find(session('operador_id'));

        if (!$operador) {
            session()->forget(['operador_id', 'operador_nombre']);
            return redirect()->route('operador.login');
        }

        $busqueda = $request->input('buscar');

        // 1. Solicitudes en curso ('pendiente' o 'avalado/listo')
        $pendientes = Formulario::with(['solicitante'])
            ->withCount(['estudiantes', 'profesores'])
            ->whereIn('estado', ['pendiente', 'avalado/listo', 'PENDIENTE_AVAL', 'AVALADO'])
            ->orderBy('id_formulario', 'desc')
            ->get();

        // 2. Historial de solicitudes admitidas ('enviado') con filtro de búsqueda
        $historialQuery = Formulario::with(['solicitante', 'fechas'])
            ->withCount(['estudiantes', 'profesores'])
            ->whereIn('estado', ['enviado', 'ACEPTADO', 'RECHAZADO']);

        if (!empty($busqueda)) {
            $historialQuery->where(function ($q) use ($busqueda) {
                $q->where('carrera', 'LIKE', "%{$busqueda}%")
                  ->orWhere('actividad', 'LIKE', "%{$busqueda}%")
                  ->orWhereHas('solicitante', function ($sq) use ($busqueda) {
                      $sq->where('correo_solicitante', 'LIKE', "%{$busqueda}%");
                  })
                  ->orWhereHas('fechas', function ($fq) use ($busqueda) {
                      $fq->where('fecha', 'LIKE', "%{$busqueda}%");
                  });
            });
        }

        $historial = $historialQuery->orderBy('id_formulario', 'desc')->get();

        return $this->sinCache(view('operador.index', compact('pendientes', 'historial', 'busqueda', 'operador')));
    }

    /**
     * Muestra todos los datos detallados de un formulario específico.
     */
    public function show($id)
    {
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
            'fechas',
            'estudiantes',
            'profesores'
        ])->findOrFail($id);

        return $this->sinCache(view('operador.show', compact('formulario', 'operador')));
    }

    /**
     * Actualiza el estado del formulario.
     * Si se acepta y envía ('enviado'), muestra el mensaje con la opción de descargar el PDF.
     */
    public function actualizarEstado(Request $request, $id)
    {
        if (!session()->has('operador_id')) {
            return redirect()->route('operador.login');
        }

        $request->validate([
            'estado' => 'required|in:pendiente,avalado/listo,enviado',
        ]);

        $formulario = Formulario::findOrFail($id);
        $formulario->estado = $request->estado;
        $formulario->save();

        $numero = str_pad((string) $formulario->id_formulario, 4, '0', STR_PAD_LEFT);

        if ($request->estado === 'enviado') {
            return redirect()
                ->route('operador.show', $formulario->id_formulario)
                ->with('pdf_listo', true)
                ->with('success', "La solicitud #{$numero} fue aceptada y enviada. Ya puedes descargar el documento PDF para presentar en la aseguradora.");
        }

        return redirect()
            ->route('operador.index')
            ->with('success', "El estado de la solicitud #{$numero} fue actualizado a {$request->estado}.");
    }

    /**
     * Genera y descarga el documento PDF de nómina listo para la aseguradora.
     */
    public function descargarPdf($id)
    {
        if (!session()->has('operador_id')) {
            return redirect()->route('operador.login');
        }

        $formulario = Formulario::with([
            'solicitante',
            'fechas',
            'estudiantes',
            'profesores'
        ])->findOrFail($id);

        $numero = str_pad((string) $formulario->id_formulario, 4, '0', STR_PAD_LEFT);
        $referencia = '#SEG-' . date('Y') . '-' . $numero;

        $pdf = Pdf::loadView('operador.pdf_nomina', compact('formulario', 'referencia'))
            ->setPaper('a4', 'portrait');

        return $pdf->download("Anexo_Nomina_Solicitud_{$numero}.pdf");
    }
}
