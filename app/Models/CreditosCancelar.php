<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CreditosCancelar extends Model
{
    protected $fillable = [
        'credito_id',
        'credito_pagar_id',
        'estado',
    ];
    public function credito(): BelongsTo
    {
        return $this->belongsTo(Credito::class, 'credito_id');
    }
    public function credito_pagar(): BelongsTo
    {
        return $this->belongsTo(Credito::class, 'credito_pagar_id');
    }
}
