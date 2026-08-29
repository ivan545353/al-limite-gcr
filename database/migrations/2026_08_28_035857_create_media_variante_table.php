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
        Schema::create('media_variante', function (Blueprint $table) {
        $table->increments('id_variante');
        $table->unsignedInteger('id_media');
        $table->string('ruta', 255);
        $table->enum('formato', ['WEBP', 'JPEG']);
        $table->unsignedInteger('ancho');
        $table->unsignedInteger('alto');
        $table->unsignedInteger('tamano_bytes')->nullable();

        $table->unique(['id_media', 'formato', 'ancho'], 'uq_variante');

        $table->foreign('id_media', 'fk_variante_media')
            ->references('id_media')->on('media')
            ->cascadeOnDelete()->cascadeOnUpdate();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_variante');
    }
};
