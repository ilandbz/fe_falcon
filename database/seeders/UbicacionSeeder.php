<?php

namespace Database\Seeders;

use App\Models\Distrito;
use App\Models\Ubicacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UbicacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        function removerAcentos($texto) {
            return str_replace(
                ['á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú'],
                ['a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U'],
                $texto
            );
        }

        $csvFile = fopen(base_path('archivos/ubicacion.csv'), 'r');
        $nro_registros = -1;
        while (($datum = fgetcsv($csvFile, 555, ',')) !== false)
        {
            $nro_registros +=1;
        }
        fclose($csvFile);
        $this->command->getOutput()->writeln('Iniciando Importación de Ubicaciones...');
        $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        $this->command->getOutput()->writeln("Importando Datos de Ubicaciones... ");

        $progressBar->start();
        $firstLine = true;

        $csvFile2 = fopen(base_path('archivos/ubicacion.csv'),"r");
        $header = fgetcsv($csvFile2, 2000, ",", '"');


        while(($fila  = fgetcsv($csvFile2,2000,",")) !== false) {
            if (count($fila) == count($header)) {
                $fila = array_map('trim', $fila); // Eliminar espacios en todos los valores
                $data = array_combine($header, $fila);
                extract($data);
            }

            $distrito = removerAcentos($distrito);
            $provincia = removerAcentos($provincia);
            $ubigeo = Distrito::whereRaw("LOWER(nombre) = LOWER(?)", [$distrito])
            ->whereHas('provincia', function ($query) use ($provincia) {
                $query->whereRaw("LOWER(nombre) = LOWER(?)", [$provincia]);
            })
            ->first();
            $ubicacion = Ubicacion::firstOrCreate(
                [
                    'id' => $id,
                    'ubigeo' => $ubigeo->ubigeo ?? null,
                    'nombrevia' => $nombrevia,
                    'nro' => $nro,
                    'tipo' => $tipo ?? 'NDF',
                    'tipovia' => $tipovia ?? 'S/N',
                    'interior' => $interior ?? 'S/N',
                    'mz' => $mz ?? 'S/N',
                    'lote' => $lote ?? 'S/N',
                    'tipozona' => $tipozona ?? null,
                    'nombrezona' => $nombrezona ?? null,
                    'referencia' => $referencia ?? null,
                    'latitud_longitud' => null,
                ]
            );             

            usleep(1000);
            $progressBar->advance();
        }

        fclose($csvFile2);
        $progressBar->finish();
        $this->command->getOutput()->writeln("");
        $this->command->getOutput()->writeln("Importación Finalizada");
    }
}
