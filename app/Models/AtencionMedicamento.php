<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtencionMedicamento extends Model
{
    use HasFactory;
    protected $fillable = [
        'codigo',
        'atencion_diagnostico_id',
        'medicamento_id',
        'cantidad_preescrita',
        'cantidad_entregada',
        'precio_unitario',
        'subtotal',
    ];
}
