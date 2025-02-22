<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cliente extends Model
{
    protected $fillable = [
        'id',
        'agencia_id',
        'usuario_id',
        'persona_id',
        'dniaval',
        'estado',
        'fecha_reg',
        'hora_reg',
    ];
    public function persona(): BelongsTo
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }
    public function agencia(): BelongsTo
    {
        return $this->belongsTo(Agencia::class, 'agencia_id');
    }
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }    

    public function negocio(): HasOne
    {
        return $this->hasOne(Negocio::class, 'cliente_id')->latest();
    }   

    public function negocios(): HasMany
    {
        return $this->HasMany(Negocio::class, 'cliente_id');
    }

}
