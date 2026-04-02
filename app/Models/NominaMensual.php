<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NominaMensual extends Model
{
    protected $table = 'nominas_mensuales';

    // Desactivamos timestamps estándar porque usamos 'fecha_calculo'
    public $timestamps = false;

    protected $fillable = [
        'empleado_id',
        'mes',
        'anio',
        'horas_total',
        'sueldo_base_total',
        'bonos_total',
        'pago_entregas_total',
        'sueldo_bruto',
        'vales_despensa',
        'isr_retencion',
        'sueldo_neto',
        'fecha_calculo'
    ];

    /**
     *Ocultamos los IDs internos para que no viajen al Frontend.
     * Solo expondremos los montos y los periodos.
     */
    protected $hidden = [
        'id',
        'empleado_id'
    ];

    protected $casts = [
        'mes'                 => 'integer',
        'anio'                => 'integer',
        'horas_total'         => 'decimal:2',
        'sueldo_base_total'   => 'decimal:2',
        'bonos_total'         => 'decimal:2',
        'pago_entregas_total' => 'decimal:2',
        'sueldo_bruto'        => 'decimal:2',
        'vales_despensa'      => 'decimal:2',
        'isr_retencion'       => 'decimal:2',
        'sueldo_neto'         => 'decimal:2',
        'fecha_calculo' => 'string',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }
}
