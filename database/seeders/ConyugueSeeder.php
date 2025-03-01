<?php

namespace Database\Seeders;

use App\Models\Conyugue;
use App\Models\Persona;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConyugueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('archivos/persona.csv'), 'r');
        $nro_registros = -1;
        while (($datum = fgetcsv($csvFile, 555, ',')) !== false)
        {
            $nro_registros +=1;
        }
        fclose($csvFile);
        $this->command->getOutput()->writeln('Iniciando Importación de Conyugues...');
        $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        $this->command->getOutput()->writeln("Importando Datos de Conyugues... ");

        $progressBar->start();
        $firstLine = true;

        $csvFile2 = fopen(base_path('archivos/persona.csv'),"r");
        $header = fgetcsv($csvFile2, 2000, ",", '"');


        while(($fila  = fgetcsv($csvFile2,2000,",")) !== false) {
            if (count($fila) == count($header)) {
                $fila = array_map('trim', $fila);
                $data = array_combine($header, $fila);
                extract($data);
            }
            $conyugue = Persona::where('dni', $dniconyugue)->first();
            if($conyugue){
                //$this->command->getOutput()->writeln($dni);
                Conyugue::firstOrCreate([
                    'primer_persona_id' => Persona::where('dni', $dni)->first()->id,
                    'segunda_persona_id' => $conyugue->id,
                ]);
            }

            $progressBar->advance();
        }


    }
}
