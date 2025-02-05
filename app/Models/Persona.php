<?php

namespace App\Models;

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
}
