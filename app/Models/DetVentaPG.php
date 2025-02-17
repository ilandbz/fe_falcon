<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetVentaPG extends Model
{
    protected $primaryKey = 'credito_id';

    protected $fillable = [
        'credito_id',
        'nroproducto',
        'descripcion',
        'unidadmedida',
        'preciounit',
        'primaprincipal',
        'primasecundaria',
        'primacomplement',
        'matprima',
        'manoobra1',
        'manoobra2',
        'manoobra',
        'costoprimount',
        'prodmensual',
        'ventastotales',
        'totcostoprimo',
        'margenventas',
    ];
}
