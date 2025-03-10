<?php

namespace Database\Seeders;

use App\Models\Desembolso;
use App\Models\PagoMora;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PagoMoraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('archivos/pagomora.csv'), 'r');
        $nro_registros = -1;
        while (($datum = fgetcsv($csvFile, 555, ',')) !== false)
        {
            $nro_registros +=1;
        }
        fclose($csvFile);
        $this->command->getOutput()->writeln('Iniciando Importación de pagomora...');
        $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        $this->command->getOutput()->writeln("Importando Datos de pagomora... ");

        $progressBar->start();
        $csvFile2 = fopen(base_path('archivos/pagomora.csv'),"r");
        $header = fgetcsv($csvFile2, 2000, ",", '"');


        while(($fila  = fgetcsv($csvFile2,2000,",")) !== false) {
            if (count($fila) == count($header)) {
                $fila = array_map('trim', $fila);
                $data = array_combine($header, $fila);
                extract($data);
            }
            $desembolso = Desembolso::where('credito_id', $idsolicitud)->first();
            
            if($desembolso){
                if ($fechahora_reg == '0000-00-00 00:00:00' || empty($fechahora_reg)) {
                    // Si la fecha es inválida, usa '2000-01-01 00:00:00'
                    $fecha = '2000-01-01';
                    $hora = '00:00:00';
                } else {
                    // Si la fecha es válida, conviértela correctamente
                    $fechahora = Carbon::parse($fechahora_reg);
                    $fecha = $fechahora->toDateString();
                    $hora = $fechahora->toTimeString();
                }
                $pagomora = PagoMora::firstOrCreate(
                    [
                        'credito_id' => $idsolicitud,
                        'nro'        => $nro,
                    ],
                    [
                        'diasmora'      => $diasmora,
                        'total'         => $total,
                        'fecha'         => $fecha,
                        'hora'          => $hora,
                        'user_id'       => User::where('name', $usuario)->value('id'),
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
