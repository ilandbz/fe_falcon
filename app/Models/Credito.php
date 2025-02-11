<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Credito extends Model
{
    protected $fillable = [
        'cliente_id',
        'agencia_id',
        'asesor_id',
        'estado',
        'fecha_reg',
        'tipo',
        'monto',
        'producto',
        'frecuencia',
        'plazo',
        'medioorigen',
        'dondepagara',
        'fuenterecursos',
        'tasainteres',
        'total',
        'costomora',
    ];
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function asesor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'asesor_id');
    }

    public function agencia(): BelongsTo
    {
        return $this->belongsTo(Agencia::class, 'agencia_id');
    }   
}
