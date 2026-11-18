<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordinador extends Model
{
    use HasFactory;

    protected $table = 'coordinador';
    protected $primaryKey = 'id_coordinador';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'correo',
        'contraseña',
        'telefono',
        'tipo',             // 'area' o 'carrera'
        'carrera',          // nombre de la carrera o del área institucional
        'firma_aclaracion',
    ];

    public function esDeArea()
    {
        return $this->tipo === 'area';
    }

    public function esDeCarrera()
    {
        return $this->tipo === 'carrera';
    }
}
