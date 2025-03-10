<?php

namespace App\Http\Controllers;

use App\Http\Requests\Usuario\StoreUserRequest;
use App\Http\Requests\Usuario\UpdatePasswordRequest;
use App\Http\Requests\Usuario\UpdateUserRequest;
use App\Models\AgenciaUsuario;
use App\Models\GrupoMenu;
use App\Models\Menu;
use App\Models\Persona;
use App\Models\Role;
use App\Models\RoleUsuario;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
class UserController extends Controller
{
    public function store(StoreUserRequest $request){
        $file = $request->file('foto');
        Persona::firstOrcreate([
            'dni'           => $request->dni,
            ],[
            'ape_pat'       => $request->apepat,
            'ape_mat'       => $request->apemat,
            'primernombre'  => $request->primernombre,
            'otrosnombres'  => $request->otrosnombres,
        ]);
        $usuario = User::create([
            'name'          => $request->username,
            'dni'           => $request->dni,
            'password'      => Hash::make($request->username),
        ]);
        if ($file) {
            $nombre_archivo = $request->username . ".webp";
            Storage::disk('fotos')->makeDirectory('usuarios');
            Storage::disk('fotos')->put('usuarios/' . $nombre_archivo, File::get($file));
        }
        $usuario->roles()->sync([$request->role_id]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Usuario Registrado satisfactoriamente'
        ],200);
    }
    public function cambiarclaveperfil(UpdatePasswordRequest $request){
        $request->validated();
        $user = Auth::user();
        if(Hash::check($request->current_password,$user->password)){
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json([
                'ok' => 1,
                'mensaje' => 'Clave Cambiado con Exito'
            ],200);
        }
        else {
            return response()->json([
                'errors' => [
                    'current_password' => [
                        'Contraseña Incorrecta'
                    ]
                ]
            ],422);
        }
    }
    public function cambiarEstado(Request $request){
        $user = User::find($request->id);
        if($user->es_activo==0){
            $user->es_activo=1;
        }else{
            $user->es_activo=0;
        }
        $user->save();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Estado Cambiado'
        ],200);
    }
    public function resetclave(Request $request){
        $user = User::where('id', $request->id)->first();
        $user->password = Hash::make($user->name);
        $user->save();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Clave Reseteado con Exito'
        ],200);
    }
    public function show(Request $request){
        $user = User::with('persona:dni,ape_pat,ape_mat,primernombre,otrosnombres')->where('id', $request->id)->first();
        return $user;
    }

    public function update(UpdateUserRequest $request){
        $file = $request->file('foto');
        $user = User::findOrFail($request->id);
        $user->update([
            'name'          => $request->username,
            'dni'       => $request->dni,
        ]);
        $user->save();
        if ($file) {
            $nombre_archivo = $request->username . ".webp";
            Storage::disk('fotos')->makeDirectory('usuarios');
            Storage::disk('fotos')->put('usuarios/' . $nombre_archivo, File::get($file));
        }
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Se guardo Exito'
        ],200);
    }
    public function habilitados(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return User::whereRaw("upper(name) like ?", ['%'.strtoupper($buscar).'%'])
        ->with('roles')
        ->with('agencias')
        ->where('es_activo', 1)
        ->paginate($paginacion);
    }
    public function inactivos(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return User::whereRaw("upper(name) like ?", ['%'.strtoupper($buscar).'%'])
        ->with('roles')
        ->with('agencias')
        ->where('es_activo', 0)
        ->paginate($paginacion);
    }
    public function todos(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return User::whereRaw("upper(name) like ?", ['%'.strtoupper($buscar).'%'])
        ->with('roles')
        ->with('agencias')
        ->paginate($paginacion);
    }
    public function destroy(Request $request){
        $user = User::where('id', $request->id)->first();
    
        if ($user && Storage::disk('fotos')->exists('usuarios/'.$user->dni.'.webp')) {
            Storage::disk('fotos')->delete('usuarios/'.$user->name.'.webp');
        }
        $user->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Usuario eliminado satisfactoriamente'
        ],200);
    }

    public function mostrarDatoUsuario(Request $request) {
        $usuario = User::with([
            'roles',
            'agencias',
            'persona',
        ])->where('id', $request->id)->first();
    
        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
    
        $menu = [];
        $roles = $usuario->roles->makeHidden('pivot'); // Oculta pivot de roles
        $agencia = $usuario->agencias->first();
    
        // Ocultar created_at, updated_at y pivot del usuario
        $usuario->setAttribute('agencia', $agencia);
        $usuario->makeHidden(['created_at', 'updated_at', 'pivot']);
    
        if ($agencia) {
            $agencia->makeHidden(['created_at', 'updated_at', 'pivot']);
        }
    
        if ($roles->count() == 1) {
            $role = $roles->first();
            $usuario->setAttribute('role', $role);
            $role->makeHidden(['created_at', 'updated_at', 'pivot']);
    
            $menusPorRol = GrupoMenu::with(['menus' => function ($query) use ($role) {
                $query->select('id', 'nombre', 'slug', 'icono', 'grupo_id')
                    ->whereHas('roles', function ($roleQuery) use ($role) {
                        $roleQuery->where('roles.id', $role->id);
                    });
            }])
            ->whereHas('menus.roles', function ($query) use ($role) {
                $query->where('roles.id', $role->id);
            })
            ->get();
    
            $menu = array_merge($menu, $menusPorRol->toArray());
    
            return response()->json([
                'usuario' => $usuario,
                'menus' => $menu,
            ], 200);
        } else {
            return response()->json([
                'usuario' => $usuario,
            ], 200);
        }
    }
    
    public function obtenerMenusPorRole(Request $request){
        $menu = [];
        $role = Role::where('id',$request->role_id)->first();
        $menusPorRol = GrupoMenu::with(['menus' => function ($query) use ($role) {
            $query->select('id', 'nombre', 'slug', 'icono', 'grupo_id')
                  ->whereHas('roles', function ($roleQuery) use ($role) {
                      $roleQuery->where('roles.id', $role->id);
                  });
        }])
        ->whereHas('menus.roles', function ($query) use ($role) {
            $query->where('roles.id', $role->id);
        })
        ->get();
        $menu = array_merge($menu, $menusPorRol->toArray());
        return response()->json([
            'menus' => $menu
        ],200); 
    }
    public function eliminarRole(Request $request){
        $user = User::find($request->user_id);
        $user->roles()->detach($request->role_id);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Rol eliminado satisfactoriamente'
        ],200);
    }
    public function eliminarAgencia(Request $request){
        $user = User::find($request->user_id);
        $user->agencias()->detach($request->agencia_id);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Agencia eliminado satisfactoriamente'
        ],200);
    }
    public function obtenerPorTipo(Request $request){
        $role_id=$request->role_id;
        $agencia_id=$request->agencia_id;
        $users = User::where('es_activo', 1)
        ->whereHas('roles', function ($query) use ($role_id) {
            $query->where('roles.id', $role_id);
        })
        ->when($agencia_id != 0, function ($query) use ($agencia_id) {
            $query->whereHas('agencias', function ($query) use ($agencia_id) {
                $query->where('agencias.id', $agencia_id);
            });
        })
        ->get();
        return $users;
        //return response()->json($users);
    }
}
