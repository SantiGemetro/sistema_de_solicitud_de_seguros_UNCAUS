<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitante extends Model
{
    protected $table = 'solicitante';
    protected $primaryKey = 'idsolicitante';
    public $timestamps = false;

    protected $fillable = ['correo_solicitante'];
    //relacion con el formulario
    public function formularios()
    {
        return $this->hasMany( //puede tener varios forms
            Formulario::class,
            'id_solicitante', 
            'id_solicitante'
        );
    }
}
