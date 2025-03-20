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
    Schema::create('movimientos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('articulo_id')->constrained('articulos')->onDelete('cascade');
        $table->enum('tipo_movimiento', ['Entrada', 'Salida']);
        $table->dateTime('fecha')->default(now());
        $table->string('usuario');
        $table->text('comentario')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
