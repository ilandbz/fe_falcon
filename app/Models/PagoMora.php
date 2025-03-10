<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagoMora extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'credito_id',
        'nro',
        'diasmora',
        'total',
        'fecha',
        'hora',
        'user_id',
    ];


}
