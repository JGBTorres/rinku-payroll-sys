<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Role.
 */
class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'nombre',
        'salario_base',
        'bono_por_hora'
    ];

    public $timestamps = false;

    protected $hidden = [
        'id',
    ];

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'rol_id');
    }
}
