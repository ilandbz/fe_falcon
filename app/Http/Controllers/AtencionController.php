<?php

namespace App\Http\Controllers;

use App\Http\Requests\Paciente\StorePacienteRequest;
use App\Http\Requests\Paciente\UpdatePacienteRequest;
use App\Models\Atencion;
use App\Models\Profesional;
use App\Models\UsuarioTrans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AtencionController extends Controller
{
    private $atencion_model;

    public function __construct() {
        $this->atencion_model = new Atencion();
    }
    public function store(Request $request){
        $atencionexiste = Atencion::where('codigo', $request->codigo)
        ->exists();
        if (!$atencionexiste) {
            $datos_atencion = [
                'codigo' => $request->codigo,
                'lote' => $request->lote,
                'numero' => $request->numero,
                'establecimiento_id' => $request->establecimiento_id,
                'componente_id' => $request->componente_id,
                'tipo_formato_id' => $request->tipo_formato_id,
                'disaformato' => $request->disaformato,
                'lote_formato' => $request->lote_formato,
                'nro_formato' => $request->nro_formato,
                'paciente_id' => $request->paciente_id,
                'tipo_atencion_id' => $request->tipo_atencion_id,
                'condicion_materna_id' => $request->condicion_materna_id,
                'modalidad_atencion_id' => $request->modalidad_atencion_id,
                'fecha_atencion' => $request->fecha_atencion,
                'hora_atencion' => $request->hora_atencion,
                'codigo_historia_clinica' => $request->codigo_historia_clinica,
                'fecha_parto' => $request->fecha_parto,
                'origen_personal_id' => $request->origen_personal_id,
                'servicio_id' => $request->servicio_id,
                'establecimiento_refiere_id' => $request->establecimiento_refiere_id,
                'nrohojasrefirio' => $request->nrohojasrefirio,
                'destino_asegurado_id' => $request->destino_asegurado_id,
                'establecimiento_contrarefiere_id' => $request->establecimiento_contrarefiere_id,
                'nrohojascontrarefiere' => $request->nrohojascontrarefiere,
                'fecha_ingreso' => $request->fecha_ingreso,
                'fecha_alta' => $request->fecha_alta,
                'fecha_fallecimiento' => $request->fecha_fallecimiento,
                'profesional_id' => $request->profesional_id,
                'idespecialidad' => $request->idespecialidad,
                'nroespecialidad' => $request->nroespecialidad,
                'observacion' => $request->observacion,
                'edad' => $request->edad,
                'grupo_etareo_id' => $request->grupo_etareo_id,
                'autogenerado' => $request->autogenerado,
                'idPPDD' => $request->idPPDD,
                'idOdeSis' => $request->idOdeSis,
                'idusuariotrans' => $request->idusuariotrans,
                'fechatrans' => $request->fechatrans,
                'grupo_riesgo_id' => $request->grupo_riesgo_id,
                'costo_servicio' => $request->costo_servicio,
                'costo_medicina' => $request->costo_medicina,
                'costo_insumo' => $request->costo_insumo,
                'costo_procedimiento' => $request->costo_procedimiento,
                'costo_total' => $request->costo_total,
                'periodo_id' => $request->periodo_id,
                'envio' => $request->envio,
                'supervision_id' => $request->supervision_id,
                'version' => $request->version,
                'correlativo' => $request->correlativo,
                'usuario_tran_id'   => $request->usuario_tran_id
            ];
        }
        $atencion = Atencion::create($datos_atencion);
        echo 'REGISTRADO';
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $atencion = Atencion::with([
            'paciente:id,ape_paterno,ape_materno,primer_nombre,otros_nombres,nro_documento'
        ])->where('id', $request->id)->first();
        return $atencion;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePacienteRequest $request)
    {
        $request->validated();

        $atencion = Atencion::where('id',$request->id)->first();

        $atencion->nombre           = $request->nombre;
        $atencion->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Atencion modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $atencion = Atencion::where('id', $request->id)->first();
        $atencion->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Atencion eliminado satisfactoriamente'
        ],200);
    }
    public function todos(){
        $atencions = Atencion::get();
        return $atencions;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        // $anho = '2024';
        $anho = $request->anho;
        $mes = $request->mes;
        $digitador = $request->digitador;
        $responsable = $request->responsable;
        $paginacion = $request->paginacion;
        $query = Atencion::select(
            'atencions.id',
            'atencions.fua',
            'atencions.fecha_atencion',
            'pacientes.nro_documento',
            DB::raw("UPPER(CONCAT(pacientes.ape_paterno, ' ', pacientes.ape_materno, ' ', pacientes.primer_nombre, ', ',pacientes.otros_nombres)) as nombre_completo"),
            'tipo_atencions.descripcion as tipo_atencion',
            'profesionals.nro_documento as dni_profesional',
            'profesionals.colegiatura as col_profesional',
            'profesionals.descripcion as apenom_profesional',
            DB::raw("UPPER(CONCAT(usuario_trans.ape_paterno, ' ', usuario_trans.ape_materno, ' ', usuario_trans.primer_nombre, ', ',usuario_trans.segundo_nombre)) as user"),
            'servicios.descripcion as servicio',
            'atencions.fechatrans',
            'atencions.hora_digitalizacion',
            'atencions.costo_total',
            )
        ->join('profesionals', 'atencions.profesional_id', '=', 'profesionals.id')
        ->join('pacientes', 'atencions.paciente_id', '=', 'pacientes.id')
        ->join('servicios', 'atencions.servicio_id', '=', 'servicios.id')
        ->leftjoin('tipo_atencions', 'atencions.tipo_atencion_id', '=', 'tipo_atencions.id')
        ->leftjoin('usuario_trans', 'atencions.usuario_tran_id', '=', 'usuario_trans.id')
        ->orderBy('atencions.fechatrans', 'desc')
        ->orderBy('atencions.hora_digitalizacion', 'desc')
        // ->orderBy('pacientes.ape_paterno', 'asc')
        ->where(function ($query) use ($buscar) {
            $query->whereRaw('UPPER(atencions.codigo) LIKE ?', ['%' . $buscar . '%'])
                    ->orWhereRaw('numero LIKE ?', ['%' . $buscar . '%'])
                    ->orWhereRaw('UPPER(CONCAT(atencions.codigo, "-", atencions.lote, "-", atencions.numero)) LIKE ?', ['%' . $buscar . '%'])
                    ->orWhereRaw('UPPER(CONCAT(pacientes.ape_paterno, " ", pacientes.ape_materno, " ", pacientes.primer_nombre, " ", pacientes.otros_nombres)) LIKE ?', ['%' . $buscar . '%'])
                    ->orWhereRaw('pacientes.nro_documento LIKE ?', ['%' . $buscar . '%']);
        })
        ->whereRaw('YEAR(atencions.fechatrans) = ?', [$anho])
        ->whereRaw('MONTH(atencions.fechatrans) = ?', [$mes])
        ->when($digitador != '', function ($query) use ($digitador) {
            $query->where('usuario_tran_id', $digitador);
        })
        ->when($responsable != '', function ($query) use ($responsable) {
            $query->where('profesional_id', $responsable);
        });
        $atenciones = ($paginacion && $paginacion > 0) 
        ? $query->paginate($paginacion) 
        : $query->get();

        
        //->paginate($paginacion);
        return $atenciones;
    }
    public function listaMedicamentos(Request $request){
        return Atencion::MedicamentosByAtencion($request);
    }    

    public function listaInsumos(Request $request){
        return Atencion::InsumosByAtencion($request);
    }    

    public function listaProcedimientos(Request $request){
        return Atencion::ProcedimientosByAtencion($request);
    }    
    
    public function mostrarDigitadores(){
        return UsuarioTrans::has('atencions')->distinct()->orderBy('primer_nombre', 'ASC')->get();
    }
    public function mostrarResponsables(){
        return Profesional::has('atencions')->distinct()->orderBy('descripcion', 'ASC')->get();
    }

}
