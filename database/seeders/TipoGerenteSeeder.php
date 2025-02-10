<?php

namespace Database\Seeders;

use App\Models\TipoActividad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoGerenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipoactividades = [
            'ZONAL',
            'AGENCIA',
        ];
        foreach ($tipoactividades as $actividad) {
            TipoActividad::create([
                'nombre' => $actividad,
            ]);
        }
    }
}
