<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla: nominas_mensuales
 *
 * Almacena el resultado del cálculo de nómina por empleado, mes y año.
 */
return new class extends Migration
{
    /**
     * Ejecuta la migración.
     */
    public function up(): void
    {
        Schema::create('nominas_mensuales', function (Blueprint $table) {
            $table->id(); // Identificador de la nómina

            $table->foreignId('empleado_id')
                ->constrained('empleados')
                ->cascadeOnDelete();
            // Empleado al que pertenece la nómina

            $table->tinyInteger('mes');
            $table->integer('anio');

            $table->decimal('horas_total', 5, 2);
            // Total de horas trabajadas en el mes

            $table->decimal('sueldo_base_total', 12, 2);
            // Pago base por horas trabajadas

            $table->decimal('bonos_total', 12, 2);
            // Total de bonos por rol

            $table->decimal('pago_entregas_total', 12, 2);
            // Pago adicional por entregas realizadas

            $table->decimal('sueldo_bruto', 12, 2);
            // Suma de sueldo base + bonos + entregas

            $table->decimal('vales_despensa', 12, 2)->nullable();
            // Vales de despensa (solo empleados internos)

            $table->decimal('isr_retencion', 12, 2);
            // Impuesto retenido

            $table->decimal('sueldo_neto', 12, 2);
            // Sueldo final después de impuestos y con vales

            $table->timestamp('fecha_calculo');
            // Momento en que se realizó el cálculo

            $table->unique(['empleado_id', 'mes', 'anio']);
            // Evita duplicar nóminas del mismo empleado en el mismo periodo
        });
    }

    /**
     * Revierte la migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('nominas_mensuales');
    }
};
