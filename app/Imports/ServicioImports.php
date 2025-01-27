<?php

namespace App\Imports;

use App\Models\Insumo;
use App\Models\MinsaInsumo;
use App\Models\MinsaProcedimiento;
use App\Models\MinsaServicio;
use App\Models\Paciente;
use App\Models\Procedimiento;
use App\Models\Servicio;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');
class ServicioImports implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Servicio|null
     */
    public function model(array $row)
    {
        try {
            $fua = str_replace(' ', '', $row['FUA']);
            $registro = explode('-', (string) $fua);
            $lote = $registro[1];
            $numero = $registro[2];
            $Contrato=str_replace(' ', '', $row['Contrato']);
            $nro_documento = str_pad(trim($row['ate_dni']), 8, '0', STR_PAD_LEFT);
            $Apellidos_Nom = explode(' ', (string) $row['apenom']);
            if ($nro_documento === 'NULL') {
                $paciente_id = count($Apellidos_Nom) > 2
                    ? Paciente::where('ape_paterno', $Apellidos_Nom[0])
                        ->where('ape_materno', $Apellidos_Nom[1])
                        ->where('primer_nombre', $Apellidos_Nom[2])
                        ->value('id')
                    : null;
            } else {
                $paciente_id = Paciente::where('nro_documento', $nro_documento)->value('id');
            }
            $servicio_id = str_pad(str_replace(' ', "", $row['id_Servicio']), 3, '0', STR_PAD_LEFT);
            $servicio_id = Servicio::where('codigo', $servicio_id)->value('id');           
            if($servicio_id==null){
                $servicio = Servicio::create([
                    'codigo' => $row['Id_Servicio'],
                    'descripcion' => $row['Servicio'],
                ]);
                $servicio_id = $servicio->id;
            }
            $valorNetoServ = str_replace(' ', "", $row['ATE_VALORNETOSER_SME']);
            $valorNetoMedi = str_replace(' ', "", $row['ATE_VALORNETOMED_SME']);
            $valorNetoProc = str_replace(' ', "", $row['ATE_VALORNETOPRO_SME']);
            $valorNetoInsu = str_replace(' ', "", $row['ATE_VALORNETOINS_SME']);
            $ValorNeto = str_replace(' ', "", $row['ATE_VALORNETO_SME']);            
            $valorBrutoServ = str_replace(' ', "", $row['valorBrutoServ']);                    
            $valorbrutoMedi = str_replace(' ', "", $row['valorbrutoMedi']);   
            $valorbrutopro = str_replace(' ', "", $row['valorbrutopro']);              
            $valorbrutoins = str_replace(' ', "", $row['valorbrutoins']);              
            $ValorBruto = str_replace(' ', "", $row['ValorBruto']);               
            $ate_fecate = Carbon::parse($row['ate_fecate'])->format('Y-m-d');
            $ate_fechdig = Carbon::parse($row['FechaCreac'])->format('Y-m-d');            
            $anho = str_replace(' ', "", $row['Periodo']);
            $mes = str_pad(str_replace(' ', "", $row['Mes']),2,'0',STR_PAD_LEFT);
            $Capita = str_replace(' ', "", $row['Capita']);
            $Fuente_Financiamiento = str_replace(' ', "", $row['Fuente_Financiamiento']);
            $estado=str_replace(' ', "", $row['Observado_PSA'])=='NoObs' ? 0 : 1;

            $minsaservicioExists = MinsaServicio::where('fua', $fua)
            ->where('servicio_id', $servicio_id)
            ->exists();
            if (!$minsaservicioExists) {
                return new MinsaServicio([
                    'fua' => $fua,
                    'lote' => $lote,
                    'numero' => $numero,
                    'contrato' => $Contrato,
                    'paciente_id' => $paciente_id,
                    'servicio_id' => $servicio_id,
                    'valorNetoServ' => $valorNetoServ,
                    'valorNetoMedi' => $valorNetoMedi,
                    'valorNetoProc' => $valorNetoProc,
                    'valorNetoInsu' => $valorNetoInsu,
                    'valorNeto' => $ValorNeto,
                    'valorBrutoServ' => $valorBrutoServ,
                    'valorBrutoMedi' => $valorbrutoMedi,
                    'valorBrutoProc' => $valorbrutopro,
                    'valorBrutoInsu' => $valorbrutoins,
                    'valorBruto' => $ValorBruto,
                    'ate_fecate' => $ate_fecate,
                    'ate_fecing' => $ate_fechdig,
                    'periodo' => $anho.$mes,
                    'Capita' => $Capita,
                    'estado' => $estado,
                    'fuente_financiamiento' => $Fuente_Financiamiento,
                ]);            
            }
        } catch (\Throwable $th) {
            dd('Error en la importación con FUA: ' . $fua, ' Mensaje de error: ' . $th->getMessage());
        }

        

        return null;
    }
    public function batchSize(): int
    {
        return 1000;
    }
    
    public function chunkSize(): int
    {
        return 1000;
    }
}