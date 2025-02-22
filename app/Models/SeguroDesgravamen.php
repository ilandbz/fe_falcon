<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeguroDesgravamen extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'credito_id',
        'usuario_id',
        'resultado',
        'fechahora',
        'comentario',
        'tasainteres'
    ];
}
