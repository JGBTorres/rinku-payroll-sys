<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla: movimientos
 * * Registra las actividades diarias para el cálculo de nómina:
 * - Entregas realizadas (Bono $5)
 * - Horas trabajadas (Sueldo base + Bonos por rol)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            // Relación con el empleado
            $table->foreignId('empleado_id')->constrained('empleados')->cascadeOnDelete();
            $table->date('fecha');
            $table->decimal('horas_trabajadas', 5, 2);
            $table->integer('entregas');
            // El rol que tenía el empleado al momento de este movimiento
            $table->foreignId('rol_aplicado_id')->constrained('roles')->restrictOnDelete();

            $table->index(['empleado_id', 'fecha']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
