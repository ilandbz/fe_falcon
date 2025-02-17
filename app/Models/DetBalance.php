<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetBalance extends Model
{
    protected $primaryKey = 'credito_id';

    protected $fillable = [
        'activocaja',
        'activobancos',
        'activotascobrar',
        'activoinventarios',
        'pasivodeudaprove',
        'pasivodeudanet',
        'pasivodeudaempre',
        'activomueble',
        'activootrosact',
        'activodepre',
        'pasivolargo',
        'otrascuentasapagar',
        'totalacorriente',
        'totalpcorriente',
        'totalpncorriente',
    ];
}
