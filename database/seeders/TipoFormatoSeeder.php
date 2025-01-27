<?php

namespace Database\Seeders;

use App\Models\TipoFormato;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoFormatoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
        $tipoformatos = [
            ['nombre' => 'Fese'],
            ['nombre' => 'Inscripción'],
            ['nombre' => 'Afiliación'],
            ['nombre' => 'Filiación'],
            ['nombre' => 'Atención'],
            ['nombre' => 'Actualización'],
            ['nombre' => 'Anulación'],
            ['nombre' => 'Afiliación AUS'],
            ['nombre' => 'Inscripcion AUS'],
            ['nombre' => 'Convenio'],
            ['nombre' => 'Escolar Piloto'],
            ['nombre' => 'Afiliacion Temporal'],
            ['nombre' => 'Escolar Con Otro Seguro'],
            ['nombre' => 'Escolar No Minedu'],
        ];
        foreach($tipoformatos as $row){
            TipoFormato::firstOrCreate($row);
        }

    }
}
