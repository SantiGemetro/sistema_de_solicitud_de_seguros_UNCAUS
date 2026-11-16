<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $table = 'estudiante';
    protected $primaryKey = 'dni_estudiante';
    public $incrementing = false; // El DNI no es autoincremental
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['dni_estudiante', 'nombre', 'domicilio'];
    public function formularios()
    {
        return $this->belongsToMany(
            Formulario::class,
            'nomina_estudiantes',
            'dni_estudiante',
            'id_formulario'
        );
    }
}
