<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioTrans extends Model
{
    use HasFactory;
    protected $fillable = [
        'codigo',
        'ape_paterno',
        'ape_materno',
        'primer_nombre',
        'segundo_nombre',
        'user_login',
    ];
    public function atencions()
    {
        return $this->hasMany(Atencion::class, 'usuario_tran_id');
    }
}
