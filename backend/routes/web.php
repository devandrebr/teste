<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormularioRespostaController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')->group(function () {
    Route::prefix('formularios')->group(function () {
        Route::post('/{id_formulario}/preenchimentos', [FormularioRespostaController::class, 'cadastro']);
        Route::get('/{id_formulario}/preenchimentos', [FormularioRespostaController::class, 'lista']);
    });
});