<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PerdidaGanancia extends Model
{
    protected $primaryKey = 'credito_id';
    public $incrementing = false;
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

    public function venta(): HasOne
    {
        return $this->hasOne(VentaPG::class, 'credito_id');
    }
    public function gastosnegocio(): HasOne
    {
        return $this->hasOne(GastoNegocioPG::class, 'credito_id');
    }
    public function credito(): BelongsTo
    {
        return $this->belongsTo(Credito::class, 'credito_id');
    }
}