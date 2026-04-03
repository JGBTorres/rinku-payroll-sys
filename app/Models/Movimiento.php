<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\Empleado;
use App\Models\Rol;

class Movimiento extends Model
{
    protected $table = 'movimientos';

    //Campos que se pueden asignar masivamente
    protected $fillable = [
        'empleado_id',
        'fecha',
        'horas_trabajadas',
        'entregas',
        'rol_aplicado_id'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    //Convertir tipos de datos
    protected $casts = [
        'fecha'            => 'date:Y-m-d',
        'horas_trabajadas' => 'float',
        'entregas'         => 'integer',
        'rol_aplicado_id'  => 'integer',
    ];
    //Relacion de un movimiento con un empleado
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }

    //Relacion de un movimiento con un rol aplicado
    public function rolAplicado()
    {
        return $this->belongsTo(Rol::class, 'rol_aplicado_id');
    }
}
