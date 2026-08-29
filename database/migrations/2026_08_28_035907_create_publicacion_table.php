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
    Schema::create('publicacion', function (Blueprint $table) {
        $table->increments('id_publicacion');
        $table->unsignedTinyInteger('id_tipo');
        $table->unsignedSmallInteger('id_categoria');
        $table->unsignedInteger('id_autor');
        $table->unsignedInteger('id_media_portada')->nullable();
        $table->string('titulo', 200);
        $table->string('slug', 220);
        $table->string('bajada', 500)->nullable();
        $table->enum('estado', [
            'BORRADOR', 'EN_REVISION', 'RECHAZADA', 'PUBLICADA', 'ARCHIVADA',
        ])->default('BORRADOR');
        $table->text('motivo_rechazo')->nullable();
        $table->boolean('destacada')->default(false);
        $table->string('meta_titulo', 70)->nullable();
        $table->string('meta_descripcion', 160)->nullable();
        $table->integer('visitas')->default(0);
        $table->integer('suma_puntos')->default(0);
        $table->integer('cantidad_votos')->default(0);
        $table->decimal('promedio', 3, 2)->virtualAs(
            'CASE WHEN cantidad_votos = 0 THEN NULL ELSE suma_puntos / cantidad_votos END'
        );
        $table->dateTime('fecha_creacion')->useCurrent();
        $table->dateTime('fecha_modificacion')->nullable();
        $table->dateTime('fecha_publicacion')->nullable();

        $table->unique('slug', 'uq_publicacion_slug');
        $table->index(['estado', 'fecha_publicacion'], 'idx_pub_portada');
        $table->index(['id_categoria', 'estado', 'fecha_publicacion'], 'idx_pub_categoria');
        $table->index(['id_tipo', 'estado', 'fecha_publicacion'], 'idx_pub_tipo');
        $table->index(['estado', 'destacada'], 'idx_pub_destacada');
        $table->index('id_autor', 'idx_pub_autor');
        $table->index('id_media_portada', 'idx_pub_portada_media');
        $table->fullText(['titulo', 'bajada'], 'ft_publicacion');

        $table->foreign('id_tipo', 'fk_pub_tipo')
            ->references('id_tipo')->on('tipo_publicacion')
            ->restrictOnDelete()->cascadeOnUpdate();

        $table->foreign('id_categoria', 'fk_pub_categoria')
            ->references('id_categoria')->on('categoria')
            ->restrictOnDelete()->cascadeOnUpdate();

        $table->foreign('id_autor', 'fk_pub_autor')
            ->references('id_usuario')->on('usuario')
            ->restrictOnDelete()->cascadeOnUpdate();

        $table->foreign('id_media_portada', 'fk_pub_portada')
            ->references('id_media')->on('media')
            ->nullOnDelete()->cascadeOnUpdate();
        });

        DB::statement("
            ALTER TABLE publicacion
            ADD CONSTRAINT ck_pub_publicada
                CHECK (estado <> 'PUBLICADA' OR fecha_publicacion IS NOT NULL),
            ADD CONSTRAINT ck_pub_votos
                CHECK (cantidad_votos >= 0 AND suma_puntos >= 0),
            ADD CONSTRAINT ck_pub_motivo
                CHECK (estado <> 'RECHAZADA' OR motivo_rechazo IS NOT NULL)
        ");
}

public function down(): void
{
    Schema::dropIfExists('publicacion');
}
};
