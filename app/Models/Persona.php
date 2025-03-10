<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'conyugue',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $appends = ['apenom'];



    public function ubicacion(): BelongsTo
    {
        return $this->belongsTo(Ubicacion::class, 'ubicacion_domicilio_id');
    }

    public function apenom(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => "{$attributes['ape_pat']} {$attributes['ape_mat']} {$attributes['primernombre']} " . ($attributes['otrosnombres'] ?? ''),
        );
    }

    public function distrito(): BelongsTo
    {
        return $this->belongsTo(Distrito::class, 'ubigeo_nac', 'ubigeo');
    }

    public function getEdadAttribute()
    {
        return Carbon::parse($this->fecha_nac)->age;
    }


    public function conyugePersona() : BelongsTo
    {
        return $this->belongsTo(Persona::class, 'conyugue', 'id');
    }

}