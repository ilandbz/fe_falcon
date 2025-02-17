<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropuestaCredito extends Model
{
    protected $fillable = [
        'credito_id',
        'unidad_familiar',
        'experiencia_cred',
        'destino_prest',
        'referencias',
    ];
}
