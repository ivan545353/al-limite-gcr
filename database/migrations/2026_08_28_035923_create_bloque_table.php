<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
public function up(): void
{
    Schema::create('bloque', function (Blueprint $table) {
        $table->increments('id_bloque');
        $table->unsignedInteger('id_publicacion');
        $table->unsignedInteger('id_media')->nullable();
        $table->enum('tipo', ['TEXTO', 'IMAGEN', 'VIDEO', 'CITA']);
        $table->text('contenido')->nullable();
        $table->string('epigrafe', 255)->nullable();
        $table->unsignedSmallInteger('orden');

        $table->unique(['id_publicacion', 'orden'], 'uq_bloque_orden');
        $table->index('id_media', 'idx_bloque_media');
        $table->fullText('contenido', 'ft_bloque');

        $table->foreign('id_publicacion', 'fk_bloque_publicacion')
            ->references('id_publicacion')->on('publicacion')
            ->cascadeOnDelete()->cascadeOnUpdate();

        $table->foreign('id_media', 'fk_bloque_media')
            ->references('id_media')->on('media')
            ->restrictOnDelete();
    });

    DB::statement("
        ALTER TABLE bloque
        ADD CONSTRAINT ck_bloque_coherencia CHECK (
            (tipo IN ('TEXTO','CITA') AND contenido IS NOT NULL AND id_media IS NULL)
         OR (tipo = 'IMAGEN' AND id_media IS NOT NULL)
         OR (tipo = 'VIDEO'  AND contenido IS NOT NULL AND id_media IS NULL)
        )
    ");
}

public function down(): void
{
    Schema::dropIfExists('bloque');
}
};
