<?php

namespace Database\Seeders;

use App\Models\GrupoRiesgo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GrupoRiesgoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grupos = [
            ['codigo' => '00', 'descripcion' => 'No tiene'],
            ['codigo' => '01', 'descripcion' => 'Trabajadores de Salud'],
            ['codigo' => '02', 'descripcion' => 'Trabajadores Sexuales'],
            ['codigo' => '03', 'descripcion' => 'HSH'],
            ['codigo' => '04', 'descripcion' => 'Privados de Libertad'],
            ['codigo' => '05', 'descripcion' => 'FF.AA.'],
            ['codigo' => '06', 'descripcion' => 'Policia Nacional'],
            ['codigo' => '07', 'descripcion' => 'Estudiantes de Salud'],
            ['codigo' => '08', 'descripcion' => 'Politransfundidos'],
            ['codigo' => '09', 'descripcion' => 'Drogo Dependiente'],
        ];
        foreach($grupos as $row){
            GrupoRiesgo::firstOrCreate($row);
        }
    }
}
