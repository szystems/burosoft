<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmpmrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ampmrs', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha_hora_presentacion');
            $table->string('numero_documento');
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('audiencia_id');
            $table->string('archivo')->nullable();
            $table->string('tipo_archivo')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('audiencia_id')->references('id')->on('audiencias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ampmrs');
    }
}
