<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecs_pa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('audiencia_pa_id');
            $table->text('numero_resolucion');
            $table->text('observaciones')->nullable();
            $table->unsignedBigInteger('usuario_id');
            $table->integer('numero_folios')->nullable();
            $table->timestamps();

            $table->foreign('audiencia_pa_id')->references('id')->on('audiencias_pa')->onDelete('cascade');
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ecs_pa');
    }
};
