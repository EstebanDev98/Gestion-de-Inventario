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
        Schema::create('iinsumos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('codigo_referencia')->unique();
            $table->string('descripcion')->nullable();
            $table->string('unidad_medida');
            $table->integer('cantidad')->default(0);
            $table->string('ubicacion');
            $table->unsignedBigInteger('estado_id'); //FK
            $table->timestamps();

            $table->foreign('estado_id')->references('id')->on('estados')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iinsumos');
    }
};
