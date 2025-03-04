<?php

use App\Http\Controllers\ConsultaApiNetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/consulta', [ConsultaApiNetController::class, 'buscarDniRuc']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



