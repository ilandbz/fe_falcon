<?php

namespace Database\Seeders;

use App\Models\AnalisisCualitativo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnalisisCualitativoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('archivos/analisis_cual.csv'), 'r');
        $nro_registros = -1;
        while (($datum = fgetcsv($csvFile, 555, ',')) !== false)
        {
            $nro_registros +=1;
        }
        fclose($csvFile);
        $this->command->getOutput()->writeln('Iniciando Importación de Analisis Cualitativos...');
        $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        $this->command->getOutput()->writeln("Importando Datos de Analisis Cualitativos... ");

        $progressBar->start();
        $csvFile2 = fopen(base_path('archivos/analisis_cual.csv'),"r");
        $header = fgetcsv($csvFile2, 2000, ",", '"');


        while(($fila  = fgetcsv($csvFile2,2000,",")) !== false) {
            if (count($fila) == count($header)) {
                $fila = array_map('trim', $fila);
                $data = array_combine($header, $fila);
                extract($data);
            }
            $registro = AnalisisCualitativo::firstOrCreate(
                ['credito_id' => $idsolicitud],
                [
                    'tipogarantia' => $tipogarantia,
                    'cargafamiliar' => $cargafamiliar,
                    'riesgoedadmax' => $riesgoedadmax,
                    'antecedentescred' => $antecedentescred,
                    'recorpagoult' => $recorpagoult,
                    'niveldesarr' => $niveldesarr,
                    'tiempo_neg' => $tiempo_neg,
                    'control_integre' => $control_ingegre,
                    'vent_totdec' => $vent_totdec,
                    'compsubsector' => $compsubsector,
                    'totunidfamiliar' => $totunidfamiliar,
                    'totunidempresa' => $totunidempresa,
                    'total' => $total
                ]
            );                   
            //usleep(1000);
            $progressBar->advance();
        }

        fclose($csvFile2);
        $progressBar->finish();
        $this->command->getOutput()->writeln("");
        $this->command->getOutput()->writeln("Importación Finalizada");
    }
}
