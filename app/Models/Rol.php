<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Rol.
 *
 * Representa los roles que puede tener un empleado dentro del sistema,
 * incluyendo su salario base y bono por hora.
 */
class Rol extends Model
{

    // Nombre de la tabla asociada.

    protected $table = 'roles';

    // Campos que se pueden asignar masivamente.
    protected $fillable = [
        'nombre',
        'salario_base',
        'bono_por_hora'
    ];

    // Desactivar timestamps
    public $timestamps = false;

    //Relacion de un rol con muchos empleados
    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'rol_id');
    }
}
