<?php

namespace Database\Seeders;

use App\Models\TipoDiagnostico;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoDiagnosticoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $componentes = [
            ['codigo' => 'C', 'descripcion' => 'CONFIRMADO'],
            ['codigo' => 'D', 'descripcion' => 'DEFINITIVO'],
            ['codigo' => 'P', 'descripcion' => 'PRESUNTIVO'],
            ['codigo' => 'R', 'descripcion' => 'REPETIDO'],
        ];
        foreach($componentes as $row){
            TipoDiagnostico::firstOrCreate($row);
        }
    }
}
