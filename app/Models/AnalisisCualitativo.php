<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnalisisCualitativo extends Model
{
    protected $primaryKey = 'credito_id';
    public $incrementing = false;
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
    public function credito(): BelongsTo
    {
        return $this->belongsTo(Credito::class, 'credito_id');
    }



}
