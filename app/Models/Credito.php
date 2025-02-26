<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Credito extends Model
{
    protected $appends = ['moradiaria'];
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

    public function analisis(): HasOne
    {
        return $this->hasOne(AnalisisCualitativo::class, 'credito_id');
    }
    public function balance(): HasOne
    {
        return $this->hasOne(Balance::class, 'credito_id');
    }
    public function seguro(): HasOne
    {
        return $this->hasOne(SeguroDesgravamen::class, 'credito_id');
    }    
    public function perdidas(): HasOne
    {
        return $this->hasOne(PerdidaGanancia::class, 'credito_id');
    }
    public function propuesta(): HasOne
    {
        return $this->hasOne(PropuestaCredito::class, 'credito_id');
    }
    /**
     * Verifica si la solicitud tiene todos los registros requeridos
     */
    public function tieneTodosLosRegistros(): bool
    {
        return !is_null($this->analisis) && 
               !is_null($this->balance) && 
               !is_null($this->perdidas) && 
               !is_null($this->propuesta);
    }
    public function getMoradiariaAttribute()
    {
        return CostoMora::where('montoinicial', '<=', $this->monto)
                        ->where('montofinal', '>=', $this->monto)
                        ->value('costodiario');
    }
}
