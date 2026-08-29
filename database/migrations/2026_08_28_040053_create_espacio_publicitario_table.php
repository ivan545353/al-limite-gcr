<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('espacio_publicitario', function (Blueprint $table) {
            $table->tinyIncrements('id_espacio');
            $table->string('clave', 50);
            $table->string('nombre', 100);
            $table->text('codigo')->nullable();
            $table->boolean('activo')->default(false);
            $table->dateTime('fecha_modificacion')->nullable();

            $table->unique('clave', 'uq_espacio_clave');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('espacio_publicitario');
    }
};
