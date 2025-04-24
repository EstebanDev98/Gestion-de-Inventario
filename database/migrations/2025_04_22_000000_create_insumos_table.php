<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('insumos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('solicitante');
            $table->integer('cantidad');
            $table->date('fecha_prestamo');
            $table->date('fecha_devolucion')->nullable();
            $table->enum('estado', ['Activo', 'Prestado','Devuelto','Agotado']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tabla1insumos');
    }
};