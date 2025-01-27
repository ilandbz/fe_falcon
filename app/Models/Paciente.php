<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paciente extends Model
{
    use HasFactory;
    protected $fillable = [
        'tipo_documento_id',
        'nro_documento',
        'ape_paterno',
        'ape_materno',
        'primer_nombre',
        'otros_nombres',
        'fecha_nacimiento',
        'sexo_id',
    ];

    /**
     * Get the tipo_documento that owns the Paciente
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipo_documento(): BelongsTo
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id');
    }
    /**
     * Get the sexo that owns the Paciente
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sexo(): BelongsTo
    {
        return $this->belongsTo(Sexo::class, 'sexo_id');
    }



}
