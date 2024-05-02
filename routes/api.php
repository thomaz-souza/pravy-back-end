<?php

use App\Http\Controllers\Api\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;


//Prefixo user para end-points
Route::prefix('user')->group(function () {

    //Rota de Login
    Route::post('/login', [LoginController::class, 'login']);

    //Autenticação de dois fatores (2FA)
    Route::post('/two-factor-challenge', [LoginController::class, 'storeTwoFactor']);

    // Rota para Cadastro
    Route::post('/register', [UserController::class, 'store']);

    Route::middleware(['auth'])->group(function () {

        //Listar Usuários
        Route::get('/', [UserController::class, 'index']);

        //Atualizar Usuário
        Route::put('/{user}', [UserController::class, 'update']);

        //Deslogar usuário
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });
});
