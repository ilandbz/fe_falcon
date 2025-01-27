<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    use HasFactory;
    public function procedimientos()
    {
        return $this->belongsToMany(Procedimiento::class, 'insumo_procedimiento');
    }
}
