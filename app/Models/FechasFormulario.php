<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FechasFormulario extends Model
{
    protected $table = 'fechas_formulario';
    protected $primaryKey = 'id_fecha'; // En sistema_seguros_bd.sql se llama id_fecha
    public $timestamps = false;

    protected $fillable = [
        'id_formulario',
        'fecha',
        'hora_inicio',
        'hora_fin',
    ];

    public function formulario()
    {
        return $this->belongsTo(
            Formulario::class,
            'id_formulario',
            'id_formulario'
        );
    }
}
