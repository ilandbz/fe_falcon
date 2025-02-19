<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerdidaGanancia extends Model
{
    protected $fillable = [
        'credito_id',
        'ventas',
        'costo',
        'utilidad',
        'costonegocio',
        'utiloperativa',
        'otrosing',
        'otrosegr',
        'gast_fam',
        'utilidadneta',
        'utilnetdiaria',
    ];
}
