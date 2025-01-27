<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesional extends Model
{
    use HasFactory;
    protected $fillable = [
        'nro_documento',
        'ape_paterno',
        'ape_materno',
        'primer_nombre',
        'otros_nombres',
        'sexo_id',
        'tipopersonal_salud',
        'colegiatura',
    ];
    public function atencions()
    {
        return $this->hasMany(Atencion::class, 'profesional_id');
    }
}
