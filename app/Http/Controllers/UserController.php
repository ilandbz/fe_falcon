<?php

namespace App\Http\Controllers;

use App\Http\Requests\Usuario\StoreUserRequest;
use App\Http\Requests\Usuario\UpdatePasswordRequest;
use App\Http\Requests\Usuario\UpdateUserRequest;
use App\Models\AgenciaUsuario;
use App\Models\GrupoMenu;
use App\Models\Menu;
use App\Models\Persona;
use App\Models\RoleUsuario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(StoreUserRequest $request){
        $usuario = User::create([
            'name'          => $request->username,
            'role_id'       => $request->role_id,
            'password'      => Hash::make($request->username),
        ]);
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
        $user = User::where('id', $request->id)->first();
        return $user;
    }

    public function update(UpdateUserRequest $request){
        $user = User::findOrFail($request->id);
        $user->update([
            'name'          => $request->username,
            'role_id'       => $request->role_id,
        ]);
        $user->save();
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
        ->with('role:id,nombre')
        ->where('es_activo', 1)
        ->paginate($paginacion);
    }
    public function inactivos(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return User::whereRaw("upper(name) like ?", ['%'.strtoupper($buscar).'%'])
        ->with('role:id,nombre')
        ->where('es_activo', 0)
        ->paginate($paginacion);
    }
    public function todos(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return User::whereRaw("upper(name) like ?", ['%'.strtoupper($buscar).'%'])
        ->with('role:id,nombre')
        ->paginate($paginacion);
    }
    public function destroy(Request $request){
        $user = User::where('id', $request->id)->first();
        $user->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Usuario eliminado satisfactoriamente'
        ],200);
    }

    public function mostrarDatoUsuario(Request $request)
    {
        $usuario=User::with(
            'roles' 
            )->where('id',$request->id)->first();
        $menu = [];
        $roles = $usuario->roles;
        
        if($roles->count()==1){
            $role = $roles->first();
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
                'menus' => $menu
            ],200);            
        }else{
            return response()->json([
                'usuario' => $usuario,
                'roles' => $usuario->roles,
            ],200);     
        }



    }
}
