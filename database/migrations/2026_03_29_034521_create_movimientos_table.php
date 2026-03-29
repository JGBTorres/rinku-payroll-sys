<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla: movimientos
 *
 * Registra las actividades diarias de los empleados,
 * incluyendo horas trabajadas, entregas realizadas y rol desempeñado.
 */
return new class extends Migration
{
    /**
     * Ejecuta la migración.
     */
    public function up(): void
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id(); // Identificador del movimiento

            $table->foreignId('empleado_id')
                ->constrained('empleados')
                ->cascadeOnDelete();
            // Empleado al que pertenece el movimiento

            $table->date('fecha');
            // Fecha en que se realizó la actividad

            $table->decimal('horas_trabajadas', 5, 2);
            // Número de horas trabajadas en el día

            $table->integer('entregas');
            // Cantidad de entregas realizadas

            $table->foreignId('rol_aplicado_id')
                ->constrained('roles')
                ->restrictOnDelete();
            // Rol desempeñado en ese día (puede diferir del rol base)
        });
    }

    /**
     * Revierte la migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
