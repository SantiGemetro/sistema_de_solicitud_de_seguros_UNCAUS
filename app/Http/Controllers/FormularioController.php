<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formulario; //importado
use App\Models\Estudiante;
use App\Models\Profesor;
use App\Models\FechasFormulario;
use App\Models\Solicitante;
use Illuminate\Support\Facades\DB;
use Psy\Readline\Hoa\Console;

class FormularioController extends Controller
{
    // Muestra la vista del formulario
    public function create()
    {
        return view('solicitud');
    }

    // Procesa los datos y los guarda en la base de datos
    public function store(Request $request)
    {
        //1) intentar pasar los json a arrays de php
        try {
            $fechas = json_decode(
                $request->input('fechas', ''),
                true,
                512,
                JSON_THROW_ON_ERROR
            );

        } catch (JsonException $e) {

            return back()
                ->withErrors([
                    'fechas' => 'El formato de las fechas seleccionadas no es válido.'
                ])
                ->withInput();
        }

        // Incorporar el array decodificado a los datos del Request.
        $request->merge(['fechas' => $fechas]);

        //2. Validar los campos enviados por el formulario HTML
        $request->validate([
            'nom_lugar' => 'required|string|max:255',
            'dir_lugar' => 'required|string|max:255',
            'actividad' => 'required|string|max:255',
            'carrera'   => 'required|string|max:255',
            'materia'   => 'required|string|max:255',
            // Fechas y horarios
            'fechas' => 'required|array|min:1',
            //(el * dice que lo haga para cada fecha de fechas)
            'fechas.*.fecha' => [
                'required',
                'date_format:Y-m-d',
                'distinct'
            ],
            'fechas.*.hora_inicio' => [
                'required',
                'date_format:H:i'
            ],
            'fechas.*.hora_fin' => [
                'required',
                'date_format:H:i'
            ],
            //nomina estudiantes
            'estudiantes' => 'nullable|array',
            'estudiantes.*.dni_estudiante' => [
                'required',
                'string',
                'max:20',
                'distinct'
            ],
            'estudiantes.*.nombre' => 'required|string|max:255',
            'estudiantes.*.domicilio' => 'required|string|max:255',
            //nomina profesores
            'profesores'  => 'nullable|array',
            'profesores.*.dni_profesor' => [
                'required',
                'string',
                'max:20',
                'distinct'
            ],
            'profesores.*.nombre' => 'required|string|max:255',
            'profesores.*.domicilio' => 'required|string|max:255',
        ]);
        //para asegurar que si falla algo, no se guarde basura
        DB::beginTransaction();

        try{
            DB::transaction(function () use ($validated) {
                // Guardar en la base de datos usando el modelo Formulario
                $formulario = formulario::create([
                    'nom_lugar' => $request->nom_lugar,
                    'dir_lugar' => $request->dir_lugar,
                    'actividad' => $request->actividad,
                    'carrera'   => $request->carrera,
                    'materia'   => $request->materia,
                ]);

                // Guardar las fechas de la actividad 
                if ($request->has('fechas')) {
                    foreach ($request->fechas as $fecha) {
                        FechasFormulario::create([
                            'id_formulario' => $formulario->id_formulario,
                            'fecha'         => $fecha['fecha'],
                            'fecha_inicio'  => $fecha['fecha_inicio'], 
                            'fecha_fin'     => $fecha['fecha_fin'],     
                        ]);
                    }
                }

                //Procesar y asociar la nómina de estudiantes 
                if ($request->has('estudiantes')) {
                    foreach ($request->estudiantes as $est) {
                        // Creamos o actualizamos al estudiante en su tabla maestra usando su DNI
                        $estudiante = Estudiante::updateOrCreate(
                            ['dni_estudiante' => $est['dni']],
                            [
                                'nombre'    => $est['nombre'],
                                'domicilio' => $est['domicilio']
                            ]
                        );
                        // Adjuntamos el DNI del estudiante al formulario actual en la tabla pivote
                        $formulario->estudiantes()->attach($estudiante->dni_estudiante);
                    }
                }

                // Procesar y asociar la nómina de profesores
                if ($request->has('profesores')) {
                    foreach ($request->profesores as $prof) {
                        // Creamos o actualizamos al profesor en su tabla maestra usando su DNI
                        $profesor = Profesor::updateOrCreate(
                            ['dni_profesor' => $prof['dni']],
                            [
                                'nombre'    => $prof['nombre'],
                                'domicilio' => $prof['domicilio']
                            ]
                        );

                        // Adjuntamos el DNI del profesor al formulario actual en la tabla pivote
                        $formulario->profesores()->attach($profesor->dni_profesor);
                    }
                }
            }
            // Si todo salió bien, confirmamos los cambios en la base de datos
            return redirect()->back()->with('success', '¡Solicitud de seguro enviada con éxito!');
        }catch (\Exception $e) {
            // Si ocurre algún error, revertimos toda la operación
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Ocurrió un error al procesar la solicitud: ' . $e->getMessage()])->withInput();
        }
    }
}
