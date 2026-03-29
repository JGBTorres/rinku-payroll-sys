<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla: empleados
 *
 * Contiene la información general de los empleados.
 */
return new class extends Migration
{
    /**
     * Ejecuta la migración.
     */
    public function up(): void
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id(); // Identificador interno

            $table->uuid('uuid')->unique();
            // Identificador único global (UUID)

            $table->string('numero_empleado')->unique();
            // Número interno de empleado

            $table->string('nombre');
            // Nombre completo del empleado

            $table->boolean('es_interno');
            // Indica si el empleado es interno (true) o subcontratado (false)

            $table->foreignId('rol_id')
                ->constrained('roles')
                ->restrictOnDelete();
            // Rol base del empleado con la relación a la tabla de roles

            $table->date('fecha_ingreso');
            // Fecha en la que el empleado ingresó a la empresa

            $table->boolean('activo')->default(true);
            // Indica si el empleado sigue activo
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
