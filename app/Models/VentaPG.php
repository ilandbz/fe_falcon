<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VentaPG extends Model
{
    protected $primaryKey = 'credito_id';
    protected $table = 'venta_p_g_s';
    public $incrementing = false; 
    protected $keyType = 'int'; 

    protected $fillable = [
        'credito_id',
        'tot_ing_mensual',
        'tot_cosprimo_m',
        'margen_tot',
        'ventas_cred',
        'irrecuperable',
        'cantproductos',
    ];

    
    /**
     * Get all of the detalles for the VentaPG
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detalles(): HasMany
    {
        return $this->hasMany(DetVentaPG::class, 'credito_id');
    }
    public function perdidaGanancia(): BelongsTo
    {
        return $this->belongsTo(PerdidaGanancia::class, 'credito_id');
    }




}
