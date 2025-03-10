<?php

namespace Database\Seeders;

use App\Models\Desembolso;
use App\Models\PagoCredito;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
class PagoCreditoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('archivos/pagos.csv'), 'r');
        $nro_registros = -1;
        while (($datum = fgetcsv($csvFile, 555, ',')) !== false)
        {
            $nro_registros +=1;
        }
        fclose($csvFile);
        $this->command->getOutput()->writeln('Iniciando Importación de pagos...');
        $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        $this->command->getOutput()->writeln("Importando Datos de pagos... ");

        $progressBar->start();
        $csvFile2 = fopen(base_path('archivos/pagos.csv'),"r");
        $header = fgetcsv($csvFile2, 2000, ",", '"');


        while(($fila  = fgetcsv($csvFile2,2000,",")) !== false) {
            if (count($fila) == count($header)) {
                $fila = array_map('trim', $fila);
                $data = array_combine($header, $fila);
                extract($data);
            }
            $desembolso = Desembolso::where('credito_id', $idsolicitud)->first();
            
            if($desembolso){
                if ($fecha_reg == '0000-00-00' || empty($fecha_reg)) {
                    $fecha = '2000-01-01';
                } else {
                    // Si la fecha es válida, conviértela correctamente
                    $fecha = Carbon::parse($fecha_reg);
                    $fecha = $fecha->toDateString();
                }
                $kardex = PagoCredito::firstOrCreate(
                    [
                        'credito_id' => $idsolicitud,
                        'nro'        => $nrocuota,
                    ],
                    [
                        'fecha'         => $fecha,
                        'montopagado'   => $montopagado,
                        'user_id'       => User::where('name', $codusuario)->value('id'),
                        'mediopago'     => $mediopago,
                        'moradias'      => $moradias,
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
