<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('media', function (Blueprint $table) {
        $table->increments('id_media');
        $table->unsignedInteger('id_usuario');
        $table->string('nombre_original', 255);
        $table->string('ruta_original', 255);
        $table->string('alt', 255);
        $table->string('credito', 120)->nullable();
        $table->string('mime', 60);
        $table->unsignedInteger('ancho')->nullable();
        $table->unsignedInteger('alto')->nullable();
        $table->unsignedInteger('tamano_bytes')->nullable();
        $table->dateTime('fecha_subida')->useCurrent();

        $table->index('id_usuario', 'idx_media_usuario');

        $table->foreign('id_usuario', 'fk_media_usuario')
            ->references('id_usuario')->on('usuario')
            ->restrictOnDelete()->cascadeOnUpdate();
    });

    DB::statement("
        ALTER TABLE media
        ADD CONSTRAINT ck_media_alt
        CHECK (CHAR_LENGTH(TRIM(alt)) >= 3)
    ");
}

public function down(): void
{
    Schema::dropIfExists('media');
}
};
