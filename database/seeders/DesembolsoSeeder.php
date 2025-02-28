<?php

namespace Database\Seeders;

use App\Models\Desembolso;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
class DesembolsoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('archivos/desembolsos.csv'), 'r');
        $nro_registros = -1;
        while (($datum = fgetcsv($csvFile, 555, ',')) !== false)
        {
            $nro_registros +=1;
        }
        fclose($csvFile);
        $this->command->getOutput()->writeln('Iniciando Importación de Desembolsos...');
        $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        $this->command->getOutput()->writeln("Importando Datos de Desembolsos... ");

        $progressBar->start();
        $csvFile2 = fopen(base_path('archivos/desembolsos.csv'),"r");
        $header = fgetcsv($csvFile2, 2000, ",", '"');


        while(($fila  = fgetcsv($csvFile2,2000,",")) !== false) {
            if (count($fila) == count($header)) {
                $fila = array_map('trim', $fila);
                $data = array_combine($header, $fila);
                extract($data);
            }
            $fechahora = Carbon::parse($fechahora);
            $cliente = Desembolso::firstOrCreate(
                ['credito_id' => $idsolicitud],
                [
                    'fecha'         => $fechahora->toDateString(), // "YYYY-MM-DD"
                    'hora'          => $fechahora->toTimeString(),
                    'user_id'       => User::where('name', $idusuario)->value('id'),
                    'descontado'    => $descontado,
                    'totalentregado'=> $totalentregado
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
