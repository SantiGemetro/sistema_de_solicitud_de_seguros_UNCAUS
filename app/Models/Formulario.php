<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formulario extends Model
{
    protected $table = 'formulario';
    protected $primaryKey = 'id_formulario';
    public $timestamps = false;

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
        'estado',
    ];

    public function solicitante()
    {
        return $this->belongsTo(Solicitante::class, 'id_solicitante', 'idsolicitante');
    }

    public function coordinadorAvala()
    {
        return $this->belongsTo(Coordinador::class, 'id_coordinador_avala', 'id_coordinador');
    }

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

    // Acá luego vamos a tener que añadir los codigos de
    // cada carrera, eso es info a consultar
    // Genera el código visual estilo #0001_ISI
    public function getCodigoAttribute(): string
    {
        $numero = str_pad($this->id_formulario, 4, '0', STR_PAD_LEFT);
        if (!$this->carrera) {
            return "#{$numero}_AREA";
        }
        // Toma las iniciales de la carrera (ej. Ingeniería en Sistemas -> ISI)
        $palabras = explode(' ', $this->carrera);
        $siglas = '';
        foreach ($palabras as $p) {
            if (strlen($p) > 2 && !in_array(strtolower($p), ['en', 'de', 'del', 'la', 'las', 'los'])) {
                $siglas .= strtoupper(substr($p, 0, 1));
            }
        }
        return "#{$numero}_" . ($siglas ?: 'GEN');
    }
}