<?php

namespace Database\Seeders;

use App\Models\Credito;
use App\Models\Desembolso;
use App\Models\KardexCredito;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
class KardexCreditoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('archivos/kardex.csv'), 'r');
        $nro_registros = -1;
        while (($datum = fgetcsv($csvFile, 555, ',')) !== false)
        {
            $nro_registros +=1;
        }
        fclose($csvFile);
        $this->command->getOutput()->writeln('Iniciando Importación de Kardex...');
        $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        $this->command->getOutput()->writeln("Importando Datos de Kardex... ");

        $progressBar->start();
        $csvFile2 = fopen(base_path('archivos/kardex.csv'),"r");
        $header = fgetcsv($csvFile2, 2000, ",", '"');


        while(($fila  = fgetcsv($csvFile2,2000,",")) !== false) {
            if (count($fila) == count($header)) {
                $fila = array_map('trim', $fila);
                $data = array_combine($header, $fila);
                extract($data);
            }
            $desembolso = Desembolso::where('credito_id', $idsolicitud)->first();
            
            if($desembolso){
                if ($fecha_hora_reg == '0000-00-00 00:00:00' || empty($fecha_hora_reg)) {
                    // Si la fecha es inválida, usa '2000-01-01 00:00:00'
                    $fecha = '2000-01-01';
                    $hora = '00:00:00';
                } else {
                    // Si la fecha es válida, conviértela correctamente
                    $fechahora = Carbon::parse($fecha_hora_reg);
                    $fecha = $fechahora->toDateString();
                    $hora = $fechahora->toTimeString();
                }
                $kardex = KardexCredito::firstOrCreate(
                    [
                        'credito_id' => $idsolicitud,
                        'nro'        => $nro,
                    ],
                    [
                        'fecha'         => $fecha,
                        'hora'          =>  $hora,
                        'montopagado'   => $montopagado,
                        'user_id'       => User::where('name', $idusuario)->value('id'),
                        'mediopago'     => $mediopago
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
