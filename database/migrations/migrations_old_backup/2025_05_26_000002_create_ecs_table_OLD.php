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
        Schema::create('ecs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('audiencia_id');            $table->text('numero_resolucion');
            $table->text('observaciones')->nullable();
            $table->unsignedBigInteger('usuario_id');
            $table->integer('numero_folios')->nullable();
            $table->timestamps();

            $table->foreign('audiencia_id')->references('id')->on('audiencias')->onDelete('cascade');
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
        Schema::dropIfExists('ecs');
    }
};
