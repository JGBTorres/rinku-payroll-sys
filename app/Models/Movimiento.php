<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $table = 'movimientos';

    protected $fillable = [
        'empleado_id',
        'fecha',
        'horas_trabajadas',
        'entregas',
        'rol_aplicado_id'
    ];

    /**
     *No exponer campos sensibles o innecesarios en las respuestas JSON.
     */
    protected $hidden = [
        // 'id',
        'empleado_id',
        'rol_aplicado_id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'fecha'            => 'date',
        'horas_trabajadas' => 'integer',
        'entregas'         => 'integer',
    ];

    /**
     * Relación: Un movimiento pertenece a un empleado.
     */
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }

    /**
     * Relación: El rol que se usó para calcular este movimiento.
     */
    public function rol()
    {
        return $this->belongsTo(Role::class, 'rol_aplicado_id');
    }
}
