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
        Schema::create('usuario', function (Blueprint $table) {
        $table->increments('id_usuario');
        $table->string('nombre', 60);
        $table->string('apellido', 60);
        $table->string('email', 150);
        $table->string('password_hash', 255);
        $table->enum('rol', ['ADMINISTRADOR', 'OPERARIO']);
        $table->string('rol_publico', 60)->nullable();
        $table->text('descripcion')->nullable();
        $table->string('foto', 255)->nullable();
        $table->boolean('activo')->default(true);
        $table->boolean('debe_cambiar_password')->default(true);
        $table->unsignedSmallInteger('intentos_fallidos')->default(0);
        $table->dateTime('bloqueado_hasta')->nullable();
        $table->dateTime('ultimo_acceso')->nullable();
        $table->dateTime('fecha_creacion')->useCurrent();

        $table->unique('email', 'uq_usuario_email');
        $table->index(['rol', 'activo'], 'idx_usuario_rol');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
