<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\NominaController;
use App\Http\Controllers\RolController;

/*
|--------------------------------------------------------------------------
| Empleados
|--------------------------------------------------------------------------
*/

Route::prefix('empleados')->group(function () {
    Route::get('/', [EmpleadoController::class, 'listar']);
    Route::post('/', [EmpleadoController::class, 'crear']);
    Route::put('/{uuid}', [EmpleadoController::class, 'actualizar']);
    Route::delete('/{uuid}', [EmpleadoController::class, 'eliminar']);
});

/*
|--------------------------------------------------------------------------
| Roles
|--------------------------------------------------------------------------
*/
Route::get('/roles', [RolController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Movimientos diarios
|--------------------------------------------------------------------------
*/
Route::prefix('movimientos')->group(function () {

    // Listar movimientos (filtros: uuid, mes, anio)
    Route::get('/', [MovimientoController::class, 'listar']);

    // Crear movimiento (ANTES: /registrar)
    Route::post('/', [MovimientoController::class, 'registrar']);

    // Actualizar movimiento
    Route::put('/{id}', [MovimientoController::class, 'actualizar']);

    // Eliminar movimiento (soft delete)
    Route::delete('/{id}', [MovimientoController::class, 'eliminar']);
});

/*
|--------------------------------------------------------------------------
| Nómina mensual
|--------------------------------------------------------------------------
*/
Route::prefix('nominas')->group(function () {
    Route::post('/calcular', [NominaController::class, 'calcularMes']);
});
