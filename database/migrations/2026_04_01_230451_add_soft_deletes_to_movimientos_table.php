<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('movimientos', function (Blueprint $table) {
            // Esta línea crea la columna 'deleted_at'
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('movimientos', function (Blueprint $table) {
            // Esta línea la elimina si decidimos echar atrás el cambio
            $table->dropSoftDeletes();
        });
    }
};
