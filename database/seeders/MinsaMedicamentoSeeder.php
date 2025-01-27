<?php

namespace Database\Seeders;

use App\Imports\MedicamentoImports;
use App\Models\MinsaMedicamento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class MinsaMedicamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Excel::import(new MedicamentoImports, base_path('archivos/minsa/med_2022.xls'));
    }
}
