<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Menu extends Model
{
    protected $fillable =['id','nombre','slug','icono','padre_id','orden', 'grupo_id'];

    public $timestamps = false;
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function padre()
    {
        return $this->belongsTo(Menu::class);
    }


    public function menus()
    {
        return $this->hasMany(Menu::class,'padre_id')->orderBy('orden', 'asc');
    }
    public static function obtenerPadres()
    {
        return Menu::select('id','nombre')->whereNull('padre_id')
                    ->orderby('orden','asc')->get();
    }

    public static function maximoPadreId()
    {
        $maxOrden = Menu::whereNull('padre_id')->max('orden');

        return ($maxOrden == null && $maxOrden == '') ? 0 : ($maxOrden + 1);
    }

    public static function maximoHijoId($padre_id)
    {
        $maxOrden = Menu::where('padre_id',$padre_id)->max('orden');

        return ($maxOrden === null || $maxOrden == '') ? 0 : ($maxOrden + 1);
    }

    /**
     * Get the grupo that owns the Menu
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function grupo(): BelongsTo
    {
        return $this->belongsTo(GrupoMenu::class, 'grupo_id');
    }
}
