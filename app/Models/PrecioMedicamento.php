<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrecioMedicamento extends Model
{
    use HasFactory;
    protected $fillable = [
        'CPERIODO',
        'CCODUE',
        'medicamento_id',
        'TIPOCOMP',
        'PREADJ', //PRECIO ADQUISICION
        'PREOPE', //PRECIO DE OPERACION
        'CODIGO_SIGA',
    ];
    /**
     * Get the medicamento that owns the PrecioMedicamento
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function medicamento(): BelongsTo
    {
        return $this->belongsTo(Medicamento::class, 'medicamento_id');
    }
}
