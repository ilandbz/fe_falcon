<?php

namespace Database\Seeders;

use App\Models\ModalidadAtencion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModalidadAtencionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modalidades = [
            ['descripcion' => 'Atención directa'],
            ['descripcion' => 'Enfermedad de Alto Costo (NO LPIS)'],
            ['descripcion' => 'Caso Especial/Cob.Extraordinaria.'],
            ['descripcion' => 'Sepelio'],
            ['descripcion' => 'Traslado de Emergencia'],
            ['descripcion' => 'Carta de Garantia'],
        ];
        foreach($modalidades as $row){
            ModalidadAtencion::firstOrCreate($row);
        }
        


    }
}
