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
        'horas_total'         => 'float',
        'sueldo_base_total'   => 'float',
        'bonos_total'         => 'float',
        'pago_entregas_total' => 'float',
        'sueldo_bruto'        => 'float',
        'vales_despensa'      => 'float',
        'isr_retencion'       => 'float',
        'sueldo_neto'         => 'float',
        'fecha_calculo'       => 'datetime',
    ];
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }
}
