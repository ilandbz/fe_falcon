<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feriado extends Model
{
    protected $fillable =['id','fecha','descripcion'];
    public $timestamps = false;


    
}
