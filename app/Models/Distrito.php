<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'provincia_id');
    }
}
