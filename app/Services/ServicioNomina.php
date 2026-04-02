<?php

namespace App\Services;

use App\Models\Empleado;
use App\Models\Movimiento;

class ServicioNomina
{
    public function calcular(Empleado $empleado, int $mes, int $anio)
    {
        // Buscamos movimientos usando el ID interno
        $movimientos = Movimiento::where('empleado_id', $empleado->id)
            ->whereMonth('fecha', $mes)
            ->whereYear('fecha', $anio)
            ->get();

        // Si no hay movimientos, el sueldo neto es 0 pero igual calculamos para mostrar detalles
        $totalHoras = $movimientos->sum('horas_trabajadas');

        // Para entregas, sumamos la cantidad total (no importa si es interna o externa, el pago es el mismo)
        $totalEntregas = $movimientos->sum('entregas');

        // Obtenemos el rol para acceder a salario_base y bono_por_hora
        $rol = $empleado->rol;

        // Cálculos
        $pagoBase = $totalHoras * $rol->salario_base;
        $bonoRol = $totalHoras * $rol->bono_por_hora;
        $pagoEntregas = $totalEntregas * 5.00;

        // Sueldo Bruto antes de deducciones
        $sueldoBruto = $pagoBase + $bonoRol + $pagoEntregas;

        // Deducciones
        $vales = $empleado->es_interno ? ($sueldoBruto * 0.04) : 0;
        $tasaISR = ($sueldoBruto > 10000) ? 0.12 : 0.09;
        $isr = $sueldoBruto * $tasaISR;


        // Sueldo Neto después de deducciones
        $sueldoNeto = ($sueldoBruto - $isr) + $vales;

        // Retornamos un array con todos los detalles del cálculo para mostrar en el resumen
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
