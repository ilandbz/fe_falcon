<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetCalendarioPagos extends Model
{
    protected $fillable = [
        'credito_id',
        'nrocuota',
        'fecha_prog',
        'nombredia',
        'cuota',
        'saldo',
    ];
    Public $timestamps = false;
}
