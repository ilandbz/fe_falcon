<?php

namespace App\Http\Controllers;

use App\Models\Atencion;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    private $atencion_model;

    public function __construct() {
        $this->atencion_model = new Atencion();
    }
    public function reporteProduccionPorAtencion(Request $request)
    {
        return Atencion::produccionByAtencion($request);
        //return Atencion::totalProduccionAtencionPorMes($request);
        //return $this->atencion_model->totalProduccionAtencionPorMes($request);
    }
    public function reporteProduccionAnual(Request $request)
    {
        return Atencion::totalProduccionAtencionPorMes($request);
    }
    public function reporteMedicamentosMinsa(Request $request){
        return Atencion::medicamentosMinsa($request);
    }
    public function reporteBrutoNeto(Request $request){
        return Atencion::RporteBrutoNeto($request);
    }
    public function reporteInsumosMinsa(Request $request){
        return Atencion::insumosMinsa($request);
    }
    public function reporteProcedimientosMinsa(Request $request){
        return Atencion::procedimientosMinsa($request);
    }
    public function reporteServiciosMinsa(Request $request){
        return Atencion::serviciosMinsa($request);
    }    
}
