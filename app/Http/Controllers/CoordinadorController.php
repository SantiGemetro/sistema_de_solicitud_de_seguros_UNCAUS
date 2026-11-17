<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Formulario; //importado necesario
use App\Models\Coordinador; //importado necesario

class CoordinadorController extends Controller
{
    //mostrar pantalla de inicio del coordinador
    public function index()
    {
        // 1. Obtenemos el coordinador de prueba (o el usuario logueado actualmente)
        // Buscamos por ejemplo al que tiene la carrera "Licenciatura en Administración"
        $coordinador = Coordinador::where('carrera', 'Licenciatura en Administración')->first();

        // Si no existe, manejamos una alternativa para que no falle
        if (!$coordinador) {
            abort(404, 'No se encontró un coordinador de prueba para esta carrera.');
        }

        // 2. Buscamos SOLAMENTE los formularios cuya carrera coincida con la del coordinador
        $solicitudesPendientes = Formulario::where('carrera', $coordinador->carrera)->get();

        // 3. Retornamos la vista pasando tanto al coordinador como sus solicitudes filtradas
        return view('coordinador.index', compact('coordinador', 'solicitudesPendientes'));
    }

    //mostrar pantalla de revisión de una solicitud específica por su ID
    public function show($id)
    {
        // Buscamos el formulario y traemos las tablas pivote/relacionadas con Eloquent
        $formulario = Formulario::with(['fechas', 'estudiantes', 'profesores'])->findOrFail($id);

        return view('coordinador.revisar', compact('formulario'));
    }

    //confirmacion de solicitud
    public function confirmar(Request $request, $id)
    {
        // Validamos que se haya subido obligatoriamente una imagen de firma
        $request->validate([
            'firma' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $formulario = Formulario::findOrFail($id);

        // Guardamos la imagen de la firma en la carpeta pública o storage de Laravel
        if ($request->hasFile('firma')) {
            $pathFirma = $request->file('firma')->store('firmas_coordinadores', 'public');
            
            // Si en la tabla de solicitudes guardas la ruta de la firma y el estado:
            // $formulario->firma_aclaracion = $pathFirma;
            // $formulario->estado = 'ACEPTADA';
            // $formulario->save();
        }

        return redirect()->route('coordinador.dashboard')
                         ->with('success', '¡Solicitud confirmada y firmada exitosamente!');
    }
}
