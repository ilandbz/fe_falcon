<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    public function perdidaGanancia(): BelongsTo
    {
        return $this->belongsTo(PerdidaGanancia::class, 'credito_id');
    }
}

