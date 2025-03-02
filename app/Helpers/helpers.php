<?php

use App\Models\Feriado;
use Carbon\Carbon;

if (!function_exists('esFeriado')) {
    function esFeriado($fecha)
    {
        $fechaFormateada = Carbon::parse($fecha)->format('Y-m-d');
        return Feriado::where('fecha', $fechaFormateada)->exists();
    }
}


?>
