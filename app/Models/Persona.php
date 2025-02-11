<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable = [
        'dni',
        'ape_pat',
        'ape_mat',
        'primernombre',
        'otrosnombres',
        'fecha_nac',
        'ubigeo_nac',
        'genero',
        'celular',
        'email',
        'ruc',
        'estado_civil',
        'profesion',
        'nacionalidad',
        'grado_instr',
        'tipo_trabajador',
        'ocupacion',
        'institucion_lab',
        'ubicacion_domicilio_id',
    ];

    protected $appends = ['apenom'];

    public function apenom(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => "{$attributes['ape_pat']} {$attributes['ape_mat']} {$attributes['primernombre']} " . ($attributes['otrosnombres'] ?? ''),
        );
    }
}