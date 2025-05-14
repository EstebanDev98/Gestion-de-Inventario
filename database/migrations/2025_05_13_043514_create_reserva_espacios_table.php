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
        Schema::create('reserva_espacios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('espacio_id')->constrained('espacios');
            $table->date('fecha_reserva');
            $table->time('hora_inicial');
            $table->time('hora_final');
            $table->enum('estado',['pendiente', 'finalizada','cancelada']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserva_espacios');
    }
};
