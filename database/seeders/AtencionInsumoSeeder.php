<?php

namespace Database\Seeders;

use App\Models\AtencionDiagnostico;
use App\Models\AtencionInsumo;
use App\Models\Insumo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AtencionInsumoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $csvFile = fopen(base_path('archivos/atencion_insumos.csv'), 'r');
        // $nro_registros = -1;
        // while (($datum = fgetcsv($csvFile, 1000, ',')) !== false){
        //     $nro_registros +=1;
        // }
        // fclose($csvFile);
        $this->command->getOutput()->writeln('Iniciando Importación de atencion_insumos...');
        //$this->command->getOutput()->writeln('Cantidad de registros: '.$nro_registros);
        $csvFile2 = fopen(base_path('archivos/atencion_insumos.csv'), 'r');
        $this->command->getOutput()->writeln("Importando Datos... ");
        //$progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        //$progressBar->start();
        $firstLine = 1;
        while(($fila = fgetcsv($csvFile2, 2000, ",")) !== false) {
                    
            if($firstLine>=2)
            {



                $this->command->getOutput()->writeln('indice : '.$firstLine);    
                $registro = explode(";",(string)$fila[0]);
                AtencionInsumo::firstOrCreate([
                    'codigo'    => str_replace('"', '', $registro[0]),
                    'atencion_diagnostico_id' => AtencionDiagnostico::where('codigo', str_replace('"', '', $registro[1]))->value('id'),
                    'insumo_id' => Insumo::where('ins_CodIns', str_replace('"', '', $registro[2]))->value('id'),
                    'cantidad_preescrita' => str_replace('"', '', $registro[3]),
                    'cantidad_entregada' => str_replace('"', '', $registro[4]),
                    'precio_unitario' => str_replace('"', '', $registro[5]),
                ]);

                ////usleep(1000);
                //$progressBar->advance();
            }
            $firstLine += 1;
        }
    }
}
