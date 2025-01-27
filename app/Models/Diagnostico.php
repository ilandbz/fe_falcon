<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Diagnostico extends Model
{
    use HasFactory;
    /**
     * Get the atencion that owns the Diagnostico
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

}
