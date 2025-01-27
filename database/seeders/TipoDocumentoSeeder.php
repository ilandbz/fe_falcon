<?php

namespace Database\Seeders;

use App\Models\TipoDocumento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipodocumentos = [
            ['codigo' => 1, 'descripcion' => 'DNI'],
            ['codigo' => 10, 'descripcion' => 'PASAPORTE'],
            ['codigo' => 11, 'descripcion' => 'PERMISO TEMPORAL DE PERMANENCIA'],
            ['codigo' => 2, 'descripcion' => 'No cuenta con DNI'],
            ['codigo' => 3, 'descripcion' => 'Carné de Extranjería'],
            ['codigo' => 4, 'descripcion' => 'CUI para menores de edad'],
            ['codigo' => 5, 'descripcion' => 'REGISTRO UNICO DE CONTRIBUYENTES'],
            ['codigo' => 6, 'descripcion' => 'NUMERO CORRELATIVO DE ORGANIZACION - NCO'],
            ['codigo' => 7, 'descripcion' => 'CERTIFICADO DE NACIDO VIVO'],
            ['codigo' => 8, 'descripcion' => 'CEDULA DE IDENTIDAD'],
            ['codigo' => 9, 'descripcion' => 'TARJETA DE IDENTIDAD'],
        ];
        foreach($tipodocumentos as $row){
            TipoDocumento::firstOrCreate($row);
        }
    }
}
