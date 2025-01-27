<?php

namespace App\Console\Commands;

use App\Models\Atencion;
use App\Models\AtencionDiagnostico;
use App\Models\AtencionMedicamento;
use App\Models\Diagnostico;
use App\Models\Medicamento;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
class TransferirMedicamentos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:transferir-medicamentos';

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
        ->table('vistamedicamentos')
        ->select(
            'fua',
            'fua_id',
            'lote',
            'correlativo',
            'ordendiagnostico',
            'coddiagnostico',
            'codmedicamento',
            'cantidad_preescrita',
            'cantidad_entregada',
            'precio_unit',
            'subtotal',
            'fecha_digitalizacion'
        )
        ->where('fecha_digitalizacion', 'like', $fecha.'%')
        ->orderBy('fecha_digitalizacion', 'desc')
        // ->orderBy('fua_id', 'asc')
        // ->orderBy('ordendiagnostico', 'asc')
        ->get();
        $localDataCount = $localData->count();
        $this->info('INICIANDO SINCRONIZACION MEDICAMENTOS '.$localDataCount .' Registros'.' Fecha : '.$fecha);
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
            if(!$atenciondiagnostico){
                $this->info($data->fua);
                return 0;
            }
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
                $this->info($data->fecha_digitalizacion);
            }
            $progressBar->advance();
        }
        $this->info('Data transferido exitosamente!');
    }
}
