<?php

namespace Database\Seeders;

use App\Imports\ProcedimientoImports;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
class MinsaProcedimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Excel::import(new ProcedimientoImports, base_path('archivos/minsa/cpt_2022.xls'));
    }
}
