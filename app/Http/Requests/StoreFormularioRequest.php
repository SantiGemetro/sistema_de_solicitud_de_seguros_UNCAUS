<?php

/**
 * Con esta clase realizamos la validación y control datos
 * de entrada en los distintos campos del formulario
 * implementamos distintas reglas
 */

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreFormularioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    protected function prepareForValidation(): void
    {
        $this->merge([ //preparar todas las tablas enviadas en json
            'estudiantes' => json_decode($this->estudiantes, true),
            'profesores' => json_decode($this->profesores, true),
            'fechas' => json_decode($this->input('fechas'), true)
        ]);
    }
    /**
     * Get the validation rules that apply to the request.
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Solicitante y Coordinador
            'correo_solicitante'    => 'required|email|max:100',
            
            
            // Datos del Formulario
            'nom_lugar'             => 'required|string|max:100', //cambie de n a r
            'dir_lugar'             => 'required|string|max:150',
            'actividad'             => 'required|string|max:255',
            'carrera'               => 'required|string|max:100', //de n a r
            'materia'               => 'required|string|max:100', //de n a r
            //estado no se evalua porque no la debe enviar el ususario

            //Fechas 
            'fechas'                => 'required|array|min:1',
            'fechas.*.fecha'        => 'required|date_format:Y-m-d',
            'fechas.*.hora_inicio'  => 'required|date_format:H:i',
            'fechas.*.hora_fin'     => 'required|date_format:H:i',
            
            // Nómina de Docentes
            //como convertimos en un array numerico, ahora cada atributo corresponde a un numero
            //0: nombre, 1:dni, 2:domicilio
            'profesores'       => 'required|array|min:1',
            'profesores.*.1'   => 'required|string|max:20', //dni_profesores
            'profesores.*.0'   => 'required|string|max:100', //nombre
            'profesores.*.2'   => 'required|string|max:150', //domicilio

            // Nómina de Estudiantes
            //igual que en profes
            'estudiantes'      => 'required|array|min:1',
            'estudiantes.*.1'  => 'required|string|max:20', //dni_estudiante
            'estudiantes.*.0'  => 'required|string|max:100', //nombre
            'estudiantes.*.2'  => 'required|string|max:150', //domicilio
        ];
    }
}
