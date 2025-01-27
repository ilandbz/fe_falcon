<?php

namespace Database\Seeders;

use App\Models\PrecioServicio;
use App\Models\Servicio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrecioServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('archivos/tarifario/SERVICIOS.csv'), 'r');
        $nro_registros = -1;
        while (($datum = fgetcsv($csvFile, 1000, '}')) !== false){
            $nro_registros +=1;
        }
        fclose($csvFile);
        $this->command->getOutput()->writeln('Iniciando Importación de SERVICIOS...');
        $this->command->getOutput()->writeln('Cantidad de registros: '.$nro_registros);
        $csvFile2 = fopen(base_path('archivos/tarifario/SERVICIOS.csv'), 'r');
        $this->command->getOutput()->writeln("Importando Datos... ");
        $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        $progressBar->start();
        $firstLine = 1;
        while(($fila = fgetcsv($csvFile2, 2000, "}")) !== false) {
            if($firstLine>=8)
            {
                $registro = explode(",",(string)$fila[0]);
                $this->command->getOutput()->writeln('indice : '.$firstLine.' '.$registro[1]);
                PrecioServicio::firstOrCreate([
                    
                    'servicio_id'        => Servicio::where('codigo', str_replace(['"', ' '], '', $registro[1]))->value('id'),
                    'nivel1'      => str_replace(['"', ' '], '', $registro[2]),
                    'nivel2'      => str_replace(['"', ' '], '', $registro[3]),
                ]);
                
                $progressBar->advance();
            }
            $firstLine+=1;
        }
    }
}