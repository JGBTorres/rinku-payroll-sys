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
    public function up(): void
    {
        Schema::create('nominas_mensuales', function (Blueprint $table) {
            $table->id();
            // Relación con empleados
            $table->foreignId('empleado_id')
                ->constrained('empleados')
                ->cascadeOnDelete();
            // Mes y año de la nómina
            $table->tinyInteger('mes');
            $table->integer('anio');

            // Totales calculados
            $table->decimal('horas_total', 5, 2);

            $table->decimal('sueldo_base_total', 12, 2);
            $table->decimal('bonos_total', 12, 2);
            $table->decimal('pago_entregas_total', 12, 2);

            $table->decimal('sueldo_bruto', 12, 2);

            $table->decimal('vales_despensa', 12, 2)->nullable();

            $table->decimal('isr_retencion', 12, 2);

            $table->decimal('sueldo_neto', 12, 2);

            $table->timestamp('fecha_calculo')->useCurrent();

            $table->unique(['empleado_id', 'mes', 'anio']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nominas_mensuales');
    }
};
