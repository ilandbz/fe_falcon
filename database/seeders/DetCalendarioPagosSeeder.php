<?php

namespace Database\Seeders;

use App\Models\Desembolso;
use App\Models\DetCalendarioPagos;
use App\Models\KardexCredito;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetCalendarioPagosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('archivos/detcalendario.csv'), 'r');
        $nro_registros = -1;
        while (($datum = fgetcsv($csvFile, 555, ',')) !== false)
        {
            $nro_registros +=1;
        }
        fclose($csvFile);
        $this->command->getOutput()->writeln('Iniciando Importación de detcalendariopagoscredito...');
        $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        $this->command->getOutput()->writeln("Importando Datos de detcalendariopagoscredito... ");

        $progressBar->start();
        $csvFile2 = fopen(base_path('archivos/detcalendario.csv'),"r");
        $header = fgetcsv($csvFile2, 2000, ",", '"');
        while(($fila  = fgetcsv($csvFile2,2000,",")) !== false) {
            if (count($fila) == count($header)) {
                $fila = array_map('trim', $fila);
                $data = array_combine($header, $fila);
                extract($data);
            }
            $desembolso = Desembolso::where('credito_id', $idsolicitud)->first();
            if($desembolso){
                $kardex = DetCalendarioPagos::firstOrCreate(
                    [
                        'credito_id' => $idsolicitud,
                        'nrocuota'        => $nrocuota,
                    ],
                    [
                        'fecha_prog'         => $fecha_prog,
                        'nombredia'   => $nombredia,
                        'cuota'       => $cuota,
                        'saldo'     => $saldo
                    ]
                );                     
            }
              
            //usleep(1000);
            $progressBar->advance();
        }

        fclose($csvFile2);
        $progressBar->finish();
        $this->command->getOutput()->writeln("");
        $this->command->getOutput()->writeln("Importación Finalizada");
    }
}
