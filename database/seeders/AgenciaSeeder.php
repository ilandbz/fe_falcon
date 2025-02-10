<?php

namespace Database\Seeders;

use App\Models\Agencia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agencias = [
            ['nombre' => 'HUANUCO'],
            ['nombre' => 'TINGO MARIA'],
            ['nombre' => 'HUANUCO2'],
            ['nombre' => 'PANAO'],
        ];

        foreach($agencias as $grupo){
            Agencia::firstorCreate($grupo);            
        }
    }
}
