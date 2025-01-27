<?php

namespace Database\Seeders;

use App\Models\Diagnostico;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiagnosticoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('archivos/diagnosticos.csv'), 'r');
        $nro_registros = -1;
        while (($datum = fgetcsv($csvFile, 1000, '}')) !== false){
            $nro_registros +=1;
        }
        fclose($csvFile);
        $this->command->getOutput()->writeln('Iniciando Importación de diagnosticos...');
        $this->command->getOutput()->writeln('Cantidad de registros: '.$nro_registros);
        $csvFile2 = fopen(base_path('archivos/diagnosticos.csv'), 'r');
        $this->command->getOutput()->writeln("Importando Datos... ");
        $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        $progressBar->start();
        $firstLine = true;
        while(($fila = fgetcsv($csvFile2, 2000, "|")) !== false) {
            if(!$firstLine)
            {
                $registro = explode(";",(string)$fila[0]);

                $codigo = $registro[0];
                $reg = Diagnostico::where('codigo',$codigo)->first();
                if(!$reg){
                    Diagnostico::firstOrCreate([
                        'codigo'        => str_replace('"', '', $codigo),
                        'descripcion'   => str_replace('"', '', $registro[1])
                    ]);                    
                }
                //usleep(1000);
                $progressBar->advance();
            }
            $firstLine = false;
        }
    }
}
