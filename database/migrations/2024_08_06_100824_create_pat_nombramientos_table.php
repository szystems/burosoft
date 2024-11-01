<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatNombramientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pat_nombramientos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pat_id');
            $table->string('no');
            $table->date('fecha');
            $table->string('nombrado_1');
            $table->string('nombrado_2')->nullable();
            $table->string('nombrado_3')->nullable();
            $table->string('nombrado_4')->nullable();
            $table->string('nombrado_5')->nullable();
            $table->string('periodo');
            $table->string('archivo');
            $table->string('tipo');
            $table->unsignedBigInteger('usuario_id');
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
        Schema::dropIfExists('pat_nombramientos');
    }
}
