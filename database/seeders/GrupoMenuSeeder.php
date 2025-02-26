<?php

namespace Database\Seeders;

use App\Models\GrupoMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GrupoMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grupos = [
            ['titulo' => 'Creditos'],
            ['titulo' => 'Junta'],
            ['titulo' => 'Configuracion'],
            ['titulo' => 'Caja'],
            ['titulo' => 'Reportes'],
            ['titulo' => 'Comprobantes'],
            ['titulo' => 'Recursos Humanos'],
            ['titulo' => 'Clientes'],
            ['titulo' => 'Gerencia Zonal'],
        ];

        foreach($grupos as $grupo){
            GrupoMenu::firstorCreate($grupo);            
        }
    }
}
