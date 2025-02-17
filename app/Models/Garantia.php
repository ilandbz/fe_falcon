<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Garantia extends Model
{
    protected $fillable = [
        'tasa',
        'fondo',
        'fecha',
        'credito_id',
        'estado',
    ];
}
