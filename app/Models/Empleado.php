<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Modelo Empleado.
 */
class Empleado extends Model
{
    protected $table = 'empleados';



    protected $fillable = [
        'uuid',
        'numero_empleado',
        'nombre',
        'es_interno',
        'rol_id',
        'fecha_ingreso',
        'activo'
    ];

    protected $casts = [
        'es_interno' => 'boolean',
        'activo' => 'boolean',
        'fecha_ingreso' => 'date',
    ];

    protected $hidden = [
        'id',
        'rol_id',
        'created_at',
        'updated_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($empleado) {
            if (empty($empleado->uuid)) {
                $empleado->uuid = Str::uuid();
            }
        });
    }
    /**
     * Usa el UUID para las búsquedas en rutas en lugar del ID.
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }


    public function rol()
    {
        return $this->belongsTo(Role::class, 'rol_id');
    }

    //Relación con sus registros de horas y entregas
    public function movimientos()
    {
        return $this->hasMany(Movimiento::class, 'empleado_id');
    }

    //Relación con sus recibos de nómina terminados
    public function nominas()
    {
        return $this->hasMany(NominaMensual::class, 'empleado_id');
    }
}
