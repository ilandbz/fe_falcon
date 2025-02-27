<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    protected $fillable = [
        'credito_id',
        'usuario_id',
        'resultado',
        'fechahora',
        'comentario',
        'tasainteres',
    ];
}
