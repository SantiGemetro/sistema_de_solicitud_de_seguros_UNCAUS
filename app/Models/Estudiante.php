<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $table = 'estudiante';
    protected $primaryKey = 'dni_estudiante';
    public $incrementing = false; // El DNI no es autoincremental
    protected $keyTipe = 'string';
    public $timestamps = false;

    protected $fillable = ['dni_estudiante', 'nombre', 'domicilio'];
}
