<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movimiento extends Model
{
    use  SoftDeletes;


    protected $table = 'movimientos';

    protected $fillable = [
        'empleado_id',
        'fecha',
        'horas_trabajadas',
        'entregas',
        'rol_aplicado_id'
    ];

    // Relación con el empleado
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }
}
