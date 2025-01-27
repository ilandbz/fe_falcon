<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrecioInsumo extends Model
{
    use HasFactory;

    /**
     * Get the insumo that owns the PrecioInsumo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function insumo(): BelongsTo
    {
        return $this->belongsTo(Insumo::class, 'insumo_id');
    }
}
