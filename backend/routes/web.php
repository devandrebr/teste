<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\FormularioRespostaController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

Route::middleware('web')->group(function () {
    Route::get('/', function () {
        return 'API v1';
    });
});

Route::withoutMiddleware([VerifyCsrfToken::class])->group(function () {
    Route::prefix('api')->group(function () {
        Route::prefix('formularios')->group(function () {
            Route::get('/', [FormularioController::class, 'lista']);
            Route::post('/{id_formulario}/preenchimentos', [FormularioRespostaController::class, 'cadastro']);
            Route::get('/{id_formulario}/preenchimentos', [FormularioRespostaController::class, 'lista']);
        });
    });
});