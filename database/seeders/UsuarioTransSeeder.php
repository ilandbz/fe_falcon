<?php

namespace Database\Seeders;

use App\Models\UsuarioTrans;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsuarioTransSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('archivos/usuarios_trans.csv'), 'r');
        $this->command->getOutput()->writeln("Importando Usuarios Trnas... ");
        $firstLine = true;
        while(($fila = fgetcsv($csvFile, 3000, "}")) !== false) {
            if(!$firstLine)
            {
                $registro = explode(";",(string)$fila[0]);
                UsuarioTrans::firstorCreate([
                    'codigo'            => str_replace('"', '', $registro[0]),
                    'ape_paterno'       => str_replace('"', '', $registro[2]),
                    'ape_materno'       => str_replace('"', '', $registro[3]),
                    'primer_nombre'     => str_replace('"', '', $registro[4]),
                    'segundo_nombre'    => str_replace('"', '', $registro[5]),
                    'user_login'        => str_replace('"', '', $registro[6]),
                ]);
            }
            $firstLine = false;
        }
    }
}
