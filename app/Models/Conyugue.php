<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conyugue extends Model
{
    protected $fillable = [
        'primer_persona_id',
        'segunda_persona_id',
    ];
}
