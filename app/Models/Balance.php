<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $fillable = [
        'credito_id',
        'total_activo',
        'total_pasivo',
        'patrimonio',
        'fecha'
    ];
}
