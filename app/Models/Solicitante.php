<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitante extends Model
{
    protected $table = 'solicitante';
    protected $primaryKey = 'id_solicitante'; // En sistema_seguros_bd.sql se llama id_solicitante
    public $timestamps = false;

    protected $fillable = ['correo_solicitante'];

    // Relación con el formulario
    public function formularios()
    {
        return $this->hasMany(
            Formulario::class,
            'id_solicitante',
            'id_solicitante'
        );
    }
}
