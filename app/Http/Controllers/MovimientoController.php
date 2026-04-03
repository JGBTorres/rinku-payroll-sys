<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Movimiento;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Controlador para la gestión de movimientos (horas y entregas).
 */
class MovimientoController extends Controller
{
    /**
     * Listar historial de movimientos.
     * Permite filtrar por UUID de empleado y periodo.
     */
    public function listar(Request $request): JsonResponse
    {
        $$query = Movimiento::with([
            'empleado:id,nombre,uuid',
            'rolAplicado:id,nombre,salario_base,bono_por_hora'
        ]);

        if ($request->filled('uuid')) {
            $query->whereHas('empleado', function ($q) use ($request) {
                $q->where('uuid', $request->uuid);
            });
        }

        if ($request->filled('mes')) {
            $query->whereMonth('fecha', $request->mes);
        }

        if ($request->filled('anio')) {
            $query->whereYear('fecha', $request->anio);
        }

        $movimientos = $query
            ->orderBy('fecha', 'desc')
            ->get();

        return ApiResponse::exito($movimientos, 'Historial obtenido correctamente');
    }

    /**
     * Registrar un nuevo movimiento.
     */
    public function registrar(Request $request): JsonResponse
    {
        $request->validate([
            'uuid'             => 'required|exists:empleados,uuid',
            'fecha'            => 'required|date',
            'horas_trabajadas' => 'required|numeric|min:0.5|max:24',
            'entregas'         => 'required|integer|min:0',
            'rol_aplicado_id'  => 'sometimes|exists:roles,id',
        ]);

        try {
            // Buscar empleado por UUID
            $empleado = Empleado::where('uuid', $request->uuid)->firstOrFail();

            //Evitar duplicar movimientos en la misma fecha
            $existe = Movimiento::where('empleado_id', $empleado->id)
                ->whereDate('fecha', $request->fecha)
                ->exists();

            if ($existe) {
                return ApiResponse::error(
                    'Ya existe un movimiento para este empleado en esa fecha',
                    422
                );
            }

            // Crear movimiento
            $movimiento = Movimiento::create([
                'empleado_id'      => $empleado->id,
                'fecha'            => $request->fecha,
                'horas_trabajadas' => $request->horas_trabajadas,
                'entregas'         => $request->entregas,
                //Usa rol aplicado o el rol base del empleado
                'rol_aplicado_id'  => $request->rol_aplicado_id ?? $empleado->rol_id,
            ]);

            return ApiResponse::exito(
                $movimiento->load([
                    'empleado:id,nombre,uuid',
                    'rolAplicado:id,nombre,salario_base,bono_por_hora'
                ]),
                'Registro exitoso',
                201
            );
        } catch (\Exception $e) {
            return ApiResponse::error('Error al guardar el movimiento', 500);
        }
    }

    /**
     * Actualizar un movimiento existente.
     */
    public function actualizar(Request $request, $id): JsonResponse
    {
        $request->validate([
            'fecha' => 'sometimes|date',
            'horas_trabajadas' => 'sometimes|numeric|min:1|max:24',
            'entregas' => 'sometimes|integer|min:0',
            'rol_aplicado_id' => 'nullable|exists:roles,id'
        ]);

        try {
            $movimiento = Movimiento::findOrFail($id);

            $movimiento->update($request->only([
                'fecha',
                'horas_trabajadas',
                'entregas',
                'rol_aplicado_id'
            ]));

            return ApiResponse::exito(
                $movimiento->load('empleado:id,nombre,uuid'),
                'Actualizado correctamente'
            );
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('No se encontró el registro', 404);
        }
    }

    /**
     * Eliminar un movimiento.
     */
    public function eliminar($id): JsonResponse
    {
        try {
            Movimiento::findOrFail($id)->delete();
            return ApiResponse::exito(null, 'Eliminado correctamente');
        } catch (ModelNotFoundException $e) {
            return ApiResponse::error('No se encontró el registro', 404);
        }
    }
}
