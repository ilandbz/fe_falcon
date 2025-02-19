<?php

namespace Database\Seeders;

use App\Models\PerdidaGanancia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PerdidaGananciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('archivos/perdidasyganancias.csv'), 'r');
        $nro_registros = -1;
        while (($datum = fgetcsv($csvFile, 555, ',')) !== false)
        {
            $nro_registros +=1;
        }
        fclose($csvFile);
        $this->command->getOutput()->writeln('Iniciando Importación de Perdidas...');
        $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        $this->command->getOutput()->writeln("Importando Datos de Perdidas... ");

        $progressBar->start();
        $csvFile2 = fopen(base_path('archivos/perdidasyganancias.csv'),"r");
        $header = fgetcsv($csvFile2, 2000, ",", '"');


        while(($fila  = fgetcsv($csvFile2,2000,",")) !== false) {
            if (count($fila) == count($header)) {
                $fila = array_map('trim', $fila);
                $data = array_combine($header, $fila);
                extract($data);
            }
            $registro = PerdidaGanancia::firstOrCreate(
                ['credito_id' => $idsolicitud],
                [
                    'ventas' => $ventas,
                    'costo' => $costo,
                    'utilidad' => $utilidad,
                    'costonegocio' => $costonegocio,
                    'utiloperativa' => $utiloperativa,
                    'otrosing' => $otrosing,
                    'otrosegr' => $otrosegr,
                    'gast_fam' => $gast_fam,
                    'utilidadneta' => $utilidadneta,
                    'utilnetdiaria' => $utilnetdiaria,
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
