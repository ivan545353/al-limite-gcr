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
       Schema::create('envio_newsletter', function (Blueprint $table) {
            $table->increments('id_envio');
            $table->dateTime('fecha_programada');
            $table->dateTime('fecha_envio')->nullable();
            $table->enum('estado', ['PENDIENTE', 'ENVIADO', 'FALLIDO'])->default('PENDIENTE');
            $table->unsignedInteger('cantidad_destinatarios')->nullable();
            $table->string('id_mensaje_proveedor', 120)->nullable();
            $table->text('detalle_error')->nullable();

            $table->unique('fecha_programada', 'uq_envio_fecha');
            $table->index(['estado', 'fecha_programada'], 'idx_envio_estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('envio_newsletter');
    }
};
