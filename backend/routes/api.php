<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\Api\AuthController;

use App\Http\Controllers\Api\RegisterController;

Route::post('/login', [AuthController::class, 'login']);

Route::post('/register', [RegisterController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/prestamo', [PrestamoController::class, 'store']);
    Route::get('/prestamo/{id}', [PrestamoController::class, 'show']);
});
