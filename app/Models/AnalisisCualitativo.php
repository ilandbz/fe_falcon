<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalisisCualitativo extends Model
{
    protected $fillable = [
        'credito_id',
        'tipogarantia',
        'cargafamiliar',
        'riesgoedadmax',
        'antecedentescred',
        'recorpagoult',
        'niveldesarr',
        'tiempo_neg',
        'control_ingegre',
        'vent_totdec',
        'compsubsector',
        'totunidfamiliar',
        'totunidempresa',
        'total'
    ];
    
}
