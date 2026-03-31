<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;

/**
 * Rutas de empleados
 */
Route::prefix('empleados')->group(function () {

    // Buscar por número de empleado
    Route::get('/numero/{numero}', [EmpleadoController::class, 'buscarPorNumero']);

    // Crear
    Route::post('/', [EmpleadoController::class, 'crear']);

    // Actualizar
    Route::put('/{uuid}', [EmpleadoController::class, 'actualizar']);

    // Eliminación
    Route::delete('/{uuid}', [EmpleadoController::class, 'eliminar']);
});
