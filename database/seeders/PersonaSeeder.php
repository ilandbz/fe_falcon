<?php

namespace Database\Seeders;

use App\Models\Distrito;
use App\Models\Persona;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */


    public function run(): void
    {

        // function removerAcentos($texto) {
        //     return str_replace(
        //         ['á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú'],
        //         ['a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U'],
        //         $texto
        //     );
        // }

        $csvFile = fopen(base_path('archivos/persona.csv'), 'r');
        $nro_registros = -1;
        while (($datum = fgetcsv($csvFile, 555, ',')) !== false)
        {
            $nro_registros +=1;
        }
        fclose($csvFile);
        $this->command->getOutput()->writeln('Iniciando Importación de Personas...');
        $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        $this->command->getOutput()->writeln("Importando Datos de Personas... ");

        $progressBar->start();
        $firstLine = true;

        $csvFile2 = fopen(base_path('archivos/persona.csv'),"r");
        $header = fgetcsv($csvFile2, 2000, ",", '"');


        while(($fila  = fgetcsv($csvFile2,2000,",")) !== false) {
            if (count($fila) == count($header)) {
                $fila = array_map('trim', $fila); // Eliminar espacios en todos los valores
                $data = array_combine($header, $fila);
                extract($data);
            }
            // print_r($fila);
            // echo "DNI: $dni, Nombre: $nombres, Apellido Paterno: $apepat Genero: $genero\n";
            
            if($dni!=''){
                $distrito = removerAcentos($distrito);
                $provincia = removerAcentos($provincia);
                $ubigeo = Distrito::whereRaw("LOWER(nombre) = LOWER(?)", [$distrito])
                ->whereHas('provincia', function ($query) use ($provincia) {
                    $query->whereRaw("LOWER(nombre) = LOWER(?)", [$provincia]);
                })
                ->first();
                $nombres = trim($nombres); // Elimina espacios en los extremos
                $nombreArray = explode(' ', $nombres, 2); // Divide el string en máximo 2 partes
                
                $primernombre = $nombreArray[0]; // Primer palabra siempre es el primer nombre
                $otrosnombres = isset($nombreArray[1]) ? $nombreArray[1] : ''; 
                $usuario = Persona::firstOrCreate(
                        ['dni' => $dni],
                        [
                        'ape_pat'          => $apepat,
                        'ape_mat'          => $apemat,
                        'primernombre'     => $primernombre, // Mapeo correcto según tu variable
                        'otrosnombres'     => $otrosnombres,
                        'fecha_nac'        => $fecha_nac === '0000-00-00' ? '2000-01-01' : $fecha_nac,
                        'ubigeo_nac'       => $ubigeo->ubigeo ?? null,
                        'genero'           => $genero,
                        'celular'          => $celular ?? null,
                        'email'            => $email ?? null,
                        'ruc'              => $ruc ?? null,
                        'estado_civil'     => $estadocivil ?? 'SOLTERO',
                        'profesion'        => $profesion ?? 'NINGUNO',
                        'nacionalidad'     => $nacionalidad ?? 'PERUANO',
                        'grado_instr'      => $grado_instr ?? null,
                        'tipo_trabajador'  => $tipo_trabajador ?? 'INDEPENDIENTE',
                        'ocupacion'        => $ocupacion ?? 'NINGUNO',
                        'institucion_lab'  => $institucion_lab ?? 'NINGUNO',
                        //'ubicacion_domicilio_id' => ($ubicaciondomicilio || $ubicaciondomicilio=='NULL') ?? null,
                    ]);                
            }

            usleep(1000);
            $progressBar->advance();
        }

        fclose($csvFile2);
        $progressBar->finish();
        $this->command->getOutput()->writeln("");
        $this->command->getOutput()->writeln("Importación Finalizada");
    }
}
