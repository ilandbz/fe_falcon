<?php
namespace App\Http\Controllers;
use App\Http\Requests\Paciente\StorePacienteRequest;
use App\Http\Requests\Paciente\UpdatePacienteRequest;
use App\Models\Medicamento;
use Illuminate\Http\Request;

class MedicamentoController extends Controller
{
    public function store(StorePacienteRequest $request)
    {
        $request->validated();
        $medicamento = Medicamento::create([
            'fua' => $request->fua,
            'lote' => $request->lote,
            'numero' => $request->numero,
            'paciente_id' => $request->paciente_id, 
            'medicamento_id' => $request->medicamento_id,
            'cantidad' => $request->cantidad,
            'precio_aplicado' => $request->precio_aplicado,
            'total' => $request->total,
            'periodo'   => $request->periodo,
            'estado'    => $request->estado,
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Role Registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $medicamento = Medicamento::where('id', $request->id)->first();
        return $medicamento;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePacienteRequest $request)
    {
        $request->validated();

        $medicamento = Medicamento::where('id',$request->id)->first();

        $medicamento->nombre           = $request->nombre;
        $medicamento->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Medicamento modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $medicamento = Medicamento::where('id', $request->id)->first();
        $medicamento->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Medicamento eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $medicamentos = Medicamento::get();
        return $medicamentos;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Medicamento::where(function($query) use ($buscar) {
            $query->whereRaw('UPPER(med_CodMed) LIKE ?', ['%'.$buscar.'%'])
            ->orWhereRaw('med_Nombre LIKE ?', ['%'.$buscar.'%'])
            ->orWhereRaw('med_FormaFarmaceutica LIKE ?', ['%'.$buscar.'%'])
            ;
        })
        ->orderBy('med_Nombre', 'asc')
        ->paginate($paginacion);
    }
}
