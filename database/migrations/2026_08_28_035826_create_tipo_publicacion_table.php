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
        Schema::create('tipo_publicacion', function (Blueprint $table) {
            $table->tinyIncrements('id_tipo');
            $table->string('nombre', 40);
            $table->string('slug', 40);

            $table->unique('nombre', 'uq_tipo_nombre');
            $table->unique('slug', 'uq_tipo_slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_publicacion');
    }
};
