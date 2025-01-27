<?php

namespace App\Console\Commands;

use App\Models\Medicamento;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TransferirProcedimientos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:transferir-procedimientos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fecha = '2024-11';
        $localData = DB::connection('local_db')
        ->table('vistaprocedimientos')
        ->select(
            'fua',
            'fua_id',
            'codprocedimiento',
            'codprocedimiento2',
            'ordendiagnostico',
            'coddiagnostico',
            'cantidad_preescrita',
            'cantidad_entregada',
            'precio_unit',
            'subtotal',
            'fecha_digitalizacion'
        )
        ->where('fecha_digitalizacion', 'like', $fecha.'%')
        ->orderBy('fua_id', 'asc')
        ->orderBy('ordendiagnostico', 'asc')
        ->get();
        $localDataCount = $localData->count();
        $this->info('INICIANDO SINCRONIZACION PROCEDIMIENTOS '.$localDataCount .' Registros'.' Fecha : '.$fecha);
        $progressBar = $this->output->createProgressBar($localDataCount);
        $progressBar->start();
        foreach ($localData as $data) {
            $medicamento_id = Medicamento::where('med_CodMed', $data->codmedicamento)->value('id');
            $atencion_id = Atencion::where('codigo', $data->fua_id)
            ->orWhere(function ($query) use ($data) {
                $query->where('lote', $data->lote)
                    ->where('numero', $data->correlativo);
            })
            ->value('id');
            $diagnostico_id = Diagnostico::where('codigo', $data->coddiagnostico)->value('id');
            $atenciondiagnostico = AtencionDiagnostico::where('diagnostico_id', $diagnostico_id)
            ->where('atencion_id', $atencion_id)->first();

            $atencionmedicamento = AtencionMedicamento::where('atencion_diagnostico_id', $atenciondiagnostico->id)
            ->exists();
            if(!$atencionmedicamento && isset($medicamento_id)){
                $reg = AtencionMedicamento::create([
                    'codigo'                    => $atencion_id.$atenciondiagnostico->id,
                    'atencion_diagnostico_id'   => $atenciondiagnostico->id,
                    'medicamento_id'            => $medicamento_id,
                    'cantidad_preescrita'       => $data->cantidad_preescrita,
                    'cantidad_entregada'        => $data->cantidad_entregada,
                    'precio_unitario'           => $data->precio_unit,
                    'subtotal'                  => $data->subtotal,
                ]);                
            }
            $progressBar->advance();
        }
        $this->info('Data transferido exitosamente!');
    }
}
