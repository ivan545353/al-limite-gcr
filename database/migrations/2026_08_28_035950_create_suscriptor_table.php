<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('suscriptor', function (Blueprint $table) {
            $table->increments('id_suscriptor');
            $table->string('email', 150);
            $table->enum('estado', ['PENDIENTE', 'ACTIVO', 'BAJA'])->default('PENDIENTE');
            $table->char('token_confirmacion', 36)->nullable();
            $table->char('token_baja', 36);
            $table->dateTime('fecha_alta')->useCurrent();
            $table->dateTime('fecha_confirmacion')->nullable();
            $table->dateTime('fecha_baja')->nullable();

            $table->unique('email', 'uq_suscriptor_email');
            $table->unique('token_confirmacion', 'uq_suscriptor_confirmacion');
            $table->unique('token_baja', 'uq_suscriptor_baja');
            $table->index('estado', 'idx_suscriptor_estado');
        });

        DB::statement("
            ALTER TABLE suscriptor
            ADD CONSTRAINT ck_suscriptor_confirmado
                CHECK (estado <> 'ACTIVO' OR fecha_confirmacion IS NOT NULL)
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suscriptor');
    }
};
