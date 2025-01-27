<?php

namespace Database\Seeders;

use App\Models\DestinoAsegurado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DestinoAseguradoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destinos = [
            ['codigo' => '0', 'descripcion' => 'Sin Destino'],
            ['codigo' => '1', 'descripcion' => 'Alta'],
            ['codigo' => '2', 'descripcion' => 'Citado'],
            ['codigo' => '3', 'descripcion' => 'Ref. Emergencia'],
            ['codigo' => '4', 'descripcion' => 'Ref. Consulta Externa'],
            ['codigo' => '5', 'descripcion' => 'Ref. Apoyo al Diagnóstico'],
            ['codigo' => '6', 'descripcion' => 'Contrarreferido'],
            ['codigo' => '7', 'descripcion' => 'Fallecido'],
            ['codigo' => '8', 'descripcion' => 'Hospitalizado'],
            ['codigo' => '9', 'descripcion' => 'Corte Administrativo'],
        ];
        foreach($destinos as $row){
            DestinoAsegurado::firstOrCreate($row);
        }

    }
}
