<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cargo\UpdatePersonaRequest;
use App\Http\Requests\Persona\StorePersonaRequest;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
class PersonaController extends Controller
{
    public function mostrarPorDni(Request $request)
    {
        $persona = Persona::where('dni', $request->dni)->first();
        return $persona;
    }
    public function store(StorePersonaRequest $request)
    {
        $request->validated();
        $file = $request->file('foto');
        if ($file) {
            $nombre_archivo = $request->dni.".webp";
            Storage::disk('personas')->put($nombre_archivo,File::get($file));
        }
        $persona = Persona::create([
            'dni' => $request->dni,
            'ape_pat' => $request->ape_pat,
            'ape_mat' => $request->ape_mat,
            'primernombre' => $request->primernombre,
            'otrosnombres' => $request->otrosnombres,
            'fecha_nac' => $request->fecha_nac,
            'ubigeo_nac' => $request->ubigeo_nac,
            'genero' => $request->genero,
            'celular' => $request->celular,
            'email' => $request->email,
            'ruc' => $request->ruc,
            'estado_civil' => $request->estado_civil,
            'profesion' => $request->profesion,
            'nacionalidad' => $request->nacionalidad,
            'grado_instr' => $request->grado_instr,
            'tipo_trabajador' => $request->tipo_trabajador,
            'ocupacion' => $request->ocupacion,
            'institucion_lab' => $request->institucion_lab,
            'ubicacion_domicilio_id' => $request->ubicacion_domicilio_id
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Persona Registrado satisfactoriamente',
        ],200);
    }
    public function show(Request $request)
    {
        $persona = Persona::where('id', $request->id)->first();
        return $persona;
    }
    public function update(UpdatePersonaRequest $request)
    {
        $request->validated();
        $persona = Persona::where('id',$request->id)->first();
        $persona->dni = $request->dni;
        $persona->ape_pat = $request->ape_pat;
        $persona->ape_mat = $request->ape_mat;
        $persona->primernombre = $request->primernombre;
        $persona->otrosnombres = $request->otrosnombres;
        $persona->fecha_nac = $request->fecha_nac;
        $persona->ubigeo_nac = $request->ubigeo_nac;
        $persona->genero = $request->genero;
        $persona->celular = $request->celular;
        $persona->email = $request->email;
        $persona->ruc = $request->ruc;
        $persona->estado_civil = $request->estado_civil;
        $persona->profesion = $request->profesion;
        $persona->nacionalidad = $request->nacionalidad;
        $persona->grado_instr = $request->grado_instr;
        $persona->tipo_trabajador = $request->tipo_trabajador;
        $persona->ocupacion = $request->ocupacion;
        $persona->institucion_lab = $request->institucion_lab;
        $persona->ubicacion_domicilio_id = $request->ubicacion_domicilio_id;

        $persona->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Persona modificado satisfactoriamente'
        ],200);
    }
    public function destroy(Request $request)
    {
        $persona = Persona::where('id', $request->id)->first();
        $persona->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Persona eliminado satisfactoriamente'
        ],200);
    }
    public function todos(){
        $personas = Persona::with('grupo:id,titulo')->get();
        return $personas;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Persona::with(['padre:id,nombre', 'grupo:id,titulo'])->whereRaw('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
    }
}
