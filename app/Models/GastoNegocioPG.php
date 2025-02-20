<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GastoNegocioPG extends Model
{
    protected $primaryKey = 'credito_id';
    public $incrementing = false;
    protected $fillable = [
        'credito_id',
        'alquiler',
        'servicios',
        'personal',
        'sunat',
        'transporte',
        'gastosfinancieros',
        'otros',
    ];
}
