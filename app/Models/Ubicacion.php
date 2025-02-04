<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    protected $fillable = [
        'id',
        'tipo',
        'distrito',
        'tipovia',
        'nombrevia',
        'nro',
        'interior',
        'mz',
        'lote',
        'tipozona',
        'nombrezona',
        'referencia',
    ];
}
