<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KardexCredito extends Model
{
    protected $fillable = [
        'credito_id',
        'nro',
        'fecha',
        'hora',
        'montopagado',
        'user_id',
        'mediopago',
    ];

    public function desembolso()
    {
        return $this->belongsTo(Desembolso::class, 'credito_id');
    }
}
