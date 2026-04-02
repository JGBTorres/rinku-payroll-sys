<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Http\Requests\CrearEmpleadoRequest;
use App\Http\Requests\ActualizarEmpleadoRequest;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;

/**
 * Controlador para la gestión de empleados.
 */
class EmpleadoController extends Controller
{
    /**
     * Listar empleados o buscar por número de empleado.
     */
    public function listar(Request $request)
    {
        $query = Empleado::with('rol');

        // Búsqueda por número de empleado
        if ($request->filled('numero')) {
            $empleado = $query
                ->where('numero_empleado', $request->numero)
                ->first();

            if (!$empleado) {
                return ApiResponse::error('Empleado no encontrado.', 404);
            }

            return ApiResponse::exito($empleado, 'Empleado encontrado.');
        }

        // 📋 Listado general (tabla)
        $empleados = $query
            ->orderBy('created_at', 'desc')
            ->get();

        return ApiResponse::exito($empleados, 'Lista de empleados recuperada.');
    }

    /**
     * Crear un nuevo empleado.
     */
    public function crear(CrearEmpleadoRequest $request)
    {
        $empleado = Empleado::create($request->validated());
        $empleado->load('rol');

        return ApiResponse::exito($empleado, 'Empleado registrado con éxito.', 201);
    }

    /**
     * Actualizar datos de un empleado.
     */
    public function actualizar(ActualizarEmpleadoRequest $request, string $uuid)
    {
        $empleado = Empleado::where('uuid', $uuid)->first();

        if (!$empleado) {
            return ApiResponse::error('Empleado no encontrado.', 404);
        }

        if (!$empleado->activo) {
            return ApiResponse::error('No se pueden editar datos de un empleado inactivo.', 422);
        }

        $empleado->update($request->validated());

        return ApiResponse::exito(
            $empleado->load('rol'),
            'Datos actualizados correctamente.'
        );
    }

    /**
     * Dar de baja lógica a un empleado.
     */
    public function eliminar(string $uuid)
    {
        $empleado = Empleado::where('uuid', $uuid)->first();

        if (!$empleado) {
            return ApiResponse::error("Empleado no encontrado.", 404);
        }

        if (!$empleado->activo) {
            return ApiResponse::error("El empleado ya se encuentra dado de baja.", 422);
        }

        $empleado->update(['activo' => false]);

        return ApiResponse::exito(
            null,
            "Empleado {$empleado->nombre} desactivado correctamente."
        );
    }
}
