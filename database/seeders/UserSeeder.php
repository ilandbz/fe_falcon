<?php

namespace Database\Seeders;

use App\Models\Agencia;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superusuario = User::firstOrCreate([
                'name' => 'admin',
            ],[
            'password' => Hash::make('admin'),
            ]);
        $roleId = Role::where('nombre', 'Super Usuario')->value('id');
        $superusuario->roles()->sync([$roleId]);
        $csvFile = fopen(base_path('archivos/usuario.csv'), 'r');
        $nro_registros = -1;
        while (($datum = fgetcsv($csvFile, 555, ',')) !== false)
        {
            $nro_registros +=1;
        }
        fclose($csvFile);
        $this->command->getOutput()->writeln('Iniciando Importación de Usuarios...');
        $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        $this->command->getOutput()->writeln("Importando Datos de Usuarios... ");

        $progressBar->start();
        $csvFile2 = fopen(base_path('archivos/usuario.csv'),"r");
        $header = fgetcsv($csvFile2, 2000, ",", '"');


        while(($fila  = fgetcsv($csvFile2,2000,",")) !== false) {
            if (count($fila) == count($header)) {
                $fila = array_map('trim', $fila);
                $data = array_combine($header, $fila);
                extract($data);
            }
            if($codusuario!='admin'){
                $user = User::firstOrCreate(
                    ['name' => $codusuario], // Condición de búsqueda
                    [
                        'dni' => $dni,
                        'password' => Hash::make($dni),
                        'es_activo' => $estado=='ACTIVO' ? 1 : 0,
                    ]
                );
                if($rol != 'NULL'){
                    $roleId = Role::whereRaw("LOWER(nombre) = LOWER(?)", $rol)->value('id');
                    $user->roles()->sync([$roleId]);
                }
                if($agencia != 'NULL'){
                    $agenciaId = Agencia::where('nombre', $agencia)->value('id');
                    $user->agencias()->sync([$agenciaId]);
                }
            }
            usleep(1000);
            $progressBar->advance();
        }

        fclose($csvFile2);
        $progressBar->finish();
        $this->command->getOutput()->writeln("");
        $this->command->getOutput()->writeln("Importación Finalizada");

        // $usuarios = [

        //     [
        //         'name' => 'KESPIRITU', 
        //         'dni' => '44992550', 
        //         'roles' => [
        //             'Operaciones',
        //             'Cobranza Huanuco',
        //             'Gerente Agencia',
        //         ],
        //         'agencias' => [
        //             'Huanuco',
        //             'Tingo Maria',
        //             'Huánuco 2',
        //             'Panao',
        //         ],
        //     ],
        // ];
        // foreach ($usuarios as $usuario) {
        //     $user = User::firstOrCreate(
        //         [
        //             'name' => $usuario['name'],
        //             'dni' => $usuario['dni'],
        //             'password' => Hash::make($usuario['dni']),
        //         ]
        //     );
        
        //     $roleIds = Role::whereIn('nombre', $usuario['roles'])->pluck('id');
        //     $agenciaIds = Agencia::whereIn('nombre', $usuario['agencias'])->pluck('id');
        //     $user->roles()->sync($roleIds);
        //     $user->agencias()->sync($agenciaIds);
        // }



    }
}