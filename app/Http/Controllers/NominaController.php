<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\NominaMensual;
use App\Services\ServicioNomina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Responses\ApiResponse;

/**
 * Controlador para el cálculo de nómina mensual.
 */
class NominaController extends Controller
{
    protected $servicio;

    public function __construct(ServicioNomina $servicio)
    {
        $this->servicio = $servicio;
    }

    /**
     * Calcular nómina de un mes específico.
     * Se puede calcular para todos los empleados o uno en particular.
     */
    public function calcularMes(Request $request)
    {
        $request->validate([
            'mes'  => 'required|integer|between:1,12',
            'anio' => 'required|integer|min:2020',
            'uuid' => 'nullable|exists:empleados,uuid',
        ]);

        // --- VALIDACIÓN DE DUPLICADOS ---
        // Verificamos si ya existe nómina generada en la tabla de resultados
        $existeQuery = NominaMensual::where('mes', $request->mes)
            ->where('anio', $request->anio);

        // Si se pide un empleado específico, validamos solo a ese
        if ($request->filled('uuid')) {
            $existeQuery->whereHas('empleado', function ($q) use ($request) {
                $q->where('uuid', $request->uuid);
            });
        }

        if ($existeQuery->exists()) {
            $mensaje = $request->filled('uuid')
                ? "La nómina de este empleado para {$request->mes}/{$request->anio} ya fue generada."
                : "La nómina general para el periodo {$request->mes}/{$request->anio} ya existe.";

            return ApiResponse::error($mensaje, 422);
        }
        // --- FIN VALIDACIÓN ---

        $consulta = Empleado::where('activo', true);

        if ($request->filled('uuid')) {
            $consulta->where('uuid', $request->uuid);
        }

        $empleados = $consulta->get();

        if ($empleados->isEmpty()) {
            return ApiResponse::error('No se encontraron empleados para procesar.', 404);
        }

        $resultados = [];

        DB::beginTransaction();
        try {
            foreach ($empleados as $empleado) {
                $datos = $this->servicio->calcular(
                    $empleado,
                    $request->mes,
                    $request->anio
                );

                // Al validar arriba, ya no hay riesgo de duplicados accidentales
                $resultados[] = NominaMensual::create(array_merge([
                    'empleado_id' => $empleado->id,
                    'mes'         => $request->mes,
                    'anio'        => $request->anio
                ], $datos));
            }

            DB::commit();

            return ApiResponse::exito($resultados, 'Cálculo terminado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error("Error en el proceso: " . $e->getMessage(), 500);
        }
    }
}
