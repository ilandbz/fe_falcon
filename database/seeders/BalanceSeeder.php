<?php

namespace Database\Seeders;

use App\Models\Balance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('archivos/balance.csv'), 'r');
        $nro_registros = -1;
        while (($datum = fgetcsv($csvFile, 555, ',')) !== false)
        {
            $nro_registros +=1;
        }
        fclose($csvFile);
        $this->command->getOutput()->writeln('Iniciando Importación de Balance...');
        $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        $this->command->getOutput()->writeln("Importando Datos de Balance... ");

        $progressBar->start();
        $csvFile2 = fopen(base_path('archivos/balance.csv'),"r");
        $header = fgetcsv($csvFile2, 2000, ",", '"');


        while(($fila  = fgetcsv($csvFile2,2000,",")) !== false) {
            if (count($fila) == count($header)) {
                $fila = array_map('trim', $fila);
                $data = array_combine($header, $fila);
                extract($data);
            }
            $registro = Balance::firstOrCreate(
                ['credito_id' => $idsolicitud],
                [
                    'total_activo' => $total_activo,
                    'total_pasivo' => $total_pasivo,
                    'patrimonio' => $patrimonio,
                    'fecha' => $fecha,
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
