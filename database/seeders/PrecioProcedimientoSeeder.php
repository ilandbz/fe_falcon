<?php

namespace Database\Seeders;

use App\Models\PrecioProcedimiento;
use App\Models\Procedimiento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrecioProcedimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $csvFile = fopen(base_path('archivos/tarifario/procedimientos.csv'), 'r');
        // $nro_registros = -1;
        // while (($datum = fgetcsv($csvFile, 1000, '}')) !== false){
        //     $nro_registros +=1;
        // }
        // fclose($csvFile);
        $this->command->getOutput()->writeln('Iniciando Importación de procedimientos...');
        // $this->command->getOutput()->writeln('Cantidad de registros: '.$nro_registros);
        $csvFile2 = fopen(base_path('archivos/tarifario/procedimientos.csv'), 'r');
        $this->command->getOutput()->writeln("Importando Datos... ");
        // $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        // $progressBar->start();
        $firstLine = 1;
        while(($fila = fgetcsv($csvFile2, 2000, "}")) !== false) {
            if($firstLine>=7)
            {
                $registro = explode(";",(string)$fila[0]);
                $coprocedimiento = Procedimiento::where('PRCD_V_CODPROCEDIMIENTO', str_replace(['"', ' '], '', $registro[1]))->value('id');
                $precioprocedimiento = PrecioProcedimiento::where([
                    'procedimiento_id' => $coprocedimiento
                ])->first();
                if (!$precioprocedimiento && !is_null($coprocedimiento)) {
                    PrecioProcedimiento::firstOrCreate([
                        'procedimiento_id'        => $coprocedimiento,
                        'nivel2'      => str_replace(['"', ' '], '', $registro[3]),
                        'nivel3'      => str_replace(['"', ' '], '', $registro[4]),
                    ]);
                    $this->command->getOutput()->writeln('indice : '.$firstLine,'  '.$registro[0]);
                    //$progressBar->advance();
                }

                if($registro[0]==''){
                    break;
                }

            }
            $firstLine+=1;
        }
    }
}
