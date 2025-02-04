<?php

use App\Http\Controllers\AgenciaController;
use App\Http\Controllers\GrupoMenuController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
Route::group(['prefix' => 'grupo-menu', 'middleware' => 'auth'], function () {
    Route::get('todos', [GrupoMenuController::class, 'todos']);
    Route::get('mostrar', [GrupoMenuController::class, 'show']);
    Route::post('actualizar', [GrupoMenuController::class, 'update']);
    Route::post('eliminar', [GrupoMenuController::class, 'destroy']);
    Route::post('guardar', [GrupoMenuController::class, 'store']);
    Route::get('listar', [GrupoMenuController::class, 'listar']);
});

//menu
Route::group(['prefix' => 'menu', 'middleware' => 'auth'], function () {
    Route::get('todos', [MenuController::class, 'todos']);
    Route::get('mostrar', [MenuController::class, 'show']);
    Route::post('actualizar', [MenuController::class, 'update']);
    Route::post('eliminar', [MenuController::class, 'destroy']);
    Route::post('guardar', [MenuController::class, 'store']);
    Route::get('listar', [MenuController::class, 'listar']);
});



//USUARIOS
Route::group(['prefix' => 'usuario', 'middleware' => 'auth'], function () {
    Route::post('reset-password',[UserController::class,'resetclave']);
    Route::get('listar-habilitados',[UserController::class,'habilitados']);
    Route::get('listar-inactivos',[UserController::class,'inactivos']);
    Route::get('listar-todos',[UserController::class,'todos']);
    Route::get('mostrar', [UserController::class, 'show']);
    Route::post('actualizar', [UserController::class, 'update']);
    Route::post('eliminar', [UserController::class, 'destroy']);
    Route::post('guardar', [UserController::class, 'store']);
    Route::get('cambiar-estado',[UserController::class,'cambiarEstado']);
    Route::post('cambiar-clave',[UserController::class,'cambiarclaveperfil']);
    Route::post('eliminar-role',[UserController::class,'eliminarRole']);
    Route::post('eliminar-agencia',[UserController::class,'eliminarAgencia']);
});

//ROLE
Route::group(['prefix' => 'rol', 'middleware' => 'auth'], function () {
    Route::get('todos', [RoleController::class, 'todos']);
    Route::get('mostrar', [RoleController::class, 'show']);
    Route::post('actualizar', [RoleController::class, 'update']);
    Route::post('eliminar', [RoleController::class, 'destroy']);
    Route::post('guardar', [RoleController::class, 'store']);
    Route::get('listar', [RoleController::class, 'listar']);
    Route::get('menu-roles',[RoleController::class,'mostrarRoleMenus']);
    Route::get('mostrar-menus',[RoleController::class,'mostrarMenus']);
    Route::post('menu-role-guardar',[RoleController::class,'guardarRoleMenu']);
});
//AGENCIA
Route::group(['prefix' => 'agencia', 'middleware' => 'auth'], function () {
    Route::get('todos', [AgenciaController::class, 'todos']);
    Route::get('mostrar', [AgenciaController::class, 'show']);
    Route::post('actualizar', [AgenciaController::class, 'update']);
    Route::post('eliminar', [AgenciaController::class, 'destroy']);
    Route::post('guardar', [AgenciaController::class, 'store']);
    Route::get('listar', [AgenciaController::class, 'listar']);
});