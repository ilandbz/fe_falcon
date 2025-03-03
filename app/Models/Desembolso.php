<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Desembolso extends Model
{
    protected $appends = ['Totalpagado', 'Saldo'];
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
    public function kardex(): HasMany
    {
        return $this->hasMany(KardexCredito::class, 'credito_id');
    }
    public function getTotalpagadoAttribute()
    {
        return $this->kardex()->sum('montopagado');
    }
    public function getSaldoAttribute()
    {
        return 0;
        return optional($this->credito)->total - $this->kardex()->sum('montopagado');
    }
    public function detCalendarioPagos(): HasMany
    {
        return $this->hasMany(DetCalendarioPagos::class, 'credito_id');
    }


}
