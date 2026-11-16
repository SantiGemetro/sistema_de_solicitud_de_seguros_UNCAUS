<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormularioRequest;
use Illuminate\Http\Request;
use App\Models\Formulario; 
use App\Models\Estudiante;
use App\Models\Profesor;
use App\Models\FechasFormulario;
use App\Models\Solicitante;
use Illuminate\Support\Facades\DB;

class FormularioController extends Controller
{
    // Muestra la vista del formulario
    public function create()
    {
        return view('solicitud');
    }

    // Procesa los datos y los guarda en la base de datos
    public function store(StoreFormularioRequest $request)
    {
        try{
            //envolvemos en una transaccion para que los datos se envien una vez terminados de procesar
            return DB::transaction(function () use ($request){
                // 1) Gestionar el Solicitante (solicitante=variable)
                $solicitante = Solicitante::firstOrCreate( //buscar o crear correo en BD (por correo)
                    ['correo_solicitante' => $request->correo_solicitante]
                );

                // 2) Crear el Formulario principal
                $formulario = formulario::create([
                    'materia'        => $request->materia,
                    'actividad'      => $request->actividad,
                    'carrera'        => $request->carrera,
                    'nom_lugar'      => $request->nom_lugar,
                    'dir_lugar'      => $request->dir_lugar,
                    'id_solicitante' => $solicitante->id_solicitante,
                    'estado'         => 'pendiente', // Definido automáticamente por el sistema
                ]);

                // 3) Procesar y vincular Profesores
                //$profesoresDnis = []; //crear variable lista vacia
                foreach ($request->profesores as $profesorData) { //para cada profesor
                    $profesor = Profesor::updateOrCreate( //buscar o crear en BD (por DNI)
                        ['dni_profesor' => $profesorData[1]],
                        [
                            'nombre'    => $profesorData[0],
                            'domicilio' => $profesorData[2],
                        ]
                    );
                    $formulario->profesores()->attach( $profesor[1]); //relaciona el dni
                    //$profesoresDnis[] = $profesor->dni_profesor; //agregarlo a la lista
                }
                // Sincroniza la relación en la tabla pivote 'nomina_profesores'
                //$formulario->profesores()->sync($profesoresDnis);

                // 4) Procesar y vincular Estudiantes (mismo proceso que para profes)
                //$estudiantesDnis = [];
                foreach ($request->estudiantes as $estudianteData) {
                    $estudiante = Estudiante::updateOrCreate(
                        ['dni_estudiante' => $estudianteData[1]],
                        [
                            'nombre'    => $estudianteData[0],
                            'domicilio' => $estudianteData[2],
                        ]
                    );
                    $formulario->estudiantes()->attach($estudiante[1]); //relaciona el dni
                    //$estudiantesDnis[] = $estudiante->dni_estudiante;
                }
                // Sincroniza la relación en la tabla pivote 'nomina_estudiantes'
                //$formulario->estudiantes()->sync($estudiantesDnis);

                //! ! ! Para que funcionen las sincronizaciones(attach) de estudiantes y profes tienen que estar las 
                // relaciones belongToMany declaradas en el FormularioCotroller y en los controllers de estudiante, 
                // profe y fechas tmb ! ! !

                // 5) Redireccionar con éxito 
                return redirect()->route('Formulario.store')
                                ->with('success', 'Formulario enviado correctamente, estado: pendiente');
            });
        }catch(\Exception $e){
            // Esto intercepta CUALQUIER error oculto y lo imprime en pantalla obligatoriamente
            dd($e->getMessage(), $e->getFile(), $e->getLine());
        }
    }
}
