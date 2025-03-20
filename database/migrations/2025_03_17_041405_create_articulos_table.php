<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('articulos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('modelo_id')->constrained('modelos')->onDelete('cascade');
        $table->string('numero_serie')->nullable()->unique(); // Permite valores vacíos, pero si existe, debe ser único
        $table->enum('estado', ['Disponible', 'Asignado', 'En reparación', 'Baja'])->default('Disponible');
        $table->foreignId('ubicacion_id')->nullable()->constrained('ubicaciones')->onDelete('set null');
        $table->date('fecha_ingreso')->default(now());
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articulos');
    }
};
