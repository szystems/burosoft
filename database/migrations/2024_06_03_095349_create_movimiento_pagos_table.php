<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovimientoPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimiento_pagos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('movimiento_id');
            $table->text('descripcion')->nullable();
            $table->string('forma_pago');
            $table->string('numero_documento')->nullable();
            $table->string('banco')->nullable();
            $table->string('numero_cuenta')->nullable();
            $table->date('fecha_documento')->nullable();
            $table->string('imagen')->nullable();
            $table->unsignedBigInteger('usuario_id');
            $table->decimal('monto_q', 8, 2)->default(0.00);
            $table->decimal('monto_d', 8, 2)->default(0.00);
            $table->string('codigo');
            $table->boolean('estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movimiento_pagos');
    }
}
