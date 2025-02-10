<?php

namespace Database\Seeders;

use App\Models\TipoEntidad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoEntidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipoentidades = [
            'CAJA',
            'BANCO',
        ];
        foreach ($tipoentidades as $entidad) {
            TipoEntidad::create([
                'nombre' => $entidad,
            ]);
        }
    }
}
