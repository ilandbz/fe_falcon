<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedimiento extends Model
{
    use HasFactory;
    public function insumos()
    {
        //return $this->belongsToMany(Insumo::class, 'insumo_procedimiento');
        return $this->belongsToMany(Insumo::class, 'insumo_procedimiento', 'procedimiento_id', 'insumo_id')
        ->withPivot('presentacion', 'cantidad');
    }


}
