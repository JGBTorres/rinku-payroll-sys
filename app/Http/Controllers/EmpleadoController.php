<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Http\Requests\CrearEmpleadoRequest;
use App\Http\Requests\ActualizarEmpleadoRequest;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;

class EmpleadoController extends Controller

{
    /**
     * Listar todos los empleados (Para la tabla).
     */
    public function listar()
    {
        try {
            // Traemos todos con su relación de rol para mostrar el nombre del puesto
            $empleados = Empleado::with('rol')->orderBy('created_at', 'desc')->get();

            return ApiResponse::exito($empleados, 'Lista de empleados recuperada.');
        } catch (\Exception $e) {
            return ApiResponse::error('Error al obtener empleados: ' . $e->getMessage(), 500);
        }
    }
    /**
     * Buscar empleado o verificar disponibilidad.
     */
    public function buscarPorNumero(Request $request, string $numero)
    {
        // Usamos first() para obtener la instancia o null
        $empleado = Empleado::with('rol')->where('numero_empleado', $numero)->first();

        //Si NO existe
        if (!$empleado) {
            return ApiResponse::error('El número de empleado no existe.', 404);
        }

        //Si existe pero el query param check_only está presente, es decir, solo queremos verificar disponibilidad (Error 409 - Conflicto)
        if ($request->query('check_only')) {
            return ApiResponse::error('Este número ya está registrado.', 409);
        }

        //Si existe pero está INACTIVO (Error 422 - Unificamos a 422 para validación de negocio)
        if (!$empleado->activo) {
            return ApiResponse::error('Este empleado se encuentra inactivo.', 422);
        }

        //Búsqueda completa
        return ApiResponse::exito($empleado, 'Empleado encontrado.');
    }

    /**
     * Crear empleado.
     */
    public function crear(CrearEmpleadoRequest $request)
    {
        // create() ya usa los datos validados del Request
        $empleado = Empleado::create($request->validated());
        $empleado->load('rol');

        return ApiResponse::exito($empleado, 'Empleado registrado con éxito.', 201);
    }

    /**
     * Actualizar empleado.
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

        return ApiResponse::exito($empleado->load('rol'), 'Datos actualizados correctamente.');
    }

    /**
     * BAJA LÓGICA.
     */
    public function eliminar(string $numero)
    {
        $empleado = Empleado::where('numero_empleado', $numero)->first();

        if (!$empleado) {
            return ApiResponse::error("El empleado con número {$numero} no existe.", 404);
        }

        // Si ya está inactivo, mandamos 422 para que el frontend lo pinte de rojo
        if (!$empleado->activo) {
            return ApiResponse::error("El empleado ya se encuentra dado de baja.", 422);
        }

        $empleado->update(['activo' => false]);

        // Retornamos el nombre del empleado para mostrarlo en el mensaje de éxito
        return ApiResponse::exito(null, "Empleado {$empleado->nombre} desactivado correctamente.");
    }
}
