<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Negocio;
use App\Models\TipoActividad;
use App\Models\Ubicacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NegocioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('archivos/negocios.csv'), 'r');
        $nro_registros = -1;
        while (($datum = fgetcsv($csvFile, 555, ',')) !== false)
        {
            $nro_registros +=1;
        }
        fclose($csvFile);
        $this->command->getOutput()->writeln('Iniciando Importación de negocioss...');
        $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        $this->command->getOutput()->writeln("Importando Datos de negocioss... ");

        $progressBar->start();

        $csvFile2 = fopen(base_path('archivos/negocios.csv'),"r");
        $header = fgetcsv($csvFile2, 2000, ",", '"');


        while(($fila  = fgetcsv($csvFile2,2000,",")) !== false) {
            if (count($fila) == count($header)) {
                $fila = array_map('trim', $fila); // Eliminar espacios en todos los valores
                $data = array_combine($header, $fila);
                extract($data);
            }
            $cliente = Cliente::where('id', $codcliente)->first();

            if($cliente!=''){
                $negocio = Negocio::firstOrCreate(
                    ['id'=> $idnegocio]
                    ,[
                    'cliente_id'          => $codcliente,
                    'razonsocial'          => $razonsocial,
                    'ruc'     => $ruc,
                    'tel_cel'     => $tel_cel,
                    'tipo_actividad_id'        => TipoActividad::where('nombre', $actividad)->value('id'),
                    'descripcion'               => $descripcion,
                    'inicioactividad'           => $inicioactividad == '0000-00-00' ? '2000-01-01' : $inicioactividad,
                    'ubicacion_id'          => Ubicacion::where('id', $idubicacion)->value('id'),
                ]);
            }
            $progressBar->advance();
        }

        fclose($csvFile2);
        $progressBar->finish();
        $this->command->getOutput()->writeln("");
        $this->command->getOutput()->writeln("Importación Finalizada");
    }
}
