<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credito extends Model
{
    protected $fillable = [
        'cliente_id',
        'agencia_id',
        'asesor_id',
        'estado',
        'fecha_reg',
        'tipo',
        'monto',
        'producto',
        'frecuencia',
        'plazo',
        'medioorigen',
        'dondepagara',
        'fuenterecursos',
        'tasainteres',
        'total',
        'costomora',
    ];
}
