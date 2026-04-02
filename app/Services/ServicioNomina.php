<?php

namespace App\Services;

use App\Models\Empleado;
use App\Models\Movimiento;

/**
 * Servicio encargado del cálculo de nómina mensual.
 */
class ServicioNomina
{
    /**
     * Calcula la nómina de un empleado en un mes específico.
     */
    public function calcular(Empleado $empleado, int $mes, int $anio)
    {
        $movimientos = Movimiento::with('rolAplicado')
            ->where('empleado_id', $empleado->id)
            ->whereMonth('fecha', $mes)
            ->whereYear('fecha', $anio)
            ->get();

        $totalHoras = $movimientos->sum('horas_trabajadas');
        $totalEntregas = $movimientos->sum('entregas');

        $pagoBase = $totalHoras * 30.00;

        $bonoRol = 0;
        foreach ($movimientos as $mov) {
            $bono = optional($mov->rolAplicado)->bono_por_hora ?? 0;
            $bonoRol += ($mov->horas_trabajadas * $bono);
        }

        $pagoEntregas = $totalEntregas * 5.00;

        $sueldoBruto = $pagoBase + $bonoRol + $pagoEntregas;

        $vales = $empleado->es_interno ? ($sueldoBruto * 0.04) : 0;

        $tasaISR = ($sueldoBruto > 16000) ? 0.12 : 0.09;
        $isr = $sueldoBruto * $tasaISR;

        $sueldoNeto = ($sueldoBruto - $isr) + $vales;

        return [
            'empleado_id'         => $empleado->id,
            'mes'                 => $mes,
            'anio'                => $anio,
            'horas_total'         => $totalHoras,
            'sueldo_base_total'   => $pagoBase,
            'bonos_total'         => $bonoRol,
            'pago_entregas_total' => $pagoEntregas,
            'sueldo_bruto'        => $sueldoBruto,
            'vales_despensa'      => $vales,
            'isr_retencion'       => $isr,
            'sueldo_neto'         => $sueldoNeto,
            'fecha_calculo'       => now(),
        ];
    }
}
