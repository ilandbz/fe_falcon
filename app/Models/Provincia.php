<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    public function distritos()
    {
        return $this->hasMany(Distrito::class, 'provincia_id');
    }
}
