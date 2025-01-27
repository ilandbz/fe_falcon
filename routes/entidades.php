<?php

use App\Http\Controllers\AtencionController;
use App\Http\Controllers\DiagnosticoController;
use App\Http\Controllers\EstablecimientoController;
use App\Http\Controllers\GrupoMenuController;
use App\Http\Controllers\InsumoController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\PasivoController;
use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\PrecioInsumoController;
use App\Http\Controllers\PrecioMedicamentoController;
use App\Http\Controllers\PrecioProcedimientoController;
use App\Http\Controllers\PrecioServicioController;
use App\Http\Controllers\ProcedimientoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ReporteController;
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

//PACIENTE
Route::group(['prefix' => 'paciente', 'middleware' => 'auth'], function () {
    Route::get('todos', [PacienteController::class, 'todos']);
    Route::get('mostrar', [PacienteController::class, 'show']);
    Route::post('actualizar', [PacienteController::class, 'update']);
    Route::post('eliminar', [PacienteController::class, 'destroy']);
    Route::post('guardar', [PacienteController::class, 'store']);
    Route::get('listar', [PacienteController::class, 'listar']);
});

//MEDICAMENTO
Route::group(['prefix' => 'medicamento', 'middleware' => 'auth'], function () {
    Route::get('todos', [MedicamentoController::class, 'todos']);
    Route::get('mostrar', [MedicamentoController::class, 'show']);
    Route::post('actualizar', [MedicamentoController::class, 'update']);
    Route::post('eliminar', [MedicamentoController::class, 'destroy']);
    Route::post('guardar', [MedicamentoController::class, 'store']);
    Route::get('listar', [MedicamentoController::class, 'listar']);
});

//SERVICIO
Route::group(['prefix' => 'servicio', 'middleware' => 'auth'], function () {
    Route::get('todos', [ServicioController::class, 'todos']);
    Route::get('mostrar', [ServicioController::class, 'show']);
    Route::post('actualizar', [ServicioController::class, 'update']);
    Route::post('eliminar', [ServicioController::class, 'destroy']);
    Route::post('guardar', [ServicioController::class, 'store']);
    Route::get('listar', [ServicioController::class, 'listar']);
});

//INSUMO
Route::group(['prefix' => 'insumo', 'middleware' => 'auth'], function () {
    Route::get('todos', [InsumoController::class, 'todos']);
    Route::get('mostrar', [InsumoController::class, 'show']);
    Route::post('actualizar', [InsumoController::class, 'update']);
    Route::post('eliminar', [InsumoController::class, 'destroy']);
    Route::post('guardar', [InsumoController::class, 'store']);
    Route::get('listar', [InsumoController::class, 'listar']);
});

//PROCEDIMIENTO
Route::group(['prefix' => 'procedimiento', 'middleware' => 'auth'], function () {
    Route::get('todos', [ProcedimientoController::class, 'todos']);
    Route::get('mostrar', [ProcedimientoController::class, 'show']);
    Route::post('actualizar', [ProcedimientoController::class, 'update']);
    Route::post('eliminar', [ProcedimientoController::class, 'destroy']);
    Route::post('guardar', [ProcedimientoController::class, 'store']);
    Route::get('listar', [ProcedimientoController::class, 'listar']);
    Route::get('insumos', [ProcedimientoController::class, 'insumos']);
});

//ATENCION
Route::group(['prefix' => 'atencion', 'middleware' => 'auth'], function () {
    Route::get('todos', [AtencionController::class, 'todos']);
    Route::get('mostrar', [AtencionController::class, 'show']);
    Route::post('actualizar', [AtencionController::class, 'update']);
    Route::post('eliminar', [AtencionController::class, 'destroy']);
    Route::post('listar', [AtencionController::class, 'listar']);
    Route::get('medicamentos', [AtencionController::class, 'listaMedicamentos']);
    Route::get('insumos', [AtencionController::class, 'listaInsumos']);
    Route::get('procedimientos', [AtencionController::class, 'listaProcedimientos']);
    Route::get('lista-digitadores', [AtencionController::class, 'mostrarDigitadores']);
    Route::get('lista-profesionales', [AtencionController::class, 'mostrarResponsables']);
});

