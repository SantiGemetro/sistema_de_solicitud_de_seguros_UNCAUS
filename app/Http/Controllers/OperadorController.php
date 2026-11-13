<?php

namespace App\Http\Controllers;

use App\Models\Formulario;
use Illuminate\Http\Request;

class OperadorController extends Controller
{
    /**
     * Panel principal del Operador de Bienestar Estudiantil.
     */
    public function index(Request $request)
    {
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

        return view('operador.index', compact('pendientes', 'historial', 'busqueda'));
    }

    /**
     * Muestra todos los datos detallados de un formulario específico.
     */
    public function show($id)
    {
        $formulario = Formulario::with([
            'solicitante',
            'coordinadorAvala',
            'fechas',
            'estudiantes',
            'profesores'
        ])->findOrFail($id);

        return view('operador.show', compact('formulario'));
    }

    /**
     * Actualiza el estado del formulario (Aceptar / Rechazar).
     */
    public function actualizarEstado(Request $request, $id)
    {
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