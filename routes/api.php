<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;

/**
 * Rutas de empleados
 */
Route::prefix('empleados')->group(function () {


    Route::get('/', [EmpleadoController::class, 'index']);

    // BÚSQUEDA POR NÚMERO DE EMPLEADO -> /api/empleados/numero/{numero}
    Route::get('/numero/{numero}', [EmpleadoController::class, 'buscarPorNumero']);

    // CREAR -> /api/empleados
    Route::post('/', [EmpleadoController::class, 'crear']);

    // ACTUALIZAR -> /api/empleados/{uuid}
    Route::put('/{uuid}', [EmpleadoController::class, 'actualizar']);

    // ELIMINAR (Baja Lógica) -> /api/empleados/{numero}
    Route::delete('/{numero}', [EmpleadoController::class, 'eliminar']);
});
