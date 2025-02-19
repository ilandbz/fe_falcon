<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetVentaPG extends Model
{
    protected $primaryKey = ['credito_id', 'nroproducto'];

    protected $fillable = [
        'credito_id',
        'nroproducto',
        'descripcion',
        'unidadmedida',
        'preciounit',
        'primaprincipal',
        'primasecundaria',
        'primacomplement',
        'matprima',
        'manoobra1',
        'manoobra2',
        'manoobra',
        'costoprimount',
        'prodmensual',
        'ventastotales',
        'totcostoprimo',
        'margenventas',
    ];

    /**
     * Get the venta that owns the DetVentaPG
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function venta(): BelongsTo
    {
        return $this->belongsTo(VentaPG::class, 'credito_id');
    }
}
