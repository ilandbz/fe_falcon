<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KardexCredito extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'credito_id',
        'nro',
        'fecha',
        'hora',
        'montopagado',
        'user_id',
        'mediopago',
    ];

    public function desembolso()
    {
        return $this->belongsTo(Desembolso::class, 'credito_id');
    }
    public function credito()
    {
        return $this->belongsTo(Credito::class, 'credito_id');
    }    
    public static function getNextNro($credito_id)
    {
        $ultimoNro = self::where('credito_id', $credito_id)->max('nro');
        return $ultimoNro ? $ultimoNro + 1 : 1;
    }
}
