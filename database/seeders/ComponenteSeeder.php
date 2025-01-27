<?php

namespace Database\Seeders;

use App\Models\Componente;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComponenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $componentes = [
            ['nombre' => 'Subsidiado'],
            ['nombre' => 'SemiSubsidiado'],
            ['nombre' => 'Todos'],
            ['nombre' => 'No Asegurado'],
            ['nombre' => 'Contributivo'],
        ];
        foreach($componentes as $row){
            Componente::firstOrCreate($row);
        }



    }
}
