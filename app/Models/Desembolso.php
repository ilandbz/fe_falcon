<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Desembolso extends Model
{
    protected $primaryKey = 'credito_id';
    public $incrementing = false;
    protected $fillable = [
        'credito_id',
        'fecha',
        'hora',
        'user_id',
        'descontado',
        'totalentregado'
    ];
    public function credito(): BelongsTo
    {
        return $this->belongsTo(Credito::class, 'credito_id');
    }
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
