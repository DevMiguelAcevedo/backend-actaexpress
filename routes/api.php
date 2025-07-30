<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ActaController;

// --- AUTHENTICATION ENDPOINTS (Públicos) ---
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// --- AUTHENTICATED USER ENDPOINTS ---
Route::middleware('auth:api')->group(function () {
    // Perfil y logout del usuario autenticado
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // --- USER CRUD (solo para autenticados, puedes limitar a admins con middleware extra) ---
    Route::apiResource('users', UserController::class);

    // --- ACTA CRUD (solo para autenticados) ---
    Route::apiResource('actas', ActaController::class);
});

// --- RUTA DE PRUEBA (puedes eliminarla luego) ---
Route::get('/prueba', function () {
    return response()->json(['message' => 'API funcionando correctamente'], 200);
});
