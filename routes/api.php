<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\NominaController;



/********** Rutas para gestión de empleados **********/
Route::prefix('empleados')->group(function () {

    // Listar todos
    Route::get('/', [EmpleadoController::class, 'listar']);
    // Crear nuevo
    Route::post('/', [EmpleadoController::class, 'crear']);
    // Actualizar
    Route::put('/{uuid}', [EmpleadoController::class, 'actualizar']);
    // Eliminar
    Route::delete('/{uuid}', [EmpleadoController::class, 'eliminar']);
});


/**
 * Rutas de movimientos diarios
 */
Route::prefix('movimientos')->group(function () {

    //Listar movimientos (con filtros opcionales)
    Route::get('/', [MovimientoController::class, 'listar']);

    //Crear movimiento
    Route::post('/registrar', [MovimientoController::class, 'registrar']);

    //Actualizar movimiento
    Route::put('/{id}', [MovimientoController::class, 'actualizar']);

    //Eliminar movimiento
    Route::delete('/{id}', [MovimientoController::class, 'eliminar']);
});

// Procesamiento de nómina mensual
Route::post('/nominas/calcular', [NominaController::class, 'calcularMes']);
