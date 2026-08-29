<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('valoracion', function (Blueprint $table) {
        $table->increments('id_valoracion');
        $table->unsignedInteger('id_publicacion');
        $table->char('voter_token', 36);
        $table->unsignedTinyInteger('valor');
        $table->char('ip_hash', 64);
        $table->char('ua_hash', 64)->nullable();
        $table->boolean('sospechosa')->default(false);
        $table->dateTime('fecha_creacion')->useCurrent();
        $table->dateTime('fecha_modificacion')->nullable();

        $table->unique(['id_publicacion', 'voter_token'], 'uq_valoracion_token');
        $table->index(['id_publicacion', 'ip_hash', 'fecha_creacion'], 'idx_valoracion_ip');

        $table->foreign('id_publicacion', 'fk_valoracion_publicacion')
            ->references('id_publicacion')->on('publicacion')
            ->cascadeOnDelete()->cascadeOnUpdate();
    });

    DB::statement("
        ALTER TABLE valoracion
        ADD CONSTRAINT ck_valoracion_valor CHECK (valor BETWEEN 1 AND 5)
    ");
}

public function down(): void
{
    Schema::dropIfExists('valoracion');
}
};
