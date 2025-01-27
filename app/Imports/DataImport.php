<?php
namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithConditionalSheets;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DataImport implements WithMultipleSheets 
{
    use WithConditionalSheets;
   
    public function conditionalSheets(): array
    {
        return [
            'INS' => new InsumoSheetImport(),
            'CPT' => new ProcedimientoSheetImport(),
        ];        
    }

}
?>