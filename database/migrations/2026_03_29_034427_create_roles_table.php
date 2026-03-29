<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla: roles
 *
 * Almacena los diferentes tipos de roles que puede desempeñar un empleado
 * junto con su bono adicional por hora trabajada.
 */
return new class extends Migration
{
    /**
     * Ejecuta la migración.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id(); // Identificador único del rol

            $table->string('nombre'); // Nombre del rol (Chofer, Cargador, Auxiliar)

            $table->decimal('bono_por_hora', 10, 2);
            // Bono adicional que se paga por cada hora trabajada en este rol
        });
    }

    /**
     * Revierte la migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
