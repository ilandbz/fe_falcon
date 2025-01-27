<?php

namespace Database\Seeders;

use App\Models\TipoAtencion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoAtencionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipoatencion = [
            ['codigo' => '0','descripcion' => ''],
            ['codigo' => '1','descripcion' => 'AMBULATORIO'],
            ['codigo' => '2','descripcion' => 'REFERIDO'],
            ['codigo' => '3','descripcion' => 'EMERGENCIA'],
        ];
        foreach($tipoatencion as $row){
            TipoAtencion::firstOrCreate($row);
        }
    }
}
