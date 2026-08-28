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
        Schema::create('categoria', function (Blueprint $table) {
            $table->smallIncrements('id_categoria');
            $table->string('nombre', 60);
            $table->string('slug', 60);
            $table->boolean('activo')->default(true);

            $table->unique('nombre', 'uq_categoria_nombre');
            $table->unique('slug', 'uq_categoria_slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categoria');
    }
};
