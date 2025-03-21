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
        Schema::create('ubicaciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->text('descripcion')->nullable();
            $table->timestamps(); // Añadimos timestamps para controlar creación y actualización
            $table->softDeletes(); // Añadimos soft deletes para mantener historial
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ubicaciones');
    }
};