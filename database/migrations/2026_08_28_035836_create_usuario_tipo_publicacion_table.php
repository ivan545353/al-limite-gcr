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
        Schema::create('usuario_tipo_publicacion', function (Blueprint $table) {
            $table->unsignedInteger('id_usuario');
            $table->unsignedTinyInteger('id_tipo');

            $table->primary(['id_usuario', 'id_tipo']);
            $table->index('id_tipo', 'idx_utp_tipo');

            $table->foreign('id_usuario', 'fk_utp_usuario')
                ->references('id_usuario')->on('usuario')
                ->cascadeOnDelete()->cascadeOnUpdate();

            $table->foreign('id_tipo', 'fk_utp_tipo')
                ->references('id_tipo')->on('tipo_publicacion')
                ->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario_tipo_publicacion');
    }
};
