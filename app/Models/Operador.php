<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operador extends Model
{
    protected $table = 'operador_de_be';
    protected $primaryKey = 'id_operador_de_BE'; // Ajusta si en tu BD se llama idoperador_de_be
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'correo',
        'contraseña',
    ];
}