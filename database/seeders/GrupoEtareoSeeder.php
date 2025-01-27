<?php

namespace Database\Seeders;

use App\Models\GrupoEtareo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GrupoEtareoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grupos = [
            [
                'descripcion' => '0-4 Años',
                'edad_minima' => '0',
                'edad_maxima' => '4',
                'esGestante' => 'N',
            ],
            [
                'descripcion' => '5-19 Años',
                'edad_minima' => '5',
                'edad_maxima' => '19',
                'esGestante' => 'N',
            ],
            [
                'descripcion' => '20-59 Años',
                'edad_minima' => '20',
                'edad_maxima' => '59',
                'esGestante' => 'N',
            ],
            [
                'descripcion' => '60-120 Años',
                'edad_minima' => '60',
                'edad_maxima' => '120',
                'esGestante' => 'N',
            ],
            [
                'descripcion' => '09-60 Años',
                'edad_minima' => '9',
                'edad_maxima' => '60',
                'esGestante' => 'S',
            ],
        ];
        foreach($grupos as $row){
            GrupoEtareo::firstOrCreate($row);
        }



        
    }
}
