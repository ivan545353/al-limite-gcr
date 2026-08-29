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
        Schema::create('pagina_estatica', function (Blueprint $table) {
            $table->smallIncrements('id_pagina');
            $table->string('clave', 50);
            $table->string('titulo', 150);
            $table->string('slug', 150);
            $table->mediumText('contenido');
            $table->unsignedInteger('id_usuario');
            $table->dateTime('fecha_modificacion')->useCurrent();

            $table->unique('clave', 'uq_pagina_clave');
            $table->unique('slug', 'uq_pagina_slug');
            $table->index('id_usuario', 'idx_pagina_usuario');

            $table->foreign('id_usuario', 'fk_pagina_usuario')
                ->references('id_usuario')->on('usuario')
                ->restrictOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagina_estatica');
    }
};
