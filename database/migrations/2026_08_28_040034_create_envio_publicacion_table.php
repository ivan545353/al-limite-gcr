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
        Schema::create('envio_publicacion', function (Blueprint $table) {
            $table->unsignedInteger('id_envio');
            $table->unsignedInteger('id_publicacion');

            $table->primary(['id_envio', 'id_publicacion']);
            $table->index('id_publicacion', 'idx_ep_publicacion');

            $table->foreign('id_envio', 'fk_ep_envio')
                ->references('id_envio')->on('envio_newsletter')
                ->cascadeOnDelete()->cascadeOnUpdate();

            $table->foreign('id_publicacion', 'fk_ep_publicacion')
                ->references('id_publicacion')->on('publicacion')
                ->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('envio_publicacion');
    }
};
