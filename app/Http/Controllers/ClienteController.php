<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cliente\StoreClienteRequest;
use App\Http\Requests\Cliente\UpdateClienteRequest;
use App\Models\Cliente;
use App\Models\Conyugue;
use App\Models\Persona;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
class ClienteController extends Controller
{
    public function store(StoreClienteRequest $request)
    {
        $request->validated();
        $existeDni = Cliente::whereHas('persona', function ($query) use ($request) {
            $query->where('dni', $request->dni);
        })->exists(); 
        if ($existeDni) {
            return response()->json([
                'errors' => [
                    'dni' => 'El DNI ya está registrado'
                ]
            ], 422);
        }
        $file = $request->file('foto');
        if ($file) {
            $nombre_archivo = $request->dni . ".webp";
            Storage::disk('fotos')->makeDirectory('clientes');
            Storage::disk('fotos')->put('clientes/' . $nombre_archivo, File::get($file));
        }
        $esconyugue = $request->estado_civil=='Casado' || $request->estado_civil=='Conviviente';
        if ($esconyugue && empty($request->conyugue_id)) {
            return response()->json([
                'errors' => [
                    'dniconyugue' => ['DNI conyugue es necesario']
                ]
            ], 422);
        }        
        $domicilio = Ubicacion::create([
            'tipo'             => $request->tipodomicilio ?? 'NDF',
            'ubigeo'           => $request->ubigeodomicilio,
            'tipovia'          => $request->tipovia ?? 'S/N',
            'nombrevia'        => $request->nombrevia,
            'nro'              => $request->nro ?? 'S/N',
            'interior'         => $request->interior ?? 'S/N',
            'mz'               => $request->mz ?? 'S/N',
            'lote'             => $request->lote ?? 'S/N',
            'tipozona'         => $request->tipozona,
            'nombrezona'       => $request->nombrezona,
            'referencia'       => $request->referencia,
            'latitud_longitud' => $request->latitud_longitud,
        ]);
        $persona = Persona::firstorCreate(['dni' => $request->dni],
        [
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
            'ubicacion_domicilio_id' => $domicilio->id
        ]);
        if($esconyugue){
            Conyugue::Create([
                'primer_persona_id' => $persona->id,
                'segunda_persona_id' => $request->conyugue_id,
            ]);
        }
        $cliente = Cliente::create([
            'id'          => $request->id,
            'agencia_id'  => $request->agencia_id,
            'usuario_id'  => $request->usuario_id,
            'persona_id'  => $persona->id,
            'dniaval'     => $request->dniaval,
            'fecha_reg'   => now()->toDateString(), // Asigna la fecha actual
            'hora_reg'    => now()->toTimeString(), // Asigna la hora actual
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Cliente Registrado satisfactoriamente'
        ],200);
    }
    public function show(Request $request)
    {
        $persona = Cliente::with(
            'persona:id,dni,ape_pat,ape_mat,primernombre,otrosnombres,fecha_nac,ubigeo_nac,email,celular,genero,estado_civil,ruc,grado_instr,tipo_trabajador,ocupacion,institucion_lab,ubicacion_domicilio_id',
            'usuario:id,name'
        )->where('id', $request->id)->first();
        return $persona;
    }
    public function mostrarPorDni(Request $request){
        $dni = $request->dni;

        return Cliente::whereHas('persona', function ($q) use ($dni) {
            $q->where('dni', $dni);
        })->with('persona:id,dni,ape_pat,ape_mat,primernombre,otrosnombres')->first();
    }
    public function update(UpdateClienteRequest $request)
    {
        $file = $request->file('foto');
        $persona = Cliente::where('id',$request->id)->first();

        $persona->nombre           = $request->nombre;
        $persona->slug             = $request->slug;
        $persona->icono            = $request->icono;
        $persona->padre_id         = $request->padre_id;
        $persona->grupo_id         = $request->grupo_id;
        $persona->orden            = $request->orden;
        $persona->save();
        if ($file) {
            $nombre_archivo = $request->dni . ".webp";
            Storage::disk('fotos')->makeDirectory('clientes');
            Storage::disk('fotos')->put('clientes/' . $nombre_archivo, File::get($file));
        }
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Cliente modificado satisfactoriamente'
        ],200);
    }

    public function destroy(Request $request)
    {
        $persona = Cliente::where('id', $request->id)->first();
        $persona->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Cliente eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $personas = Cliente::with([
            'usuario:id,name', 
            'agencia:id,nombre',
            'persona:id,dni,ape_pat,ape_mat,primernombre,otrosnombres'
        ])->get();
        return $personas;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion ?? 10; // Valor por defecto
    
        return Cliente::with([
                'usuario:id,name', 
                'agencia:id,nombre',
                'persona:id,dni,ape_pat,ape_mat,primernombre,otrosnombres'
            ])
            ->join('personas', 'clientes.persona_id', '=', 'personas.id')
            ->where(function ($query) use ($buscar) {
                $query->whereRaw('UPPER(personas.dni) LIKE ?', ['%' . $buscar . '%'])
                    ->orWhereRaw('UPPER(personas.ape_pat) LIKE ?', ['%' . $buscar . '%'])
                    ->orWhereRaw('UPPER(personas.ape_mat) LIKE ?', ['%' . $buscar . '%'])
                    ->orWhereRaw('UPPER(personas.primernombre) LIKE ?', ['%' . $buscar . '%'])
                    ->orWhereRaw('UPPER(personas.otrosnombres) LIKE ?', ['%' . $buscar . '%'])
                    ->orWhereRaw("UPPER(CONCAT(personas.ape_pat, ' ', personas.ape_mat, ' ', personas.primernombre, ' ', IFNULL(personas.otrosnombres, ''))) LIKE ?", ['%' . $buscar . '%']);
            })
            ->select([
                'clientes.id',
                'clientes.usuario_id',
                'clientes.agencia_id',
                'clientes.persona_id',
                'clientes.estado',
                'clientes.fecha_reg',
                'clientes.hora_reg',
                DB::raw("CONCAT(personas.ape_pat, ' ', personas.ape_mat, ' ', personas.primernombre, ' ', IFNULL(personas.otrosnombres, '')) AS apenom")
            ])
            ->orderBy('apenom', 'asc') 
            ->paginate($paginacion);
    }
}
