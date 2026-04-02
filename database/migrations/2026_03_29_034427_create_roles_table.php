<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla: roles
 *
 * Almacena los diferentes tipos de roles que puede desempeñar un empleado,
 * junto con su salario base y bono adicional por hora trabajada.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->decimal('salario_base', 10, 2);
            $table->decimal('bono_por_hora', 10, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
