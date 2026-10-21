<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitante extends Model
{
    protected $table = 'solicitante';
    protected $primaryKey = 'idsolicitante';
    public $timestamps = false;

    protected $fillable = ['correo'];
}
