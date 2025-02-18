<?php

namespace Database\Seeders;

use App\Models\Balance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetBalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('archivos/det_balance.csv'), 'r');
        $nro_registros = -1;
        while (($datum = fgetcsv($csvFile, 555, ',')) !== false)
        {
            $nro_registros +=1;
        }
        fclose($csvFile);
        $this->command->getOutput()->writeln('Iniciando Importación de Det Balance...');
        $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        $this->command->getOutput()->writeln("Importando Datos de Det Balance... ");

        $progressBar->start();
        $csvFile2 = fopen(base_path('archivos/det_balance.csv'),"r");
        $header = fgetcsv($csvFile2, 2000, ",", '"');


        while(($fila  = fgetcsv($csvFile2,2000,",")) !== false) {
            if (count($fila) == count($header)) {
                $fila = array_map('trim', $fila);
                $data = array_combine($header, $fila);
                extract($data);
            }
            $registro = Balance::where('credito_id', $idsolicitud)->update([
                    'activocaja' => $activocaja,
                    'activobancos' => $activobancos,
                    'activoctascobrar' => $activoctascobrar,
                    'activoinventarios' => $activoinventarios,
                    'pasivodeudaprove' => $pasivodeudaprove,
                    'pasivodeudaent' => $pasivodeudaent,
                    'pasivodeudaempre' => $pasivodeudaempre,
                    'activomueble' => $activomueble,
                    'activootrosact' => $activootrosact,
                    'activodepre' => $activodepre,
                    'pasivolargop' => $pasivolargop,
                    'otrascuentaspagar' => $otrascuentaspagar,
                    'totalacorriente' => $totalacorriente,
                    'totalpcorriente' => $totalpcorriente,
                    'totalancorriente' => $totalancorriente,
                    'totalpncorriente' => $totalpncorriente,
                ]);                   
            //usleep(1000);
            $progressBar->advance();
        }
    }
}
