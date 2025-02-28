<?php

namespace Database\Seeders;

use App\Models\SeguroDesgravamen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
class SeguroDesgravamenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('archivos/seguro.csv'), 'r');
        $nro_registros = -1;
        while (($datum = fgetcsv($csvFile, 555, ',')) !== false)
        {
            $nro_registros +=1;
        }
        fclose($csvFile);
        $this->command->getOutput()->writeln('Iniciando Importación de Seguro...');
        $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        $this->command->getOutput()->writeln("Importando Datos de Seguro... ");

        $progressBar->start();
        $csvFile2 = fopen(base_path('archivos/seguro.csv'),"r");
        $header = fgetcsv($csvFile2, 2000, ",", '"');


        while(($fila  = fgetcsv($csvFile2,2000,",")) !== false) {
            if (count($fila) == count($header)) {
                $fila = array_map('trim', $fila);
                $data = array_combine($header, $fila);
                extract($data);
            }
            $cliente = SeguroDesgravamen::firstOrCreate(
                ['credito_id' => $idsolicitud],
                [
                    'monto' => $monto,
                    'fecha_reg' => $fechareg,
                    'hora_reg' => '00:00:00',
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
