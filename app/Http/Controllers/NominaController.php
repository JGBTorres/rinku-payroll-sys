<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\NominaMensual;
use App\Services\ServicioNomina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NominaController extends Controller
{
    protected $servicio;

    public function __construct(ServicioNomina $servicio)
    {
        $this->servicio = $servicio;
    }

    public function calcularMes(Request $request)
    {
        $request->validate([
            'mes'  => 'required|integer|between:1,12',
            'anio' => 'required|integer|min:2020',
            'uuid' => 'nullable|exists:empleados,uuid',
        ]);

        $consulta = Empleado::where('activo', true);

        // Si mandas el uuid, filtramos por él
        if ($request->has('uuid')) {
            $consulta->where('uuid', $request->uuid);
        }

        $empleados = $consulta->get();
        $resultados = [];

        DB::beginTransaction();
        try {
            foreach ($empleados as $empleado) {
                $datos = $this->servicio->calcular($empleado, $request->mes, $request->anio);

                $resultados[] = NominaMensual::updateOrCreate(
                    [
                        'empleado_id' => $empleado->id,
                        'mes'         => $request->mes,
                        'anio'        => $request->anio
                    ],
                    $datos
                );
            }
            DB::commit();
            return response()->json(['mensaje' => 'Cálculo terminado', 'datos' => $resultados]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
