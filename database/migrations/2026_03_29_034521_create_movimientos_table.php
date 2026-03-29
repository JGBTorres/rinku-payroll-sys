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
       Schema::create('empleados', function (Blueprint $table) {
    $table->id();
    $table->uuid('uuid')->unique()->default(DB::raw('gen_random_uuid()'));
    $table->string('numero_empleado')->unique();
    $table->string('nombre');
    $table->boolean('is_interno');
    $table->foreignId('role_id')->constrained('roles')->restrictOnDelete();
    $table->date('fecha_ingreso');
    $table->boolean('activo')->default(true);
    $table->timestamps();
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
