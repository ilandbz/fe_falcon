<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GastoFamiliarPG extends Model
{
    protected $primaryKey = 'credito_id';
    public $incrementing = false;
    protected $fillable = [
        'credito_id',
        'alimentacion',
        'alquileres',
        'educacion',
        'servicios',
        'transporte',
        'salud',
        'otros',
    ];
}
