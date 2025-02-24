<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeguroDesgravamen extends Model
{
    protected $primaryKey = 'credito_id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'credito_id',
        'monto',
        'fecha_reg',
        'hora_reg',
    ];

    // Relación con el modelo Credito
    public function credito()
    {
        return $this->belongsTo(Credito::class);
    }
}
