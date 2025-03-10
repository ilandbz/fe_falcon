<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagoJunta extends Model
{

    public $timestamps = false;
    protected $fillable = [
        'junta_id',
        'nro',
        'fecha',
        'hora',
        'montopagado',
        'user_id',
        'mediopago',
    ];

}
