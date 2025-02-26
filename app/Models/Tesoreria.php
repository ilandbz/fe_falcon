<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tesoreria extends Model
{
    protected $fillable = [
        'tipo_entidad_id',
        'agencia_id',
        'nro',
        'fecha',
        'hora',
        'tipo',
        'user_id',
        'monto',
        'saldo',
        'descripcion',
    ];

    public function tipoEntidad()
    {
        return $this->belongsTo(TipoEntidad::class);
    }

    public function agencia()
    {
        return $this->belongsTo(Agencia::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
