<?php

namespace Database\Seeders;

use App\Models\DetVentaPG;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetVentaPGSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('archivos/propuestacred.csv'), 'r');
        $nro_registros = -1;
        while (($datum = fgetcsv($csvFile, 555, ',')) !== false)
        {
            $nro_registros +=1;
        }
        fclose($csvFile);
        $this->command->getOutput()->writeln('Iniciando Importación de Detalles de Venta...');
        $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        $this->command->getOutput()->writeln("Importando Datos de Detalles de Venta... ");

        $progressBar->start();
        $csvFile2 = fopen(base_path('archivos/propuestacred.csv'),"r");
        $header = fgetcsv($csvFile2, 2000, ",", '"');


        while(($fila  = fgetcsv($csvFile2,2000,",")) !== false) {
            if (count($fila) == count($header)) {
                $fila = array_map('trim', $fila);
                $data = array_combine($header, $fila);
                extract($data);
            }
            $registro = DetVentaPG::firstOrCreate(
                ['credito_id' => $idsolicitud],
                [
                    'unidad_familiar' => $unidad_familiar,
                    'experiencia_cred' => $experiencia_cred,
                    'destino_prest' => $destino_prest,
                    'referencias' => $referencias,
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
