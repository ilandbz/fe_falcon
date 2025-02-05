<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    public function mostrarPorDni(Request $request)
    {
        $menu = Persona::where('dni', $request->dni)->first();
        return $menu;
    }
}
