<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagoCredito extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'credito_id',
        'nro',
        'fecha',
        'montopagado',
        'user_id',
        'mediopago',
        'moradias',
    ];
}
