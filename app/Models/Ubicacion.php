<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    protected $fillable = [
        'id',
        'tipo',
        'ubigeo',
        'tipovia',
        'nombrevia',
        'nro',
        'interior',
        'mz',
        'lote',
        'tipozona',
        'nombrezona',
        'referencia',
        'latitud_longitud',
    ];


}
