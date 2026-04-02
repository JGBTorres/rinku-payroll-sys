<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\NominaController;

/**
 * Rutas de empleados
 */
Route::prefix('empleados')->group(function () {


    Route::get('/', [EmpleadoController::class, 'listar']);

    // Busqueda por número de empleado
    Route::get('/numero/{numero}', [EmpleadoController::class, 'buscarPorNumero']);

    // Creación de nuevo empleado
    Route::post('/', [EmpleadoController::class, 'crear']);

    // Actualización de empleado existente
    Route::put('/{uuid}', [EmpleadoController::class, 'actualizar']);

    // Eliminación de empleado (borrado lógico)
    Route::delete('/{numero}', [EmpleadoController::class, 'eliminar']);
});



/**
 * Rutas de movimientos diarios
 */

// Registro de movimientos diarios
Route::prefix('movimientos')->group(function () {

    // Listar movimientos (solo los que no están borrados)
    Route::get('/', [MovimientoController::class, 'listar']);

    // Registrar nuevo movimiento
    Route::post('/registrar', [MovimientoController::class, 'guardar']);

    // Actualizar movimiento existente
    Route::put('/{id}', [MovimientoController::class, 'actualizar']);

    // Borrado lógico de movimiento
    Route::delete('/{id}', [MovimientoController::class, 'eliminar']);
});



// Procesamiento de nómina mensual
Route::post('/nominas/calcular', [NominaController::class, 'calcularMes']);
