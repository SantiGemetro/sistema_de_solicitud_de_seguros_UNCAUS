<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    protected $table = 'profesor';
    protected $primaryKey = 'dni_profesor';
    public $incrementing = false; //DNI no es autoincremental
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = ['dni_profesor', 'nombre', 'domicilio'];
}
