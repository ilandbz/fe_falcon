<?php

namespace Database\Seeders;

use App\Models\Periodo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeriodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('archivos/periodos.csv'), 'r');
        $nro_registros = -1;
        while (($datum = fgetcsv($csvFile, 1000, '}')) !== false){
            $nro_registros +=1;
        }
        fclose($csvFile);
        $this->command->getOutput()->writeln('Iniciando Importación de periodos...');
        $this->command->getOutput()->writeln('Cantidad de registros: '.$nro_registros);
        $csvFile2 = fopen(base_path('archivos/periodos.csv'), 'r');
        $this->command->getOutput()->writeln("Importando Datos... ");
        $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        $progressBar->start();
        $firstLine = true;
        while(($fila = fgetcsv($csvFile2, 2000, "}")) !== false) {
            if(!$firstLine)
            {
                $registro = explode(";",(string)$fila[0]);
                $anho = str_replace('"', '', $registro[0]);
                $mes = str_replace('"', '', $registro[1]);
                Periodo::firstOrCreate([
                    'codigo'             => $anho.$mes,
                    'anho_periodo'       => $anho,
                    'mes'                => $mes,
                    'per_FecIniAfi'      => str_replace('"', '', $registro[2])=='' ? NULL : str_replace('"', '', $registro[2]),
                    'per_FecIniReg'      => str_replace('"', '', $registro[3])=='' ? NULL : str_replace('"', '', $registro[3]),
                    'per_FecMaxReg'      => str_replace('"', '', $registro[4])=='' ? NULL : str_replace('"', '', $registro[4]),
                ]);
                //usleep(1000);
                $progressBar->advance();
            }
            $firstLine = false;
        }
    }
}
