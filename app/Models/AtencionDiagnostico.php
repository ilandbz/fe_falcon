<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AtencionDiagnostico extends Model
{
    use HasFactory;
    protected $fillable = ['codigo',
    'atencion_id', 
    'diagnostico_id', 'tipo_ingreso_egresos_id',
    'tipo_diagnostico_id'];


    public function atencion(): BelongsTo
    {
        return $this->belongsTo(Atencion::class, 'atencion_id');
    }
    /**
     * Get the diagnostico that owns the AtencionDiagnostico
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function diagnostico(): BelongsTo
    {
        return $this->belongsTo(Diagnostico::class, 'diagnostico_id');
    }
}
