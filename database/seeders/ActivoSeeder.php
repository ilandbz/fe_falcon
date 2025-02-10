<?php

namespace Database\Seeders;

use App\Models\Activo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activos = [
            'CAJA',
            'BANCOS',
            'CUENTAS POR COBRAR',
            'INVENTARIOS',
            'MUEBLES, MAQUINARIA Y EQUIPO',
            'OTROS ACTIVOS',
            'DEPRECIACIÓN, AMORTIZACIÓN Y AGOTAMIENTO ACUMULADOS',
        ];
        foreach ($activos as $activo) {
            Activo::create([
                'nombre' => $activo,
            ]);
        }
    }
}
