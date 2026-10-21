<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FechasFormulario extends Model
{
    protected $table = 'fechas_formulario';
    protected $primaryKey = 'id_fechas';
    public $timestamps = false;

    protected $fillable = [
        'id_formulario',
        'fecha_inicio',
        'fecha_fin',
    ];
}
