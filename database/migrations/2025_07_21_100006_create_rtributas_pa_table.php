<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRtributasPaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rtributas_pa', function (Blueprint $table) {
            $table->id();
            $table->string('numero_resolucion');
            $table->date('fecha');
            $table->enum('tipo_resolucion', ['total a favor', 'total en contra', 'parcial', 'nulidad', 'penal']);
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('audiencia_pa_id');
            $table->string('archivo')->nullable();
            $table->string('tipo_archivo')->nullable();
            $table->text('observaciones')->nullable();
            $table->integer('numero_folios')->nullable();
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('audiencia_pa_id')->references('id')->on('audiencias_pa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rtributas_pa');
    }
}
