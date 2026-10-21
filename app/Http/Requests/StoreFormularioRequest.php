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
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Solicitante y Coordinador
            'correo_solicitante'    => 'required|email|max:100',
            'id_coordinador_avala'  => 'required|exists:coordinador,id_coordinador',
            
            // Datos del Formulario
            'nom_lugar'             => 'required|string|max:100',
            'dir_lugar'             => 'required|string|max:150',
            'actividad'             => 'required|string|max:255',
            'carrera'               => 'nullable|string|max:100',
            'materia'               => 'nullable|string|max:100',

            // Intervalos de Fechas
            'fechas'                => 'required|array|min:1',
            'fechas.*.fecha_inicio' => 'required|date',
            'fechas.*.fecha_fin'    => 'required|date|after:fechas.*.fecha_inicio',

            // Nómina de Docentes
            'profesores'            => 'nullable|array',
            'profesores.*.dni'      => 'nullable|string|max:20',
            'profesores.*.nombre'   => 'required|string|max:100',
            'profesores.*.domicilio'=> 'required|string|max:150',

            // Nómina de Estudiantes
            'estudiantes'           => 'required|array|min:1',
            'estudiantes.*.dni'     => 'required|numeric|max:20',
            'estudiantes.*.nombre'  => 'required|string|max:100',
            'estudiantes.*.domicilio'=> 'required|string|max:150',
        ];
    }
}
