<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/api/consulta/', function (){
    echo 'asdads';
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