Route::post('atenciones-guardar', [AtencionController::class, 'store']);

//DIAGNOSTICO
Route::group(['prefix' => 'diagnostico', 'middleware' => 'auth'], function () {
    Route::get('todos', [DiagnosticoController::class, 'todos']);
    Route::get('mostrar', [DiagnosticoController::class, 'show']);
    Route::post('actualizar', [DiagnosticoController::class, 'update']);
    Route::post('eliminar', [DiagnosticoController::class, 'destroy']);
    Route::post('guardar', [DiagnosticoController::class, 'store']);
    Route::get('listar', [DiagnosticoController::class, 'listar']);
    Route::get('listar-por-atencion', [DiagnosticoController::class, 'obtenerDiagnosticosPorAtencion']);
});

//ESTABLECIMIENTO
Route::group(['prefix' => 'establecimiento', 'middleware' => 'auth'], function () {
    Route::get('todos', [EstablecimientoController::class, 'todos']);
    Route::get('mostrar', [EstablecimientoController::class, 'show']);
    Route::post('actualizar', [EstablecimientoController::class, 'update']);
    Route::post('eliminar', [EstablecimientoController::class, 'destroy']);
    Route::post('guardar', [EstablecimientoController::class, 'store']);
    Route::get('listar', [EstablecimientoController::class, 'listar']);
});

//PERIODO
Route::group(['prefix' => 'periodo', 'middleware' => 'auth'], function () {
    Route::get('todos', [PeriodoController::class, 'todos']);
    Route::get('mostrar', [PeriodoController::class, 'show']);
    Route::post('actualizar', [PeriodoController::class, 'update']);
    Route::post('eliminar', [PeriodoController::class, 'destroy']);
    Route::post('guardar', [PeriodoController::class, 'store']);
    Route::get('listar', [PeriodoController::class, 'listar']);
});


//REPORTES
Route::group(['prefix' => 'reporte', 'middleware' => 'auth'], function () {
    Route::post('produccion-atencion', [ReporteController::class, 'reporteProduccionPorAtencion']);
    Route::post('medicamentos-minsa', [ReporteController::class, 'reporteMedicamentosMinsa']);
    Route::post('insumos-minsa', [ReporteController::class, 'reporteInsumosMinsa']);
    Route::post('procedimientos-minsa', [ReporteController::class, 'reporteProcedimientosMinsa']);
    Route::post('servicios-minsa', [ReporteController::class, 'reporteServiciosMinsa']);
    Route::post('produccion-atencion-anual', [ReporteController::class, 'reporteProduccionAnual']);
    Route::post('produccion-bruto-neto', [ReporteController::class, 'reporteBrutoNeto']);
});

//PRECIO MEDICAMENTO
Route::group(['prefix' => 'precio-medicamento', 'middleware' => 'auth'], function () {
    Route::post('listar', [PrecioMedicamentoController::class, 'listar']);
    Route::get('precios', [PrecioMedicamentoController::class, 'obtenerPrecios']);

});
//PRECIO SERVICIO
Route::group(['prefix' => 'precio-servicio', 'middleware' => 'auth'], function () {
    Route::post('listar', [PrecioServicioController::class, 'listar']);
});
//PRECIO INSUMO
Route::group(['prefix' => 'precio-insumo', 'middleware' => 'auth'], function () {
    Route::post('listar', [PrecioInsumoController::class, 'listar']);
});
//PRECIO PROCEDIMIENTO
Route::group(['prefix' => 'precio-procedimiento', 'middleware' => 'auth'], function () {
    Route::post('listar', [PrecioProcedimientoController::class, 'listar']);
    Route::get('precios', [PrecioProcedimientoController::class, 'obtenerPrecios']);
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