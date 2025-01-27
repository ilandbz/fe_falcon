<?php

namespace Database\Seeders;

use App\Models\Sexo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SexoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sexos = [
            [
                'codigo'            => 0,
                'descripcion'   => 'Femenino',
            ],
            [
                'codigo'            => 1,
                'descripcion'   => 'Masculino',
            ],
            [
                'codigo'            => 2,
                'descripcion'   => 'Ambos',
            ],            
        ];
        foreach($sexos as $sexo){
            Sexo::firstOrCreate($sexo);
        }
        
    }
}
