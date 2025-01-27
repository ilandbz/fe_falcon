<?php

namespace App\Console\Commands;

use App\Models\Atencion;
use App\Models\AtencionDiagnostico;
use App\Models\Diagnostico;
use Carbon\Carbon;
use App\Models\TipoIngresoEgreso;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class TransferirDiagnosticos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:transferir-diagnosticos';

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
        $fechaactual = Carbon::now()->toDateString();
        $anio = Carbon::parse($fechaactual)->year;
        $codigomaximo = Atencion::whereYear('fechatrans', $anio)->max('codigo') ?? 0;
        $fecha = '2024-11-11';
        // $fecha = Carbon::now()->toDateString();
        $localData = DB::connection('local_db')
        ->table('vista_diagnosticos')
        ->select(
            'fua',
            'fua_id',
            'lote',
            'correlativo',
            'orden',
            'diagnostico_cod',
            'tipo_ingreso_engreso',
            'tipo_diagnostico',
            'fecha_digitalizacion'
        )
        ->where('fecha_digitalizacion', 'like', $fecha.'%')
        // ->where('fua_id', '>=',$codigomaximo)
        ->orderBy('fua_id', 'asc')
        ->orderBy('orden', 'asc')
        ->get();
        $localDataCount = $localData->count();
        $this->info('INICIANDO SINCRONIZACION DIAGNOSTICOS '.$localDataCount .' Registros'.' Fecha : '.$fecha);
        $progressBar = $this->output->createProgressBar($localDataCount);
        $progressBar->start();
        foreach ($localData as $data) {
            $diagnostico_id = Diagnostico::where('codigo', $data->diagnostico_cod)->value('id');
            $atencion_id = Atencion::where('codigo', $data->fua_id)
            ->orWhere(function ($query) use ($data) {
                $query->where('lote', $data->lote)
                    ->where('numero', $data->correlativo);
            })
            ->value('id');
            if (is_null($atencion_id)) {
                
                $this->error('No se encontró atención para FUA ID: ' . $data->fua_id);
                abort(404, 'No se encontró atención para FUA ID: ' . $data->fua_id);
            }
            $atenciondiagnostico = AtencionDiagnostico::where('diagnostico_id', $diagnostico_id)
            ->where('atencion_id', $atencion_id)->exists();
            if(!$atenciondiagnostico){
                $atencioncliente = AtencionDiagnostico::create([
                    'codigo'                => $atencion_id.$data->orden,
                    'atencion_id'           => $atencion_id,
                    'diagnostico_id'        => $diagnostico_id,
                    'tipo_diagnostico_id'    => $data->tipo_diagnostico,
                    'tipo_ingreso_egresos_id'     => TipoIngresoEgreso::where('codigo',$data->tipo_ingreso_engreso)->value('id')
                ]);                
            }
            $progressBar->advance();
        }
        $this->info('Data transferido exitosamente!');
    }
}
