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
        $esCoordinador = session()->has('coordinador_id');
        $tipoCoordinador = session('coordinador_tipo'); // 'carrera' o 'area'

        // Reglas base comunes para cualquier formulario
        $rules = [
            // Datos del Formulario
            'nom_lugar'             => 'required|string|max:100',
            'dir_lugar'             => 'required|string|max:150',
            'actividad'             => 'required|string|max:255',
            //estado no se evalua porque no la debe enviar el usuario

            //Fechas
            'fechas'                => 'required|array|min:1',
            'fechas.*.fecha'        => 'required|date_format:Y-m-d',
            'fechas.*.hora_inicio'  => 'required|date_format:H:i',
            'fechas.*.hora_fin'     => 'required|date_format:H:i',

            // Nómina de Docentes
            'profesores'            => 'required|array|min:1',
            'profesores.*.1'        => 'required|string|max:20', //dni_profesores
            'profesores.*.0'        => 'required|string|max:100', //nombre
            'profesores.*.2'        => 'required|string|max:150', //domicilio

            // Nómina de Estudiantes
            'estudiantes'           => 'required|array|min:1',
            'estudiantes.*.1'       => 'required|string|max:20', //dni_estudiante
            'estudiantes.*.0'       => 'required|string|max:100', //nombre
            'estudiantes.*.2'       => 'required|string|max:150', //domicilio
        ];

        // 1. Correo solicitante: obligatorio solo si NO es coordinador
        if (!$esCoordinador) {
            $rules['correo_solicitante'] = 'required|email|max:100';
        }

        // 2. Carrera y Materia: obligatorias solo si NO es un coordinador de tipo 'area'
        if (!($esCoordinador && $tipoCoordinador === 'area')) {
            $rules['carrera'] = 'required|string|max:100';
            $rules['materia'] = 'required|string|max:100';
        }
        else {
            $rules['carrera'] = 'nullable|string|max:100';
            $rules['materia'] = 'nullable|string|max:100';
        }

        // 3. Firma y aclaración: obligatoria únicamente si lo solicita un coordinador
        if ($esCoordinador) {
            $rules['firma'] = 'required|image|mimes:jpeg,png,jpg|max:2048';
        }

        return $rules;
    }
}
