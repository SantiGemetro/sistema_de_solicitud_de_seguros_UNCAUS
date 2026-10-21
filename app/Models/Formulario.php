<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formulario extends Model
{
    protected $table = 'formulario';
    protected $primaryKey = 'id_formulario';
    public $timestamps = false; // Tu tabla no usa created_at/updated_at

    protected $fillable = [
        'nom_lugar',
        'dir_lugar',
        'actividad',
        'carrera',
        'materia',
        'id_coordinador_avala',
        'id_coordinador_realiza',
        'id_solicitante',
        'id_operador_confirma',
    ];

    public function fechas()
    {
        return $this->hasMany(FechasFormulario::class, 'id_formulario', 'id_formulario');
    }

    public function estudiantes()
    {
        return $this->belongsToMany(
            Estudiante::class,
            'nomina_estudiantes',
            'id_formulario',
            'dni_estudiante'
        );
    }

    public function profesores()
    {
        return $this->belongsToMany(
            Profesor::class,
            'nomina_profesores',
            'id_formulario',
            'dni_profesor'
        );
    }
}
