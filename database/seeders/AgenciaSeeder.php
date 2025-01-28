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
            ['nombre' => 'Huánuco'],
            ['nombre' => 'Tingo Maria'],
            ['nombre' => 'Huánuco 2'],
            ['nombre' => 'Panao'],
        ];

        foreach($agencias as $grupo){
            Agencia::firstorCreate($grupo);            
        }
    }
}
