<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrecioServicio extends Model
{
    use HasFactory;
    /**
     * Get the servicio that owns the PrecioServicio
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function servicio(): BelongsTo
    {
        return $this->belongsTo(User::class, 'servicio_id');
    }
}
