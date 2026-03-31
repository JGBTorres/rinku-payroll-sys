<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Http\Requests\CrearEmpleadoRequest;
use App\Http\Requests\ActualizarEmpleadoRequest;
use App\Http\Responses\ApiResponse;

/**
 * Controlador de empleados.
 */
class EmpleadoController extends Controller
{
    /**
     * Buscar empleado por número de empleado.
     */
    public function buscarPorNumero(string $numero)
    {
        $empleado = Empleado::with('rol')
            ->where('numero_empleado', $numero)
            ->where('activo', true)
            ->first();

        if (!$empleado) {
            return ApiResponse::error('Empleado no encontrado', 404);
        }

        return ApiResponse::exito($empleado, 'Empleado encontrado');
    }

    /**
     * Crear empleado.
     */
    public function crear(CrearEmpleadoRequest $request)
    {
        $empleado = Empleado::create($request->validated());
        $empleado->load('rol');

        return ApiResponse::exito($empleado, 'Empleado creado', 201);
    }

    /**
     * Actualizar empleado
     */
    public function actualizar(ActualizarEmpleadoRequest $request, string $uuid)
    {
        $empleado = Empleado::where('uuid', $uuid)->first();

       if (!$empleado) {
            return ApiResponse::error('Empleado no encontrado', 404);
        }

        $empleado->update($request->validated());

        return ApiResponse::exito($empleado->load('rol'), 'Empleado actualizado');
    }

    /**
     * Eliminación lógica
     */
    public function eliminar(string $uuid)
    {
        $empleado = Empleado::where('uuid', $uuid)->first();

        if (!$empleado) {
            return ApiResponse::error('Empleado no encontrado', 404);
        }

        $empleado->update(['activo' => false]);

        return ApiResponse::exito(null, 'Empleado desactivado');
    }
}
