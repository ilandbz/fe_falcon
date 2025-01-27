<?php

namespace Database\Seeders;

use App\Imports\DataImport;
use App\Imports\InsumoImports;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class MinsaInsumoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $import = new DataImport();
        // $import->onlySheets('INS');
        // Excel::import($import, base_path('archivos/minsa/2021_dt.xls'));


        Excel::import(new InsumoImports, base_path('archivos/minsa/ins_2021.xls'));

    }
}
