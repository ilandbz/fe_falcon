<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Negocio extends Model
{
    protected $fillable = [
        'cliente_id',
        'razonsocial',
        'ruc',
        'tel_cel',
        'tipo_actividad_id',
        'descripcion',
        'inicioactividad',
        'ubicacion_id',
    ];
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Negocio::class, 'cliente_id');
    }
    public function ubicacion(): BelongsTo
    {
        return $this->belongsTo(Ubicacion::class, 'ubicacion_id');
    }
}
