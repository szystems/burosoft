<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResolucionsPaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resolucions_pa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('audiencia_pa_id');
            $table->enum('tipo_resolucion', ['total a favor', 'total en contra', 'parcial', 'nulidad', 'penal'])->nullable();
            $table->string('numero_folios')->nullable();
            $table->text('contenido_resolucion')->nullable();
            $table->date('fecha_resolucion')->nullable();
            $table->string('archivo')->nullable();
            $table->string('estado')->nullable();
            $table->timestamps();

            $table->foreign('audiencia_pa_id')->references('id')->on('audiencias_pa')->onDelete('cascade');
            $table->index('audiencia_pa_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resolucions_pa');
    }
}