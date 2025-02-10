<?php

namespace Database\Seeders;

use App\Models\TipoActividad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoActividadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipoactividades = [
            'COMERCIO',
            'SERVICIO',
            'PRODUCCION',
        ];
        foreach ($tipoactividades as $actividad) {
            TipoActividad::create([
                'nombre' => $actividad,
            ]);
        }
    }
}
