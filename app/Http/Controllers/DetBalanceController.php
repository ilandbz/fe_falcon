<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetBalance\StoreDetBalanceRequest;
use App\Http\Requests\DetBalance\UpdateDetBalanceRequest;
use App\Models\DetBalance;
use Illuminate\Http\Request;

class DetBalanceController extends Controller
{
    public function store(StoreDetBalanceRequest $request)
    {
        $request->validated();
        $balance = DetBalance::create([
            'credito_id'            => $request->credito_id,
            'activocaja'            => $request->activocaja,
            'activobancos'          => $request->activobancos,
            'activotascobrar'       => $request->activotascobrar,
            'activoinventarios'     => $request->activoinventarios,
            'pasivodeudaprove'      => $request->pasivodeudaprove,
            'pasivodeudanet'        => $request->pasivodeudanet,
            'pasivodeudaempre'      => $request->pasivodeudaempre,
            'activomueble'          => $request->activomueble,
            'activootrosact'        => $request->activootrosact,
            'activodepre'           => $request->activodepre,
            'pasivolargo'           => $request->pasivolargo,
            'otrascuentasapagar'    => $request->otrascuentasapagar,
            'totalacorriente'       => $request->totalacorriente,
            'totalpcorriente'       => $request->totalpcorriente,
            'totalpncorriente'      => $request->totalpncorriente,
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registro Registrado satisfactoriamente'
        ],200);
    }
    public function show(Request $request)
    {
        $balance = DetBalance::where('credito_id', $request->credito_id)->first();
        return $balance;
    }
    public function update(UpdateDetBalanceRequest $request)
    {
        $request->validated();

        DetBalance::where('credito_id', $request->credito_id)->update([
            'activocaja'            => $request->activocaja,
            'activobancos'          => $request->activobancos,
            'activotascobrar'       => $request->activotascobrar,
            'activoinventarios'     => $request->activoinventarios,
            'pasivodeudaprove'      => $request->pasivodeudaprove,
            'pasivodeudanet'        => $request->pasivodeudanet,
            'pasivodeudaempre'      => $request->pasivodeudaempre,
            'activomueble'          => $request->activomueble,
            'activootrosact'        => $request->activootrosact,
            'activodepre'           => $request->activodepre,
            'pasivolargo'           => $request->pasivolargo,
            'otrascuentasapagar'    => $request->otrascuentasapagar,
            'totalacorriente'       => $request->totalacorriente,
            'totalpcorriente'       => $request->totalpcorriente,
            'totalpncorriente'      => $request->totalpncorriente,
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registro modificado satisfactoriamente'
        ],200);
    }

    public function destroy(Request $request)
    {
        $balance = DetBalance::where('id', $request->id)->first();
        $balance->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registro eliminado satisfactoriamente'
        ],200);
    }

    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return DetBalance::whereRaw('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
    }
}
