<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Balance extends Model
{
    protected $primaryKey = 'credito_id';
    public $incrementing = false;
    protected $fillable = [
        'credito_id',
        'total_activo',
        'total_pasivo',
        'patrimonio',
        'activocaja',
        'activobancos',
        'activoctascobrar',
        'activoinventarios',
        'pasivodeudaprove',
        'pasivodeudaent',
        'pasivodeudaempre',
        'activomueble',
        'activootrosact',
        'activodepre',
        'pasivolargop',
        'otrascuentaspagar',
        'totalacorriente',
        'totalpcorriente',
        'totalancorriente',
        'totalpncorriente',
        'fecha'
    ];


}
