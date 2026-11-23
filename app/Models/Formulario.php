<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formulario extends Model
{
    protected $table = 'formulario';
    protected $primaryKey = 'id_formulario';
    public $timestamps = false; // La tabla no usa created_at/updated_at

    protected $fillable = [
        'nom_lugar',
        'dir_lugar',
        'actividad',
        'carrera',
        'materia',
        'id_solicitante',
        'estado', //nuevo
    ];

    public function solicitante()
    {
        return $this->belongsTo( //pertenece a solo un solicitante
            Solicitante::class,
            'id_solicitante',
            'id_solicitante'
        );
    }
    public function fechas()
    {
        return $this->hasMany( //un form tiene varias fechas
            FechasFormulario::class,
            'id_formulario',
            'id_formulario'
        );
    }
    public function estudiantes()
    {
        return $this->belongsToMany(
            Estudiante::class, //referencia a modelo Estudiantes
            'nomina_estudiantes',
            'id_formulario',
            'dni_estudiante',
            'id_formulario',
            'dni_estudiante'
        );
    }

    public function profesores()
    {
        return $this->belongsToMany(
            Profesor::class, //referencia a modelo Profesor (El modelo con el que se relaciona)
            'nomina_profesores', //La tabla pivote (intermedia) en la BD
            'id_formulario', //La FK en la pivote que apunta a ESTE modelo (Formulario)
            'dni_profesor', //La FK en la pivote que apunta al OTRO modelo (Profesor)
            'id_formulario', //La PK de ESTE modelo (Formulario)
            'dni_profesor' //La PK del OTRO modelo (Profesor)
        );
    }
}
