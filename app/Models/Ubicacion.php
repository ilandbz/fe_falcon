<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ubicacion extends Model
{
    protected $fillable = [
        'id',
        'tipo',
        'ubigeo',
        'tipovia',
        'nombrevia',
        'nro',
        'interior',
        'mz',
        'lote',
        'tipozona',
        'nombrezona',
        'referencia',
        'latitud_longitud',
    ];
    protected $appends = ['direccion'];
    public function direccion(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => 
                "{$attributes['tipovia']} {$attributes['nombrevia']} Nro: {$attributes['nro']} Int. " .
                ($attributes['interior'] ?? '') . " Mz: {$attributes['mz']} Lt: {$attributes['lote']} " .
                "{$attributes['tipozona']} {$attributes['nombrezona']} Ref: " . ($attributes['referencia'] ?? ''),
        );
    }
    public function distrito(): BelongsTo
    {
        return $this->belongsTo(Distrito::class, 'ubigeo', 'ubigeo');
    }




}
