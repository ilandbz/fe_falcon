<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VentaPG extends Model
{
    protected $primaryKey = 'credito_id';


    protected $fillable = [
        'credito_id',
        'tot_ing_mensual',
        'tot_cosprimo_m',
        'margen_tot',
        'ventas_cred',
        'irrecuperable',
        'cantproductos',
    ];
}
